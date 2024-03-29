<?php
namespace Grav\Plugin;

use \Grav\Common\Grav;
use \Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

class MarkdownCollapsiblePlugin extends Plugin
{
    protected $level_classes;

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'onMarkdownInitialized' => ['onMarkdownInitialized', 0],
            'onTwigSiteVariables'   => ['onTwigSiteVariables', 0],
            'onAssetsInitialized'   => ['onAssetsInitialized', 0]
        ];
    }

    public function onMarkdownInitialized(Event $event)
    {
        $markdown = $event['markdown'];

        $markdown->addBlockType('!', 'Collapsible', false, false);

        $markdown->blockCollapsible = function($Line) {
            $do_autoscroll = $this->config->get('plugins.markdown-collapsible.do_autoscroll');
            if($do_autoscroll){
                $offset = $this->config->get('plugins.markdown-collapsible.scroll_offset');  
            }

            
            if (preg_match('/^!>(\[(\w[\w-]*)\])?\s*(.*)$/', $Line['text'], $matches))
            {
                $name = $matches[2];
                $text = $matches[3];
            } else if (preg_match('/^!>\s*(.*)$/', $Line['text'], $matches))
            {
                $name = NULL;
                $text = $matches[1];
            }
            if (isset($text))
            {
                $id = Grav::instance()['inflector']->hyphenize($text);
                $attrs = $name ? array('name'=>$name, 'id'=>$id) : array('id'=>$id);

                $Block = array(
                    'name' => 'input',
                    'markup' => '<input class="collapsible" id="'.$id.'" '.($name ? ' type="radio" name="'.$name.'"' : ' type="checkbox"').'><label class="collapsible'.(!$do_autoscroll ? ' no-scroll' : '').'" for="'.$id.'">'.$text.'</label><div class="collapsible">',
                );
                return $Block;
            }

            if (preg_match('/^!@(.*)$/', $Line['text'], $matches))
            {
                $Block = array('name' => 'div', 'markup' => '</div>');
                return $Block;
            }
        };
        $markdown->blockCollapsibleContinue = function($Line, array $Block) {
            if ( isset( $Block['interrupted'] ) )
            {
                return;
            }
            if (preg_match('/^!@(.*)/', $Line['text'], $matches))
            {
                $Block = array('name' => 'div', 'markup' => '</div>');
                $Block['closed'] = true;
                return $Block;
            }
        };
    }
    
    public function onAssetsInitialized()
    {
        $offset = $this->config->get('plugins.markdown-collapsible.scroll_offset');
        if ($this->config->get('plugins.markdown-collapsible.do_autoscroll') && $offset > 0 )
        {
            $this->grav['assets']->addInlineCss('label.collapsible { scroll-margin: '.$offset.'px; }');
        }
    }

    public function onTwigSiteVariables()
    {
        if ($this->config->get('plugins.markdown-collapsible.built_in_css')) {
            $this->grav['assets']->add('plugin://markdown-collapsible/assets/collapsible.css');
        }
        $this->grav['assets']->add('plugin://markdown-collapsible/js/collapsible.js');
    }

}
