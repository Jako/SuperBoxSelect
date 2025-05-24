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

    protected $selectedFields;
    protected $valueField;

    /**
     * @param modX $modx A reference to the modX instance
     * @param array $properties An array of properties
     */
    public function __construct(modX &$modx, array $properties = [])
    {
        parent::__construct($modx, $properties);

        // Get Properties
        $tvid = $this->getProperty('tvid', 0);
        /** @var modTemplateVar $tv */
        $tv = $this->modx->getObject('modTemplateVar', $tvid);
        if ($tv) {
            $tvProperties = $tv->get('input_properties');
        } else {
            $tvProperties = [];
            $this->modx->log(xPDO::LOG_LEVEL_ERROR, 'Invalid template variable ID!', '', 'SuperBoxSelect');
        }

        $packageName = $this->modx->getOption('packageName', $tvProperties, '', true);
        $modelPath = $this->modx->getOption($packageName . '.core_path', null, $this->modx->getOption('core_path') . 'components/' . $packageName . '/') . 'model/';
        $this->modx->addPackage($packageName, $modelPath);

        $this->classKey = $this->modx->getOption('className', $tvProperties, '', true);
        $this->valueField = $this->modx->getPK($this->classKey);
        $selectedFields = trim($this->modx->getOption('selectedFields', $tvProperties, '', true));
        if ($selectedFields) {
            $this->search = explode(',', $selectedFields);
            $this->selectedFields = array_unique(array_merge([$this->valueField], $this->search));
        }
        $this->defaultSortField = 'BINARY ' . $this->search[0];
    }

    /**
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $c = parent::prepareQueryBeforeCount($c);

        $c->select($this->modx->getSelectColumns($this->classKey, $this->classKey, '', $this->selectedFields));

        // Exclude original value
        $originalValue = $this->getProperty('originalValue');
        if ($originalValue) {
            $originalValue = array_map('intval', explode('||', $originalValue));
            $c->where([
                $this->valueField . ':NOT IN' => $originalValue
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
        $valuesqry = $this->getProperty('valuesqry');
        if (!empty($valuesqry)) {
            $query = $this->getProperty('query');
            $c->where([
                $this->valueField . ':IN' => array_map('trim', explode('||', $query))
            ]);
        } else {
            $id = $this->getProperty('id');
            if (!empty($id)) {
                $c->where([
                    $this->valueField . ':IN' => array_map('intval', explode('||', $id))
                ]);
            }
        }
        if ($this->getProperty('sortBy')) {
            $c->sortby($this->getProperty('sortBy'), $this->getProperty('sortDir'));
        }
        $c->sortby($this->getProperty('defaultSortField'), $this->getProperty('defaultSortDirection'));
        return $c;
    }
}

return 'SuperboxselectCustomTableGetListProcessor';
