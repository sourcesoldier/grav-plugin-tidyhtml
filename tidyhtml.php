<?php
namespace Grav\Plugin;

use \Grav\Common\Plugin;


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
     * Initialize configuration
     */
    public function onPluginsInitialized()
    {
        if ($this->isAdmin()) {
            $this->active = false;
            return;
        }

        $this->enable([
            'onOutputGenerated' => ['onOutputGenerated', 0]
        ]);
    }

    public function onOutputGenerated()
    {
            $orginOutput = $this->grav->output;

            $config = array(
                'indent' => true,
                'indent-spaces' => 4,
                'wrap' => 0,
                'hide-comments' => 1,
                'new-blocklevel-tags' => 'article aside audio bdi canvas details dialog figcaption figure footer header hgroup main menu menuitem nav section source summary template track video',
                'new-empty-tags' => 'command embed keygen source track wbr',
                'new-inline-tags' => 'audio command datalist embed keygen mark menuitem meter output progress source time video wbr data',
                'newline' => 0,
            );

            /** @var tidy $tidy */
            $tidy = tidy_parse_string($orginOutput, $config, 'UTF8');
            $tidy->cleanRepair();
            $this->grav->output = $tidy;

    }
}