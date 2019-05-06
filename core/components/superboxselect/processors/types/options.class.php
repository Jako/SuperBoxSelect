<?php

/**
 * Options processor for SuperBoxSelect TV.
 *
 * @package superboxselect
 * @subpackage processor
 */
class SuperboxselectOptionsProcessor extends modProcessor
{
    /**
     * @var array $languageTopics
     */
    public $languageTopics = array('superboxselect:default');

    /**
     * @var SuperBoxSelect $superboxselect
     */
    public $superboxselect;

    /**
     * @var string
     */
    public $fieldTpl = '{title} ({id})';

    /**
     * @var string
     */
    public $inputOptionType = '';

    /**
     * Run the processor and return the result.
     *
     * @return string
     */
    public function process()
    {
        $corePath = $this->modx->getOption('superboxselect.core_path', null, $this->modx->getOption('core_path') . 'components/superboxselect/');
        /** @var SuperBoxSelect $superboxselect */
        $this->superboxselect = $this->modx->getService('superboxselect', 'SuperBoxSelect', $corePath . 'model/superboxselect/', array(
            'core_path' => $corePath
        ));

        $option = $this->getProperty('option');

        $result = '';
        if (method_exists($this, 'get' . ucfirst($option))) {
            $method = 'get' . ucfirst($option);
            $result = $this->$method();
        }
        return $result;
    }

    /**
     * Get the field template.
     *
     * @return string
     */
    public function getFieldTpl()
    {
        return $this->fieldTpl;
    }

    /**
     * Get the input option xtype and register the panel javascript
     *
     * @return array|null
     */
    public function getInputOptionType()
    {
        if ($this->inputOptionType) {
            $inputOptionType = array(
                'type' => "{xtype: 'superboxselect-panel-inputoptions-{$this->inputOptionType}', params: config.params}",
                'success' => true
            );
            return $inputOptionType;
        } else {
            return null;
        }
    }
}

return 'SuperboxselectUsersOptionsProcessor';
