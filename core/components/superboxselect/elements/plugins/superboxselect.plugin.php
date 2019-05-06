<?php
/**
 * SuperBoxSelect Runtime Hooks
 *
 * Registers custom TV input types and includes javascripts on
 * document edit pages so that the TV can be used from within other extras
 * (i.e. MIGX, Collections)
 *
 * @package superboxselect
 * @subpackage plugin
 *
 * @event OnManagerPageBeforeRender
 * @event OnTVInputRenderList
 * @event OnTVInputPropertiesList
 * @event OnDocFormRender
 *
 * @var modX $modx
 */

$corePath = $modx->getOption('superboxselect.core_path', null, $modx->getOption('core_path') . 'components/superboxselect/');
/** @var SuperBoxSelect $superboxselect */
$superboxselect = $modx->getService('superboxselect', 'SuperBoxSelect', $corePath . 'model/superboxselect/', array(
    'core_path' => $corePath
));

switch ($modx->event->name) {
    case 'OnManagerPageBeforeRender':
        $modx->controller->addLexiconTopic('superboxselect:default');
        $tvId = isset($modx->controller->scriptProperties['id']) ? $modx->controller->scriptProperties['id'] : 0;
        /** @var modTemplateVar $tv */
        $tv = $modx->getObject('modTemplateVar', $tvId);
        if ($tv) {
            $tvProperties = $tv->get('input_properties');
            $package = isset($tvProperties['selectPackage']) ? $tvProperties['selectPackage'] : '';
        } else {
            $package = '';
        }
        $superboxselect->includeScriptAssets($package);
        break;
    case 'OnTVInputRenderList':
        $modx->event->output($corePath . 'elements/tv/input/');
        break;
    case 'OnTVInputPropertiesList':
        $modx->event->output($corePath . 'elements/tv/input/options/');
        break;
    case 'OnDocFormRender':
        $superboxselect->includeScriptAssets();
        break;
};
