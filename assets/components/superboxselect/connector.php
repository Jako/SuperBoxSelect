<?php
/**
 * SuperBoxSelect Connector
 *
 * @package superboxselect
 * @subpackage connector
 *
 * @var modX $modx
 */
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

if (($package = $_POST['packageName']) && ($class = $_POST['className'])) {
    $corePath = $modx->getOption($package . '.core_path', null, $modx->getOption('core_path') . 'components/' . $package . '/');
    $package = $modx->getService($package, $class, $corePath . 'model/' . $package . '/', array(
        'core_path' => $corePath
    ));
} else {
    $corePath = $modx->getOption('superboxselect.core_path', null, $modx->getOption('core_path') . 'components/superboxselect/');
    $package = $modx->getService('superboxselect', 'SuperBoxSelect', $corePath . 'model/superboxselect/', array(
        'core_path' => $corePath
    ));
}

// Handle request
$modx->request->handleRequest(array(
    'processors_path' => $corePath . 'processors/',
    'location' => ''
));
