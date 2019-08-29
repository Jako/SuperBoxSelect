<?php
/**
 * SuperBoxSelect classfile
 *
 * Copyright 2011-2016 by Benjamin Vauchel <contact@omycode.fr>
 * Copyright 2016-2019 by Thomas Jakobi <thomas.jakobi@partout.info>
 *
 * @package superboxselect
 * @subpackage classfile
 */

/**
 * class SuperBoxSelect
 */
class SuperBoxSelect
{
    /**
     * A reference to the modX instance
     * @var modX $modx
     */
    public $modx;

    /**
     * The namespace
     * @var string $namespace
     */
    public $namespace = 'superboxselect';

    /**
     * The version
     * @var string $version
     */
    public $version = '2.3.3';

    /**
     * The class config
     * @var array $config
     */
    public $config = array();

    /**
     * SuperBoxSelect constructor
     *
     * @param modX $modx A reference to the modX instance.
     * @param array $config An config array. Optional.
     */
    function __construct(modX &$modx, $config = array())
    {
        $this->modx =& $modx;
        $this->namespace = $this->getOption('namespace', $config, $this->namespace);

        $corePath = $this->getOption('core_path', $config, $this->modx->getOption('core_path') . 'components/' . $this->namespace . '/');
        $assetsPath = $this->getOption('assets_path', $config, $this->modx->getOption('assets_path') . 'components/' . $this->namespace . '/');
        $assetsUrl = $this->getOption('assets_url', $config, $this->modx->getOption('assets_url') . 'components/' . $this->namespace . '/');

        // Load some default paths for easier management
        $this->config = array_merge(array(
            'namespace' => $this->namespace,
            'version' => $this->version,
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'vendorPath' => $corePath . 'vendor/',
            'chunksPath' => $corePath . 'elements/chunks/',
            'pagesPath' => $corePath . 'elements/pages/',
            'snippetsPath' => $corePath . 'elements/snippets/',
            'pluginsPath' => $corePath . 'elements/plugins/',
            'controllersPath' => $corePath . 'controllers/',
            'processorsPath' => $corePath . 'processors/',
            'templatesPath' => $corePath . 'templates/',
            'assetsPath' => $assetsPath,
            'assetsUrl' => $assetsUrl,
            'jsUrl' => $assetsUrl . 'js/',
            'cssUrl' => $assetsUrl . 'css/',
            'imagesUrl' => $assetsUrl . 'images/',
            'connectorUrl' => $assetsUrl . 'connector.php'
        ), $config);

        // Set default options
        $this->config = array_merge($this->config, array(
            'advanced' => (bool)$this->getOption('advanced')
        ));

        $this->modx->lexicon->load($this->namespace . ':default');
    }

    /**
     * Get a local configuration option or a namespaced system setting by key.
     *
     * @param string $key The option key to search for.
     * @param array $options An array of options that override local options.
     * @param mixed $default The default value returned if the option is not found locally or as a
     * namespaced system setting; by default this value is null.
     * @return mixed The option value or the default value specified.
     */
    public function getOption($key, $options = array(), $default = null)
    {
        $option = $default;
        if (!empty($key) && is_string($key)) {
            if ($options != null && array_key_exists($key, $options)) {
                $option = $options[$key];
            } elseif (array_key_exists($key, $this->config)) {
                $option = $this->config[$key];
            } elseif (array_key_exists("{$this->namespace}.{$key}", $this->modx->config)) {
                $option = $this->modx->getOption("{$this->namespace}.{$key}");
            }
        }
        return $option;
    }

