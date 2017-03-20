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
    }

    /**
     * Get all the tabs to display
     *
     * @return array
     */
    public function getMetaBoxTabs() {
        global $lang;
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
                'count' => null, // FIXME
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
                'src' => array(tpl_getConf('logo'), 'wiki:logo-wide.png', 'wiki:logo.png'),
                'alt' => $title,
            ),
            0, 0
        );
        $mobile = self::getResizedImgTag(
            'img',
            array(
                'class' => 'mobile-only',
                'src' => array('wiki:logo-32x32.png', 'wiki:favicon.png', 'wiki:logo-square.png', 'wiki:logo.png', tpl_getConf('logo')),
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
}
