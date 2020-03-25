<?php
/**
 * Get list processor for SuperBoxSelect TV.
 *
 * @package superboxselect
 * @subpackage processor
 */

class SuperboxselectUsersGetListProcessor extends modObjectGetListProcessor
{
    /**
     * @var string $classKey
     */
    public $classKey = 'modUser';
    /**
     * @var array $languageTopics
     */
    public $languageTopics = array('superboxselect:default');
    /**
     * @var string $defaultSortField
     */
    public $defaultSortField = 'username';
    /**
     * @var string $defaultSortDirection
     */
    public $defaultSortDirection = 'ASC';
    /**
     * @var string $objectType
     */
    public $objectType = 'superboxselect.users';

    /**
     * @return bool
     */
    public function beforeQuery()
    {
        $valuesqry = $this->getProperty('valuesqry');
        if (!empty($valuesqry)) {
            $this->setProperty('limit', 0);
        }
        return true;
    }

    /**
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        // Get Properties
        $allowedUsergroups = $this->getProperty('allowedUsergroups');
        $deniedUsergroups = $this->getProperty('deniedUsergroups');

        // Get query
        $query = $this->getProperty('query');
        if (!empty($query)) {
            $valuesqry = $this->getProperty('valuesqry');
            if (!empty($valuesqry)) {
                $c->where(array(
                    'id:IN' => explode('||', $query)
                ));
            } else {
                $c->where(array(
                    'username:LIKE' => '%' . $query . '%'
                ));
            }
        }

        $c->select($this->modx->getSelectColumns($this->classKey, $this->classKey, '', array('id', 'username')));

        if ($allowedUsergroups || $deniedUsergroups) {
            $c->leftJoin('modUserGroupMember', 'modUserGroupMember', array('modUserGroupMember.member = modUser.id'));
            $c->leftJoin('modUserGroup', 'modUserGroup', array('modUserGroup.id = modUserGroupMember.user_group'));
            $c->groupby('modUser.id');
            if ($allowedUsergroups) {
                $allowedUsergroups = explode(',', $allowedUsergroups);
                $c->where(array(
                    'modUserGroup.name:IN' => $allowedUsergroups
                ));
            }
            if ($deniedUsergroups) {
                $deniedUsergroups = explode(',', $deniedUsergroups);
                $c->where(array(
                    array(
                        'modUserGroup.name:NOT IN' => $deniedUsergroups,
                        'OR:modUserGroup.name:IS' => null
                    )
                ));
            }
        }

        // Exclude original value
        $originalValue = $this->getProperty('originalValue');
        if ($originalValue) {
            $originalValue = array_map('trim', explode('||', $originalValue));
            $c->where(array(
                'id:NOT IN' => $originalValue
            ));
        }

        if ($this->modx->getOption('superboxselect.debug', null, false)) {
            $c->prepare();
            $this->modx->log(xPDO::LOG_LEVEL_ERROR, $c->toSQL());
        }
        return $c;
    }

    /**
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryAfterCount(xPDOQuery $c)
    {
        $id = $this->getProperty('id');
        if (!empty($id)) {
            $c->where(array(
                'id:IN' => array_map('intval', explode('||', $id))
            ));
        }
        $c->sortby($this->getProperty('defaultSortField'), $this->getProperty('defaultSortDirection'));
        return $c;
    }

    /**
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        return array(
            'id' => $object->get('id'),
            'title' => $object->get('username')
        );
    }
}

return 'SuperboxselectUsersGetListProcessor';
