<?php
/**
 * Resources options processor
 *
 * @package superboxselect
 * @subpackage processors
 */

use TreehillStudio\SuperBoxSelect\Processors\OptionsProcessor;

class SuperboxselectCustomTableOptionsProcessor extends OptionsProcessor
{
    public $inputOptionType = 'customtable';

    /**
     * {@inheritDoc}
     * @return bool
     */
    public function initialize()
    {
        $this->modx->lexicon('superboxselect.custom_table');
        return parent::initialize();
    }

    public function useRenderOptions($defaults)
    {
        $renderOptions = [
            'params' => [
                'fieldTpl' => $this->getOption('fieldTpl', $defaults, $this->fieldTpl),
                'valueField' => $this->getOption('valueField', $defaults, 'id'),
            ],
            'baseParams' => []
        ];
        if ($this->getProperty('useRequest')) {
            $baseParams = [
                'useRequest' => false,
                'packageName' => $this->getOption('packageName', $defaults),
                'className' => $this->getOption('className', $defaults),
                'selectedFields' => $this->getOption('selectedFields', $defaults),
                'sortBy' => $this->getOption('sortBy', $defaults),
                'sortDir' => $this->getOption('sortDir', $defaults),
                'resourceTitleTpl' => $this->getOption('resourceTitleTpl', $defaults),
            ];
            foreach ($baseParams as $key => $value) {
                if (is_null($value)) {
                    unset($baseParams[$key]);
                }
            }
            $renderOptions['baseParams'] = $baseParams;

            $params = [];
            foreach ($params as $key => $value) {
                if (is_null($value)) {
                    unset($params[$key]);
                }
            }
            $renderOptions['params'] = array_merge($renderOptions['params'], $params);
        }
        return $renderOptions;
    }
}

return 'SuperboxselectCustomTableOptionsProcessor';
