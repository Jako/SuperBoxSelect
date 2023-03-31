<?php
/**
 * Get list users processor
 *
 * @package superboxselect
 * @subpackage processors
 */

use TreehillStudio\SuperBoxSelect\Processors\ObjectGetListProcessor;

class SuperboxselectUsersGetListProcessor extends ObjectGetListProcessor
{
    public $classKey = 'modUser';
    public $defaultSortField = 'username';
    public $defaultSortDirection = 'ASC';

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
        $tvid = $this->getProperty('tvid', 0);
        /** @var modTemplateVar $tv */
        $tv = $this->modx->getObject('modTemplateVar', $tvid);
        if ($tv) {
            $tvProperties = $tv->get('input_properties');
        } elseif ($this->getProperty('useRequest', 0)) {
            $tvProperties = $this->getProperties();
        } else {
            $tvProperties = [];
            $c->where(['id' => 0]);
            $this->modx->log(xPDO::LOG_LEVEL_ERROR, 'Invalid template variable ID!', '', 'SuperBoxSelect');
        }
        $allowedUsergroups = $this->modx->getOption('allowedUsergroups', $tvProperties, '', true);
        $deniedUsergroups = $this->modx->getOption('deniedUsergroups', $tvProperties, '', true);

        // Get query
        $query = $this->getProperty('query');
        if (!empty($query)) {
            $valuesqry = $this->getProperty('valuesqry');
            if (!empty($valuesqry)) {
                $c->where([
                    'id:IN' => explode('||', $query)
                ]);
            } else {
                $c->where([
                    'username:LIKE' => '%' . $query . '%'
                ]);
            }
        }

        $c->select($this->modx->getSelectColumns($this->classKey, $this->classKey, '', ['id', 'username']));

        if (!empty($allowedUsergroups) || !empty($deniedUsergroups)) {
            $c->leftJoin('modUserGroupMember', 'modUserGroupMember', [
                'modUserGroupMember.member = modUser.id'
            ]);
            $c->leftJoin('modUserGroup', 'modUserGroup', [
                'modUserGroup.id = modUserGroupMember.user_group'
            ]);
            $c->groupby('modUser.id');
            if (!empty($allowedUsergroups)) {
                $allowedUsergroups = explode(',', $allowedUsergroups);
                $c->where([
                    'modUserGroup.name:IN' => $allowedUsergroups
                ]);
            }
            if (!empty($deniedUsergroups)) {
                $deniedUsergroups = explode(',', $deniedUsergroups);
                $c->where([
                    [
                        'modUserGroup.name:NOT IN' => $deniedUsergroups,
                        'OR:modUserGroup.name:IS' => null
                    ]
                ]);
            }
        }

        // Exclude original value
        $originalValue = $this->getProperty('originalValue');
        if ($originalValue) {
            $originalValue = array_map('trim', explode('||', $originalValue));
            $c->where([
                'id:NOT IN' => $originalValue
            ]);
        }

        if ($this->superboxselect->getOption('debug')) {
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
            $c->where([
                'id:IN' => array_map('intval', explode('||', $id))
            ]);
        }
        if ($this->getProperty('sortBy')) {
            $c->sortby($this->getProperty('sortBy'), $this->getProperty('sortDir'));
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
        $titleTpl = $this->getProperty('userTitleTpl', '@INLINE [[+username]]');
        return [
            'id' => $object->get('id'),
            'title' => $this->superboxselect->getChunk($titleTpl, $object->toArray())
        ];
    }
}

return 'SuperboxselectUsersGetListProcessor';
