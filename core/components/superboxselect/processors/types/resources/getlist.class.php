<?php
/**
 * Get list resources processor
 *
 * @package superboxselect
 * @subpackage processors
 */

use TreehillStudio\SuperBoxSelect\Processors\ObjectGetListProcessor;

class SuperboxselectResourcesGetListProcessor extends ObjectGetListProcessor
{
    public $classKey = 'modResource';
    public $defaultSortField = 'BINARY pagetitle';
    public $defaultSortDirection = 'ASC';

    protected $search = ['pagetitle'];

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
        $where = $this->modx->getOption('where', $tvProperties, '', true);
        $limitRelatedContext = $this->modx->getOption('limitRelatedContext', $tvProperties, '0', true);
        $limitRelatedContext = $limitRelatedContext == '1' || $limitRelatedContext == 'true';
        $contextKey = ($limitRelatedContext) ? $this->getProperty('contextKey', false) : false;
        $resourceId = (int)$this->getProperty('resourceId');
        $parents = $this->modx->getOption('parents', $tvProperties, '', true);
        $parents = ($parents) ? explode(',', $parents) : [];
        $depth = (int)$this->modx->getOption('depth', $tvProperties, 10, true);
        $valueField = $this->modx->getOption('valueField', $tvProperties, 'id', true);

        if ($where) {
            $where = json_decode($where, true);
            $c->where($where);
        }

        // Get the context of the current edited resource
        if (!$contextKey) {
            $resource = $this->modx->getObject('modResource', $resourceId);
            $contextKey = ($resource) ? $resource->get('context_key') : '';
        }

        // Restrict to related context
        if ($limitRelatedContext) {
            $c->where(['context_key' => $contextKey]);
        }

        // Get parents
        if (!empty($parents)) {
            $children = [];
            foreach ($parents as &$parent) {
                // if $parent is not numeric, assume it is set by a context/system setting
                if (!is_numeric($parent)) {
                    // get the key of this context that is referenced by
                    $object = $this->modx->getObject('modContextSetting', [
                        'context_key' => $contextKey,
                        'key' => $parent
                    ]);
                    if ($object) {
                        // if the context and the context key are valid get the context setting
                        $parent = $object->get('value');
                        $parent = ($parent) ? intval($parent) : 0;
                    } else {
                        // else get the system setting
                        $parent = intval($this->modx->getOption($parent, null, 0));
                    }
                }
                if (!empty($limitRelatedContext) && ($limitRelatedContext == 1 || $limitRelatedContext == 'true')) {
                    $pchildren = $this->modx->getChildIds($parent, $depth, ['context' => $contextKey]);
                } else {
                    $parentObject = $this->modx->getObject('modResource', $parent);
                    if ($parentObject) {
                        $pchildren = $this->modx->getChildIds($parent, $depth, ['context' => $parentObject->get('context_key')]);
                    } else {
                        $pchildren = [];
                    }
                }
                if (!empty($pchildren)) {
                    $children = array_merge($children, $pchildren);
                }
            }
            if (!empty($children)) {
                $parents = array_merge($parents, $children);
            }

            $c->where([
                'parent:IN' => $parents,
            ]);
        }

        $c = parent::prepareQueryBeforeCount($c);

        // Exclude original value
        $originalValue = $this->getProperty('originalValue');
        if ($originalValue) {
            $originalValue = array_map('trim', explode('||', $originalValue));
            $c->where([
                $valueField . ':NOT IN' => $originalValue
            ]);
        }

        $columns = (in_array($valueField, $this->modx->getFields($this->classKey))) ? ['id', $valueField, 'pagetitle'] : ['id', 'pagetitle'];
        $c->select($this->modx->getSelectColumns($this->classKey, $this->classKey, '', $columns));

        $c->where([
            'deleted' => false,
            'published' => true
        ]);

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
        $valueField = $this->getProperty('valueField', 'id');
        $valueField = (in_array($valueField, $this->modx->getFields($this->classKey))) ? $valueField : 'id';
        if ($valueField != 'id') {
            $c->groupby($this->classKey . '.' . $valueField);
        }

        $valuesqry = $this->getProperty('valuesqry');
        if (!empty($valuesqry)) {
            $query = $this->getProperty('query');
            $c->where([
                $valueField . ':IN' => explode('||', $query)
            ]);
        } else {
            $id = $this->getProperty('id');
            if (!empty($id)) {
                $c->where([
                    $valueField . ':IN' => array_map('trim', explode('||', $id))
                ]);
            }
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
        $valueField = $this->getProperty('valueField', 'id');
        $valueField = (in_array($valueField, $this->modx->getFields($this->classKey))) ? $valueField : 'id';
        $titleTpl = $this->getProperty('resourceTitleTpl', '@INLINE [[+pagetitle]]');
        return [
            'id' => $object->get($valueField),
            'title' => $this->superboxselect->getChunk($titleTpl, $object->toArray())
        ];
    }
}

return 'SuperboxselectResourcesGetListProcessor';
