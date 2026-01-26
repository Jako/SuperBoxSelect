<?php
/**
 * SuperBoxSelect Input Render
 *
 * @package superboxselect
 * @subpackage input_render
 */

class SuperboxselectInputRender extends modTemplateVarInputRender
{
    /**
     * Get a local configuration option by key.
     *
     * @param string $key The option key to search for.
     * @param array $options An array of options that override MODX options.
     * @param mixed $default The default value returned if the option is not found; by default this value is null.
     * @param bool $skipEmpty True if empty string values should be ignored.
     * @return mixed The option value or the default value specified.
     */
    public function getOption(string $key, $options, $default = null, $skipEmpty = false)
    {
        return $this->modx->getOption($key, $options, $default, $skipEmpty);
    }

    /**
     * Get a boolean local configuration option by key.
     *
     * @param string $key The option key to search for.
     * @param array $options An array of options that override MODX options.
     * @param mixed $default The default value returned if the option is not found; by default this value is null.
     * @return mixed The option value or the default value specified.
     */
    public function getBooleanOption(string $key, $options, $default = null)
    {
        $value = $this->modx->getOption($key, $options, $default);
        return ($value == 1 || $value == 'true');
    }


    /**
     * Return the template path to load
     *
     * @return string
     */
    public function getTemplate()
    {
        $corePath = $this->modx->getOption('superboxselect.core_path', null, $this->modx->getOption('core_path') . 'components/superboxselect/');
        return $corePath . 'elements/tv/input/tpl/superboxselect.render.tpl';
    }

    /**
     * Get lexicon topics
     *
     * @return array
     */
    public function getLexiconTopics()
    {
        return ['superboxselect:default'];
    }

    /**
     * Process Input Render
     *
     * @param string $value
     * @param array $params
     * @return void
     */
    public function process($value, array $params = [])
    {
        $corePath = $this->modx->getOption('superboxselect.core_path', null, $this->modx->getOption('core_path') . 'components/superboxselect/');
        /** @var SuperBoxSelect $superboxselect */
        $superboxselect = $this->modx->getService('superboxselect', 'SuperBoxSelect', $corePath . 'model/superboxselect/', [
            'core_path' => $corePath
        ]);

        $selectType = $this->getOption('selectType', $params, 'resources');
        $params = array_merge($params, [
            'resourceId' => ($this->modx->resource) ? $this->modx->resource->get('id') : 0,
            'contextKey' => ($this->modx->resource) ? $this->modx->resource->get('context_key') : 'web',
            'selectType' => $selectType
        ]);
        $params['useRequest'] = true;

        // Get internal select types
        $internalTypes = $superboxselect->getTypes();
        $renderOptions = [];
        foreach ($internalTypes as $internalType) {
            $response = $this->modx->runProcessor('types/' . $internalType . '/options', [
                'option' => 'renderOptions',
                'useRequest' => $this->getOption('useRequest', $params),
                'params' => $params
            ], [
                'processors_path' => $superboxselect->getOption('processorsPath')
            ]);
            if (empty($response->errors)) {
                $renderOptions[$internalType] = $response->response;
            }
        }

        // Add external types to the list
        $customTypes = $this->modx->invokeEvent('OnSuperboxselectTypeOptions', [
            'option' => 'renderOptions',
            'useRequest' => $this->getOption('useRequest', $params),
            'params' => $params
        ]);
        if (is_array($customTypes)) {
            foreach ($customTypes as $customType) {
                $customType = unserialize($customType);
                if ($customType) {
                    $renderOptions = array_merge($renderOptions, $customType);
                }
            }
        }

        $baseParams = [
            'action' => 'types/' . $selectType . '/getlist',
            'tvid' => $this->tv->get('id'),
            'resourceId' => $this->getOption('resourceId', $params),
            'contextKey' => $this->getOption('contextKey', $params),
        ];

        $params = [
            'allowBlank' => $this->getBooleanOption('allowBlank', $params),
            'fieldTpl' => $this->getOption('fieldTpl', $params),
            'forceSelection' => $this->getBooleanOption('forceSelection', $params),
            'maxElements' => $this->getOption('maxElements', $params, 0) * 1,
            'pageSize' => $this->getOption('pageSize', $params, 0) * 1,
            'stackItems' => $this->getBooleanOption('stackItems', $params)
        ];
        if ($params['maxElements'] == 1) {
            unset($params['stackItems']);
        }
        if (!$params['pageSize']) {
            unset($params['pageSize']);
        }

        if (isset($renderOptions[$selectType])) {
            $params = array_merge($params, $renderOptions[$selectType]['params']);
            $baseParams = array_merge($baseParams, $renderOptions[$selectType]['baseParams']);
            $this->setPlaceholder('connector', $renderOptions[$selectType]['connector']);
        }

        $this->setPlaceholder('baseParams', json_encode($baseParams, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $this->setPlaceholder('params', json_encode($params, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        $this->setPlaceholder('multiple', $params['maxElements'] != 1);
        $this->setPlaceholder('value', $value);
    }
}

return 'SuperboxselectInputRender';