    /**
     * Register javascripts in the controller
     * @param string $package
     */
    public function includeScriptAssets($package = '')
    {
        $assetsUrl = $this->getOption('assetsUrl');
        $jsUrl = $this->getOption('jsUrl') . 'mgr/';
        $jsSourceUrl = $assetsUrl . '../../../source/js/mgr/';
        $cssUrl = $this->getOption('cssUrl') . 'mgr/';
        $cssSourceUrl = $assetsUrl . '../../../source/css/mgr/';

        if ($this->getOption('debug') && ($assetsUrl != MODX_ASSETS_URL . 'components/superboxselect/')) {
            $this->modx->controller->addJavascript($jsSourceUrl . 'vendor/Sortable.js?v=v' . $this->version);
            $this->modx->controller->addJavascript($jsSourceUrl . 'superboxselect.js?v=v' . $this->version);
            $this->modx->controller->addJavascript($jsSourceUrl . 'superboxselect.panel.inputoptions.js?v=v' . $this->version);
            $this->modx->controller->addJavascript($jsSourceUrl . 'superboxselect.combo.templatevar.js?v=v' . $this->version);
            $this->modx->controller->addJavascript($jsSourceUrl . 'superboxselect.renderer.js?v=v' . $this->version);
            $this->modx->controller->addCss($cssSourceUrl . 'superboxselect.css?v=v' . $this->version);
        } else {
            $this->modx->controller->addJavascript($jsUrl . 'superboxselect.min.js?v=v' . $this->version);
            $this->modx->controller->addCss($cssUrl . 'superboxselect.min.css?v=v' . $this->version);
        }

        if ($package) {
            $packageCorePath = $this->modx->getOption($package . '.core_path', null, $this->modx->getOption('core_path') . 'components/' . $package . '/');
            $packageJsPath = $packageCorePath . 'js/';
            $packageAssetsUrl = $this->getOption($package . '.assets_url', null, $this->modx->getOption('assets_url') . 'components/' . $package . '/');
            $packageJsUrl = $packageAssetsUrl . 'js/';
            $packageJsSourceUrl = $packageAssetsUrl . '../../../source/js/';
        } else {
            $packageJsPath = $this->getOption('assetsPath') . 'js/';
            $packageJsUrl = $this->getOption('jsUrl');
            $packageJsSourceUrl = $this->getOption('assetsUrl') . '../../../source/js/';
        }

        if ($this->getOption('debug') && ($assetsUrl != MODX_ASSETS_URL . 'components/superboxselect/')) {
            $files = glob($packageJsPath . 'types/*', GLOB_ONLYDIR);
            foreach ($files as $file) {
                $basename = basename($file);
                $this->modx->controller->addJavascript($packageJsSourceUrl . 'types/' . $basename . '/superboxselect.panel.inputoptions.js?v=v' . $this->version);
            }
        } else {
            $files = glob($packageJsPath . 'types/*', GLOB_ONLYDIR);
            foreach ($files as $file) {
                $basename = basename($file);
                $this->modx->controller->addJavascript($packageJsUrl . 'types/' . $basename . '/superboxselect.panel.inputoptions.min.js?v=v' . $this->version);
            }
        }

        $this->modx->controller->addHtml('<script type="text/javascript">'
            . 'SuperBoxSelect.config = ' . json_encode($this->config, JSON_PRETTY_PRINT) . ';'
            . '</script>');
    }

    /**
     * @param $params
     * @return array
     */
    public function getProcessorsPath($params)
    {
        $package = preg_replace('/[^a-zA-Z0-9_]+/', '', isset($params['package']) ? $params['package'] : '');
        $action = isset($params['action']) ? $params['action'] : '';

        if ($package && strpos($action, 'types/') === 0) {
            $packageCorePath = $this->modx->getOption($package . '.core_path', null, $this->modx->getOption('core_path') . 'components/' . $package . '/');
            $processorsPath = $packageCorePath . 'processors/';
        } else {
            $processorsPath = $this->getOption('processorsPath');
        }

        return $processorsPath;
    }

    /**
     * @param $package
     * @return string
     */
    public function getInputOptionTypes($package)
    {
        if ($package) {
            $packageCorePath = $this->modx->getOption($package . '.core_path', null, $this->modx->getOption('core_path') . 'components/' . $package . '/');
            $packageProcessorsPath = $packageCorePath . 'processors/';
        } else {
            $packageProcessorsPath = $this->getOption('processorsPath');
        }

        $files = glob($packageProcessorsPath . 'types/*', GLOB_ONLYDIR);
        $types = array();
        foreach ($files as $file) {
            $response = $this->modx->runProcessor('types/' . basename($file) . '/options', array(
                'option' => 'inputOptionType',
            ), array(
                'processors_path' => $this->getProcessorsPath(array(
                    'action' => 'types/',
                    'package' => $package
                ))
            ));
            if (empty($response->errors)) {
                $types[] = $response->response['type'];
            }
        }

        $this->modx->smarty->assign('types', implode(',', $types));
        return $this->modx->smarty->fetch($this->getOption('processorsPath') . 'mgr/selecttypes/tpl/superbox.inputoptions.type.tpl');
    }
}
