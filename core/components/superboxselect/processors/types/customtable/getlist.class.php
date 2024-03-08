<?php
/**
 * Get list resources processor
 *
 * @package superboxselect
 * @subpackage processors
 */

use TreehillStudio\SuperBoxSelect\Processors\ObjectGetListProcessor;

class SuperboxselectCustomTableGetListProcessor extends ObjectGetListProcessor
{

    public $classKey = '';
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'ASC';
    private $selectedFields;

    /**
     * @return bool
     */
    public function beforeQuery()
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

        $this->classKey = $this->modx->getOption('className', $tvProperties, '', true);
        $this->selectedFields = $this->modx->getOption('selectedFields', $tvProperties, '', true);
        if($this->selectedFields) {
            $this->selectedFields = explode(',', $this->selectedFields);
        }

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
                    'title:LIKE' => '%' . $query . '%'
                ]);
            }
        }

        $c->select($this->modx->getSelectColumns($this->classKey, '', '', $this->selectedFields));

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
        return array_reduce($this->selectedFields, function($out, $field) use ($object) {
            $out[$field] = $object->get($field);
            return $out;
        }, []);
    }
}

return 'SuperboxselectCustomTableGetListProcessor';