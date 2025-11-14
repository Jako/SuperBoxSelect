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

        $selectType = (isset($params['selectType']) && $params['selectType'] != '') ? $params['selectType'] : 'resources';
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
                'useRequest' => $params['useRequest'],
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
            'useRequest' => $params['useRequest'],
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
            'resourceId' => $params['resourceId'],
            'contextKey' => $params['contextKey'],
        ];

        $params = [
            'allowBlank' => ($params['allowBlank'] == 1 || $params['allowBlank'] == 'true'),
            'fieldTpl' => $params['fieldTpl'],
            'forceSelection' => ($params['forceSelection'] == 1 || $params['forceSelection'] == 'true'),
            'maxElements' => ($params['maxElements']) ? $params['maxElements'] * 1 : 0,
            'pageSize' => ($params['pageSize']) ? $params['pageSize'] * 1 : 0,
            'stackItems' => ($params['stackItems'] == 1 || $params['stackItems'] == 'true')
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
        $this->setPlaceholder('multiple', $params['maxElements'] != 1 );
        $this->setPlaceholder('value', $value);
    }
}

return 'SuperboxselectInputRender';
