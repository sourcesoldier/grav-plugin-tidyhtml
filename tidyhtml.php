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
            $originOutput = $this->grav->output;

            $config = array(
                'indent'                =>  $this->config->get('plugins.tidyhtml.indent'),
                'indent-spaces'         =>  $this->config->get('plugins.tidyhtml.indent_spaces'),
                'wrap'                  =>  $this->config->get('plugins.tidyhtml.wrap'),
                'hide-comments'         =>  $this->config->get('plugins.tidyhtml.hide_comments'),
                'new-blocklevel-tags'   =>  implode(' ', $this->config->get('plugins.tidyhtml.blocklevel_tags')),
                'new-empty-tags'        =>  implode(' ', $this->config->get('plugins.tidyhtml.empty_tags')),
                'new-inline-tags'       =>  implode(' ', $this->config->get('plugins.tidyhtml.inline_tags')),
                'newline'               => 'LF',
            );

            /** @var tidy $tidy */
            $tidy = tidy_parse_string($originOutput, $config, 'UTF8');
            $tidy->cleanRepair();
            $this->grav->output = $tidy;
    }
}