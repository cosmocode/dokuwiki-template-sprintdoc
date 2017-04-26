<?php

namespace dokuwiki\template\sprintdoc;

/**
 * Class Template
 *
 * provides additional logic for the sprintdoc template
 *
 * @package dokuwiki\template\sprintdoc
 */
class Template {

    /**
     * @var array loaded plugins
     */
    protected $plugins = array(
        'sqlite' => null,
        'tagging' => null,
        'magicmatcher' => null,
    );

    /**
     * Get the singleton instance
     *
     * @return Template
     */
    public static function getInstance() {
        static $instance = null;
        if($instance === null) $instance = new Template();
        return $instance;
    }

    /**
     * Template constructor.
     */
    protected function __construct() {
        $this->initializePlugins();

        /** @var \Doku_Event_Handler */
        global $EVENT_HANDLER;
        $EVENT_HANDLER->register_hook('PLUGIN_TPLINC_LOCATIONS_SET', 'BEFORE', $this, 'registerIncludes');
    }

    /**
     * Makes include position info available to the tplinc plugin
     *
     * @param \Doku_Event $event
     */
    public function registerIncludes(\Doku_Event $event) {
        $event->data['footer'] = 'Footer below the page content';
        $event->data['sidebarfooter'] = 'Footer below the sidebar';
        $event->data['sidebarheader'] = 'Header above the sidebar';
    }

    /**
     * Get the content to include from the tplinc plugin
     *
     * prefix and postfix are only added when there actually is any content
     *
     * @param string $location
     * @param string $pre prepend this before the content
     * @param string $post append this to the content
     * @return string
     */
    public function getInclude($location, $pre = '', $post = '') {
        if(!$this->plugins['tplinc']) return '';
        $content = $this->plugins['tplinc']->renderIncludes($location);
        if($content === '') return '';
        return $pre . $content . $post;
    }

    /**
     * Load all the plugins we support directly
     */
    protected function initializePlugins() {
        $this->plugins['sqlite'] = plugin_load('helper', 'sqlite');
        if($this->plugins['sqlite']) {
            $this->plugins['tagging'] = plugin_load('helper', 'tagging');
            $this->plugins['magicmatcher'] = plugin_load('syntax', 'magicmatcher_issuelist');
        }
        $this->plugins['tplinc'] = plugin_load('helper', 'tplinc');
    }

    /**
     * Get all the tabs to display
     *
     * @return array
     */
    public function getMetaBoxTabs() {
        global $lang, $INFO;
        $tabs = array();

        $toc = tpl_toc(true);
        if($toc) {
            $tabs[] = array(
                'id' => 'spr__tab-toc',
                'label' => $lang['toc'],
                'tab' => $toc,
                'count' => null,
            );
        }

        if($this->plugins['tagging']) {
            $tabs[] = array(
                'id' => 'spr__tab-tags',
                'label' => tpl_getLang('tab_tags'),
                'tab' => $this->plugins['tagging']->tpl_tags(false),
                'count' => count($this->plugins['tagging']->findItems(array('pid' => $INFO['id']), 'tag')),
            );
        }

        if ($this->plugins['magicmatcher']) {
            $tabs[] = array(
                'id' => 'spr__tab-issues',
                'label' => tpl_getLang('tab_issues'),
                'tab' => $this->plugins['magicmatcher']->getIssueListHTML(),
                'count' =>  $this->plugins['magicmatcher']->getCountIssues(),
            );
        }

        return $tabs;
    }

    /**
     * Creates an image tag and includes the first found image correctly resized
     *
     * @param string $tag
     * @param array $attributes
     * @param int $w
     * @param int $h
     * @return string
     */
    public static function getResizedImgTag($tag, $attributes, $w, $h) {
        $attr = '';
        $medias = array();

        // the attribute having an array defines where the image goes
        foreach($attributes as $attribute => $data) {
            if(is_array($data)) {
                $medias = $data;
                $attr = $attribute;
            }
        }
        // if the image attribute could not be found return
        if(!$attr || !$medias) return '';

        // try all medias until an existing one is found
        $media = '';
        foreach($medias as $media) {
            if(file_exists(mediaFN($media))) break;
            $media = '';
        }
        if($media === '') return '';

        // replace the array
        $media = ml($media, array('w' => $w, 'h' => $h, 'crop' => 1), true, '&');
        $attributes[$attr] = $media;

        // return the full tag
        return '<' . $tag . ' ' . buildAttributes($attributes) . ' />' . "\n";
    }

    /**
     * Embed the main logo
     *
     * Tries a few different locations
     */
    public function mainLogo() {
        global $conf;

        // homepage logo should not link to itself (BITV accessibility requirement)
        $linkit = (strcmp(wl(), $_SERVER['REQUEST_URI']) !== 0);
        if($linkit) {
            $title = $conf['title'] . tpl_getLang('adjunct_linked_logo_text');
        } else {
            $title = tpl_getLang('adjunct_start_logo_text') . $conf['title'];
        }

        $desktop = self::getResizedImgTag(
            'img',
            array(
                'class' => 'mobile-hide',
                'src' => array('wiki:logo-wide.png', 'wiki:logo.png'),
                'alt' => $title,
            ),
            0, 0
        );
        $mobile = self::getResizedImgTag(
            'img',
            array(
                'class' => 'mobile-only',
                'src' => array('wiki:logo-32x32.png', 'wiki:favicon.png', 'wiki:logo-square.png', 'wiki:logo.png'),
                'alt' => $title,
            ),
            32, 32
        );

        // homepage logo should not link to itself (BITV accessibility requirement)
        if($linkit) {
            tpl_link(wl(), $desktop, 'accesskey="h" title="[H]"');
            tpl_link(wl(), $mobile, 'accesskey="h" title="[H]"');
        } else {
            echo $desktop;
            echo $mobile;
        }
    }

    /**
     * Add the current mode information to the hierarchical breadcrumbs
     */
    public function breadcrumbSuffix() {
        global $ACT;
        global $lang;
        global $INPUT;
        global $ID;
        global $conf;
        global $IMG;
        if($ACT == 'show') return;

        // find an apropriate label for the current mode
        if($ACT) {
            $label = tpl_getLang('mode_' . $ACT);
            if(!$label) {
                if(isset($lang['btn_' . $ACT])) {
                    $label = $lang['btn_' . $ACT];
                } else {
                    $label = $ACT;
                }
            }
        } else {
            // actually we would need to create a proper namespace breadcrumb path here,
            // but this is the most simplest thing we can do for now
            if(defined('DOKU_MEDIADETAIL')) {
                $label = hsc(noNS($IMG));
            } else {
                return;
            }
        }

        if($ACT == 'admin' && $INPUT->has('page')) {
            $link = wl($ID, array('do' => 'admin'));
            echo '<bdi> : <a href="' . $link . '"><strong>' . $label . '</strong></a></bdi>';

            /** @var \DokuWiki_Admin_Plugin $plugin */
            $plugin = plugin_load('admin', $INPUT->str('page'));
            if(!$plugin) return;

            $label = $plugin->getMenuText($conf['lang']);
        }

        echo '<bdi><span class="curid"> : <strong>' . $label . '</strong></span></bdi>';
    }
}
