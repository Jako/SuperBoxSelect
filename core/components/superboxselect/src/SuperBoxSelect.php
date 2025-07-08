<?php
/**
 * SuperBoxSelect
 *
 * Copyright 2011-2016 by Benjamin Vauchel <contact@omycode.fr>
 * Copyright 2016-2025 by Thomas Jakobi <office@treehillstudio.com>
 *
 * @package superboxselect
 * @subpackage classfile
 */

namespace TreehillStudio\SuperBoxSelect;

use modX;

/**
 * Class SuperBoxSelect
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
     * The package name
     * @var string $packageName
     */
    public $packageName = 'SuperBoxSelect';

    /**
     * The version
     * @var string $version
     */
    public $version = '3.1.1';

    /**
     * The class options
     * @var array $options
     */
    public $options = [];

    /**
     * Template cache
     * @var array $_tplCache
     */
    private $_tplCache;

    /**
     * Valid binding types
     * @var array $_validTypes
     */
    private $_validTypes = [
        '@CHUNK',
        '@FILE',
        '@INLINE'
    ];

    /**
     * SuperBoxSelect constructor
     *
     * @param modX $modx A reference to the modX instance.
     * @param array $options An array of options. Optional.
     */
    public function __construct(modX &$modx, $options = [])
    {
        $this->modx =& $modx;

        $corePath = $this->getOption('core_path', $options, $this->modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/' . $this->namespace . '/');
        $assetsPath = $this->getOption('assets_path', $options, $this->modx->getOption('assets_path', null, MODX_ASSETS_PATH) . 'components/' . $this->namespace . '/');
        $assetsUrl = $this->getOption('assets_url', $options, $this->modx->getOption('assets_url', null, MODX_ASSETS_URL) . 'components/' . $this->namespace . '/');
        $modxversion = $this->modx->getVersionData();

        // Load some default paths for easier management
        $this->options = array_merge([
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
        ], $options);

        // Add default options
        $this->options = array_merge($this->options, [
            'debug' => (bool)$this->modx->getOption($this->namespace . '.debug', null, '0') == 1,
            'modxversion' => $modxversion['version'],
            'advanced' => (bool)$this->getOption('advanced')
        ]);

        $lexicon = $this->modx->getService('lexicon', 'modLexicon');
        $lexicon->load($this->namespace . ':default');
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
    public function getOption($key, $options = [], $default = null)
    {
        $option = $default;
        if (!empty($key) && is_string($key)) {
            if ($options != null && array_key_exists($key, $options)) {
                $option = $options[$key];
            } elseif (array_key_exists($key, $this->options)) {
                $option = $this->options[$key];
            } elseif (array_key_exists("$this->namespace.$key", $this->modx->config)) {
                $option = $this->modx->getOption("$this->namespace.$key");
            }
        }
        return $option;
    }

    /**
     * Register javascripts in the controller
     */
    public function includeScriptAssets()
    {
        $assetsUrl = $this->getOption('assetsUrl');
        $jsUrl = $this->getOption('jsUrl') . 'mgr/';
        $jsSourceUrl = $assetsUrl . '../../../source/js/mgr/';
        $nodeModulesUrl = $assetsUrl . '../../../node_modules/';
        $cssUrl = $this->getOption('cssUrl') . 'mgr/';
        $cssSourceUrl = $assetsUrl . '../../../source/css/mgr/';

        if ($this->getOption('debug') && $assetsUrl != MODX_ASSETS_URL . 'components/superboxselect/') {
            $this->modx->controller->addJavascript($nodeModulesUrl . 'sortablejs/Sortable.js?v=v' . $this->version);
            $this->modx->controller->addJavascript($jsSourceUrl . 'superboxselect.js?v=v' . $this->version);
            $this->modx->controller->addJavascript($jsSourceUrl . 'superboxselect.panel.inputoptions.js?v=v' . $this->version);
            $this->modx->controller->addJavascript($jsSourceUrl . 'superboxselect.combo.templatevar.js?v=v' . $this->version);
            $this->modx->controller->addCss($cssSourceUrl . 'superboxselect.css?v=v' . $this->version);
        } else {
            $this->modx->controller->addJavascript($jsUrl . 'superboxselect.min.js?v=v' . $this->version);
            $this->modx->controller->addCss($cssUrl . 'superboxselect.min.css?v=v' . $this->version);
        }

        // Load input option panel scripts
        $types = $this->getTypes();
        if ($this->getOption('debug') && ($assetsUrl != MODX_ASSETS_URL . 'components/superboxselect/')) {
            foreach ($types as $type) {
                $this->modx->controller->addJavascript($this->getOption('assetsUrl') . '../../../source/js/types/' . $type . '/superboxselect.panel.inputoptions.js?v=v' . $this->version);
            }
        } else {
            foreach ($types as $type) {
                $this->modx->controller->addJavascript($this->getOption('jsUrl') . 'types/' . $type . '/superboxselect.panel.inputoptions.min.js?v=v' . $this->version);
            }
        }

        // Load external inputoption panel scripts
        $this->modx->invokeEvent('OnSuperboxselectTypeOptions', [
            'option' => 'scripts',
            'debug' => $this->getOption('debug')
        ]);

        $this->modx->controller->addHtml('<script type="text/javascript">'
            . 'SuperBoxSelect.config = ' . json_encode($this->options, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . ';'
            . '</script>');
    }

    /**
     * Get the types
     *
     * @return array
     */
    public function getTypes()
    {
        $types = [];
        $files = glob($this->getOption('processorsPath') . 'types/*', GLOB_ONLYDIR);
        foreach ($files as $file) {
            $types[] = basename($file);
        }
        return $types;
    }

    /**
     * Get the inputoption types
     *
     * @return string
     */
    public function getInputOptionTypes()
    {
        $internalTypes = $this->getTypes();
        $types = [];
        foreach ($internalTypes as $internalType) {
            $response = $this->modx->runProcessor('types/' . $internalType . '/options', [
                'option' => 'inputOptionType',
            ], [
                'processors_path' => $this->getOption('processorsPath')
            ]);
            if (empty($response->errors)) {
                $types[] = $response->response['type'];
            }
        }

        // Add external custom inputoption xtypes
        $customTypes = $this->modx->invokeEvent('OnSuperboxselectTypeOptions', [
            'option' => 'inputOptions'
        ]);
        foreach ($customTypes as $customType) {
            $customType = unserialize($customType);
            if ($customType) {
                $types = array_merge($types, $customType);
            }
        }

        $this->modx->smarty->assign('types', implode(',', $types));
        return $this->modx->smarty->fetch($this->getOption('templatesPath') . 'inputoptionstypes.tpl');
    }

    /**
     * Parse a chunk (with template bindings)
     * Modified parseTplElement method from getResources package (https://github.com/opengeek/getResources)
     *
     * @param $type
     * @param $source
     * @param null $properties
     * @return bool|string
     */
    private function parseChunk($type, $source, $properties = null)
    {
        $output = false;

        if (!is_string($type) || !in_array($type, $this->_validTypes)) {
            $type = $this->modx->getOption('tplType', $properties, '@CHUNK');
        }

        $content = false;
        switch ($type) {
            case '@FILE':
                $path = $this->modx->getOption('tplPath', $properties, $this->modx->getOption('assets_path', $properties, MODX_ASSETS_PATH) . 'elements/chunks/');
                $key = $path . $source;
                if (!isset($this->_tplCache['@FILE'])) {
                    $this->_tplCache['@FILE'] = [];
                }
                if (!array_key_exists($key, $this->_tplCache['@FILE'])) {
                    if (file_exists($key)) {
                        $content = file_get_contents($key);
                    }
                    $this->_tplCache['@FILE'][$key] = $content;
                } else {
                    $content = $this->_tplCache['@FILE'][$key];
                }
                if (!empty($content) && $content !== '0') {
                    $chunk = $this->modx->newObject('modChunk', ['name' => $key]);
                    $chunk->setCacheable(false);
                    $output = $chunk->process($properties, $content);
                }
                break;
            case '@INLINE':
                $uniqid = uniqid();
                $chunk = $this->modx->newObject('modChunk', ['name' => "$type-$uniqid"]);
                $chunk->setCacheable(false);
                $output = $chunk->process($properties, $source);
                break;
            case '@CHUNK':
            default:
                $chunk = null;
                if (!isset($this->_tplCache['@CHUNK'])) {
                    $this->_tplCache['@CHUNK'] = [];
                }
                if (!array_key_exists($source, $this->_tplCache['@CHUNK'])) {
                    $chunk = $this->modx->getObject('modChunk', ['name' => $source]);
                    if ($chunk) {
                        $this->_tplCache['@CHUNK'][$source] = $chunk->toArray('', true);
                    } else {
                        $this->_tplCache['@CHUNK'][$source] = false;
                    }
                } elseif (is_array($this->_tplCache['@CHUNK'][$source])) {
                    $chunk = $this->modx->newObject('modChunk');
                    $chunk->fromArray($this->_tplCache['@CHUNK'][$source], '', true, true, true);
                }
                if (is_object($chunk)) {
                    $chunk->setCacheable(false);
                    $output = $chunk->process($properties);
                }
                break;
        }
        return $output;
    }

    /**
     * @param $string
     * @return string
     */
    public function stripModxTags($string)
    {
        return preg_replace('/\[\[([^\[\]]++|(?R))*?]]/sm', '', $string);
    }

    /**
     * Get and parse a chunk (with template bindings)
     * Modified parseTpl method from getResources package (https://github.com/opengeek/getResources)
     *
     * @param $tpl
     * @param null $properties
     * @return bool|string
     */
    public function getChunk($tpl, $properties = null)
    {
        if (class_exists('pdoTools') && $pdo = $this->modx->getService('pdoTools')) {
            $output = $pdo->getChunk($tpl, $properties);
        } else {
            $output = false;
            if (!empty($tpl)) {
                $bound = [
                    'type' => '@CHUNK',
                    'value' => $tpl
                ];
                if (strpos($tpl, '@') === 0) {
                    $endPos = strpos($tpl, ' ');
                    if ($endPos > 2 && $endPos < 10) {
                        $tt = substr($tpl, 0, $endPos);
                        if (in_array($tt, $this->_validTypes)) {
                            $bound['type'] = $tt;
                            $bound['value'] = substr($tpl, $endPos + 1);
                        }
                    }
                }
                if (is_array($bound) && isset($bound['type']) && isset($bound['value'])) {
                    $output = $this->parseChunk($bound['type'], $bound['value'], $properties);
                }
                if (isset($properties['stripModxTags']) && $properties['stripModxTags']) {
                    $output = $this->stripModxTags($output);
                }
            }
        }
        return $output;
    }
}
