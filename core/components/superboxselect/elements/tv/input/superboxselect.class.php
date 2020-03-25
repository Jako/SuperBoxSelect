<?php

/**
 * SuperBoxSelect Input Render
 *
 * @package superboxselect
 * @subpackage input_render
 */
class SuperboxselectInputRender extends modTemplateVarInputRender
{
    public function getTemplate()
    {
        $corePath = $this->modx->getOption('superboxselect.core_path', null, $this->modx->getOption('core_path') . 'components/superboxselect/');
        return $corePath . 'elements/tv/input/tpl/superboxselect.render.tpl';
    }

    public function process($value, array $params = array())
    {
        $corePath = $this->modx->getOption('superboxselect.core_path', null, $this->modx->getOption('core_path') . 'components/superboxselect/');
        /** @var SuperBoxSelect $superboxselect */
        $superboxselect = $this->modx->getService('superboxselect', 'SuperBoxSelect', $corePath . 'model/superboxselect/', array(
            'core_path' => $corePath
        ));
        $superboxselect->includeScriptAssets(isset($params['selectPackage']) ? $params['selectPackage'] : '');

        $params = array_merge($params, array(
            'resourceId' => ($this->modx->resource) ? $this->modx->resource->get('id') : 0,
            'contextKey' => ($this->modx->resource) ? $this->modx->resource->get('context_key') : 'web',
            'selectType' => (isset($params['selectType']) && $params['selectType'] != '') ? $params['selectType'] : 'resources'
        ));

        $response = $this->modx->runProcessor('types/' . $params['selectType'] . '/options', array(
            'option' => 'fieldTpl',
        ), array(
            'processors_path' => $superboxselect->getProcessorsPath(array(
                'action' => 'types/',
                'package' => isset($params['selectPackage']) ? $params['selectPackage'] : ''
            ))
        ));
        if (empty($response->errors)) {
            $params['fieldTpl'] = $response->response;
        }

        $this->setPlaceholder('params', $params);
        $this->setPlaceholder('value', $value);
        $this->setPlaceholder('connector', $superboxselect->getOption('connectorUrl'));
    }
}

return 'SuperboxselectInputRender';
