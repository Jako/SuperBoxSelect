<?php
/**
 * Get list processor for SuperBoxSelect TV.
 *
 * @package superboxselect
 * @subpackage processor
 */

class SuperboxselectResourcesGetListProcessor extends modObjectGetListProcessor
{
    /**
     * @var string $classKey
     */
    public $classKey = 'modResource';
    /**
     * @var array $languageTopics
     */
    public $languageTopics = array('superboxselect:default');
    /**
     * @var string $defaultSortField
     */
    public $defaultSortField = 'pagetitle';
    /**
     * @var string $defaultSortDirection
     */
    public $defaultSortDirection = 'ASC';
    /**
     * @var string $objectType
     */
    public $objectType = 'superboxselect.resources';

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
        $where = $this->getProperty('where', array());
        $limitRelatedContext = $this->getProperty('limitRelatedContext', false);
        $contextKey = ($limitRelatedContext) ? $this->getProperty('contextKey', false) : false;
        $resourceId = intval($this->getProperty('resourceId'));
        $parents = $this->getProperty('parents', '0');
        $parents = ($parents) ? explode(',', $parents) : array();
        $depth = $this->getProperty('depth', 10);
        $valueField = $this->getProperty('valueField', 'id');

        if ($where) {
            $where = json_decode($where, true);
            $c->where($where);
        }

        // Get the context of the current edited resource
        if (!$contextKey) {
            $resource = $this->modx->getObject('modResource', $resourceId);
            $contextKey = $resource->get('context_key');
        }

        // Restrict to related context
        if (!empty($limitRelatedContext) && ($limitRelatedContext == 1 || $limitRelatedContext == 'true')) {
            $c->where(array('context_key' => $contextKey));
        }

        // Get parents
        if (!empty($parents)) {
            $children = array();
            foreach ($parents as &$parent) {
                // if $parent is not numeric, assume it is set by a context/system setting
                if (!is_numeric($parent)) {
                    // get the key of this context that is referenced by
                    $object = $this->modx->getObject('modContextSetting', array(
                        'context_key' => $contextKey,
                        'key' => $parent
                    ));
                    if ($object) {
                        // if the context and the context key are valid get the context setting
                        $parent = $object->get('value');
                        $parent = ($parent) ? intval($parent) : 0;
                    } else {
                        // else get the system setting
                        $parent = intval($this->modx->getOption($parent, null, 0));
                    }
                }
                $pchildren = $this->modx->getChildIds($parent, $depth, array('context' => $contextKey));
                if (!empty($pchildren)) {
                    $children = array_merge($children, $pchildren);
                }
            }
            if (!empty($children)) {
                $parents = array_merge($parents, $children);
            }

            $c->where(array(
                'parent:IN' => $parents,
            ));
        }

        // Get query
        $query = $this->getProperty('query');
        if (!empty($query)) {
            $valuesqry = $this->getProperty('valuesqry');
            if (empty($valuesqry)) {
                $c->where(array(
                    'pagetitle:LIKE' => '%' . $query . '%'
                ));
            }
        }

        // Exclude original value
        $originalValue = $this->getProperty('originalValue');
        if ($originalValue) {
            $originalValue = array_map('trim', explode('||', $originalValue));
            $c->where(array(
                $valueField . ':NOT IN' => $originalValue
            ));
        }

        $columns = (in_array($valueField, $this->modx->getFields($this->classKey))) ? array('id', $valueField, 'pagetitle') : array('id', 'pagetitle');
        $c->select($this->modx->getSelectColumns($this->classKey, $this->classKey, '', $columns));

        $c->where(array(
            'deleted' => false,
            'published' => true
        ));

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
        $valueField = $this->getProperty('valueField', 'id');
        $valueField = (in_array($valueField, $this->modx->getFields($this->classKey))) ? $valueField : 'id';
        if ($valueField != 'id') {
            $c->groupby($this->classKey . '.' . $valueField);
        }

        $valuesqry = $this->getProperty('valuesqry');
        if (!empty($valuesqry)) {
            $query = $this->getProperty('query');
            $c->where(array(
                $valueField . ':IN' => explode('||', $query)
            ));
        } else {
            $id = $this->getProperty('id');
            if (!empty($id)) {
                $c->where(array(
                    $valueField . ':IN' => array_map('trim', explode('||', $id))
                ));
            }
        }
        $c->sortby('pagetitle', 'ASC');

        return $c;
    }

    /**
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $valueField = $this->getProperty('valueField', 'id');
        $valueField = (in_array($valueField, $this->modx->getFields($this->classKey))) ? $valueField : 'id';
        return array(
            'id' => $object->get($valueField),
            'title' => $object->get('pagetitle')
        );
    }
}

return 'SuperboxselectResourcesGetListProcessor';
