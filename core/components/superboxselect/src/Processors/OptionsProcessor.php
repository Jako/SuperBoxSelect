<?php
/**
 * Options processor
 *
 * @package superboxselect
 * @subpackage processors
 */

namespace TreehillStudio\SuperBoxSelect\Processors;

class OptionsProcessor extends Processor
{
    public $fieldTpl = '{title} ({id})';
    public $inputOptionType = '';
    public $renderOptions = [];

    /**
     * Get a local configuration option by key.
     *
     * @param string $key The option key to search for.
     * @param array $options An array of options that override MODX options.
     * @param mixed $default The default value returned if the option is not found; by default this value is null.
     * @return mixed The option value or the default value specified.
     */
    public function getOption(string $key, $options, $default = null)
    {
        return $this->modx->getOption($key, $options, $default);
    }

    /**
     * Run the processor and return the result.
     *
     * @return mixed
     */
    public function process()
    {
        $option = $this->getProperty('option');

        $result = '';
        if (method_exists($this, 'get' . ucfirst($option))) {
            $method = 'get' . ucfirst($option);
            $result = $this->$method();
        }
        return $result;
    }

    /**
     * Get the render options.
     *
     * @return array
     */
    public function getRenderOptions()
    {
        $params = $this->getProperty('params');
        $renderOptions = [
            'connector' => $this->superboxselect->getOption('connectorUrl')
        ];
        $renderOptions = array_merge_recursive($renderOptions, $this->useRenderOptions($params));
        return $renderOptions;
    }

    /**
     * @param $params
     * @return array
     */
    public function useRenderOptions($params)
    {
        return [];
    }

    /**
     * Get the input option xtype and register the panel javascript
     *
     * @return array|null
     */
    public function getInputOptionType()
    {
        if ($this->inputOptionType) {
            $inputOptionType = [
                'type' => "{xtype: 'superboxselect-panel-inputoptions-$this->inputOptionType', params: config.params}",
                'success' => true
            ];
            return $inputOptionType;
        } else {
            return null;
        }
    }
}
