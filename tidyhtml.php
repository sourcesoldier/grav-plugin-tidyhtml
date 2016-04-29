<?php
namespace Grav\Plugin;

use \Grav\Common\Plugin;

/**
 * Tidyhtml GRAV plugin
 *
 * @package Grav\Plugin
 *
 * @author Clemens Queissner <clemens.queissner@cq-design.de> @sourcesoldier
 * @since 2015-11-07
 */

class TidyhtmlPlugin extends Plugin
{

    const PLUGIN_CONFIG_PATH = 'plugins.tidyhtml';

    /** -------------
     * Public methods
     * --------------
     */

    /**
     * Return a list of subscribed events.
     *
     * @return array    The list of events of the plugin of the form
     *                      'name' => ['method_name', priority].
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
        ];
    }


    /**
     * Initialize configuration and checking for presence of tidy
     */
    public function onPluginsInitialized()
    {
        if ($this->isAdmin()) {
            $this->active = false;
            return;
        }
        if(extension_loaded('tidy')) {
            $this->enable([
                'onOutputGenerated' => ['onOutputGenerated', 0]
            ]);
        }
    }

    /**
     * Retrieves the actual output intend and parses it to tidyPHP for cleanup
     * cleaned up content the gets set to the grav context again.
     */
    public function onOutputGenerated()
    {
            if($this->skipCurrentSite($this->grav['uri']->path())) {
                return;
            }

            $originOutput = $this->grav->output;

            $config = array(
                'indent'                =>  $this->_getConfigSetting('indent'),
                'indent-spaces'         =>  $this->_getConfigSetting('indent_spaces'),
                'wrap'                  =>  $this->_getConfigSetting('wrap'),
                'hide-comments'         =>  $this->_getConfigSetting('hide_comments'),
                'new-blocklevel-tags'   =>  implode(' ', $this->_getConfigSetting('blocklevel_tags')),
                'new-empty-tags'        =>  implode(' ', $this->_getConfigSetting('empty_tags')),
                'new-inline-tags'       =>  implode(' ', $this->_getConfigSetting('inline_tags')),
                'newline'               => 'LF',
            );

            /** @var tidy $tidy */
            $tidy = tidy_parse_string($originOutput, $config, 'UTF8');
            $tidy->cleanRepair();
            $this->grav->output = $tidy;
    }

    /**
     * Checks if the passed url path ist configure to be ignored
     *
     * @param string $path
     * @return bool
     */
    public function skipCurrentSite($path) {
        $ignoredSites = (array) $this->_getConfigSetting('pages');
        if(in_array($path, $ignoredSites)) {
            return true;
        }

        return false;
    }

    /**
     * Gets values for a specific config node of the plugin
     *
     * @param string $node
     * @return mixed
     */
    protected function _getConfigSetting($node) {
        return $this->config->get(self::PLUGIN_CONFIG_PATH . '.' . $node);
    }
}
