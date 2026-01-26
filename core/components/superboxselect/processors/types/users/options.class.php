<?php
/**
 * Users options processor
 *
 * @package superboxselect
 * @subpackage processors
 */

use TreehillStudio\SuperBoxSelect\Processors\OptionsProcessor;

class SuperboxselectUsersOptionsProcessor extends OptionsProcessor
{
    public $inputOptionType = 'users';

    /**
     * {@inheritDoc}
     * @return bool
     */
    public function initialize()
    {
        $this->modx->lexicon('superboxselect.users');
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
                'useRequest' => true,
                'allowedUsergroups' => $this->getOption('allowedUsergroups', $defaults),
                'deniedUsergroups' => $this->getOption('deniedUsergroups', $defaults),
                'sortBy' => $this->getOption('sortBy', $defaults),
                'sortDir' => $this->getOption('sortDir', $defaults),
                'userTitleTpl' => $this->getOption('userTitleTpl', $defaults),
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

return 'SuperboxselectUsersOptionsProcessor';
