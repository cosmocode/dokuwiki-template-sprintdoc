<?php

namespace dokuwiki\template\sprintdoc;

if(!defined('DOKU_INC')) define('DOKU_INC', dirname(__FILE__) . '/../../../');
require_once(DOKU_INC . 'inc/init.php');

/**
 * Custom XML node that allows prepending
 */
class SvgNode extends \SimpleXMLElement {
    /**
     * @param string $name Name of the new node
     * @param null|string $value
     * @return SvgNode
     */
    public function prependChild($name, $value = null) {
        $dom = dom_import_simplexml($this);

        $new = $dom->insertBefore(
            $dom->ownerDocument->createElement($name, $value),
            $dom->firstChild
        );

        return simplexml_import_dom($new, get_class($this));
    }

    /**
     * @param \SimpleXMLElement $node the node to be added
     * @return \SimpleXMLElement
     */
    public function appendNode(\SimpleXMLElement $node) {
        $dom = dom_import_simplexml($this);
        $domNode = dom_import_simplexml($node);

        $newNode = $dom->appendChild($domNode);
        return simplexml_import_dom($newNode, get_class($this));
    }

    /**
     * @param \SimpleXMLElement $node the child to remove
     * @return \SimpleXMLElement
     */
    public function removeChild(\SimpleXMLElement $node) {
        $dom = dom_import_simplexml($node);
        $dom->parentNode->removeChild($dom);
        return $node;
    }

    /**
     * Wraps all elements of $this in a `<g>` tag
     *
     * @return SvgNode
     */
    public function groupChildren() {
        $dom = dom_import_simplexml($this);

        $g = $dom->ownerDocument->createElement('g');
        while($dom->childNodes->length > 0) {
            $child = $dom->childNodes->item(0);
            $dom->removeChild($child);
            $g->appendChild($child);
        }
        $g = $dom->appendChild($g);

        return simplexml_import_dom($g, get_class($this));
    }

    /**
     * Add new style definitions to this element
     * @param string $style
     */
    public function addStyle($style) {
        $defs = $this->defs;
        if(!$defs) {
            $defs = $this->prependChild('defs');
        }
        $defs->addChild('style', $style);
    }
}

/**
 * Manage SVG recoloring
 */
class SVG {

    const IMGDIR = __DIR__ . '/img/';
    const BACKGROUNDCLASS = 'sprintdoc-background';
    const CDNBASE = 'https://cdn.rawgit.com/Templarian/MaterialDesign/master/icons/svg/';

    protected $file;
    protected $replacements;

    /**
     * SVG constructor
     */
    public function __construct() {
        global $INPUT;

        $svg = cleanID($INPUT->str('svg'));
        if(blank($svg)) $this->abort(404);

        // try local file first
        $file = self::IMGDIR . $svg;
        if(!file_exists($file)) {
            // try media file
            $file = mediaFN($svg);
            if(file_exists($file)) {
                // media files are ACL protected
                if(auth_quickaclcheck($svg) < AUTH_READ) $this->abort(403);
            } else {
                // get it from material design icons
                $file = getCacheName($svg, '.svg');
                if (!file_exists($file)) {
                    io_download(self::CDNBASE . $svg, $file);
                }
            }

        }
        // check if media exists
        if(!file_exists($file)) $this->abort(404);

        $this->file = $file;
    }

    /**
     * Generate and output
     */
    public function out() {
        global $conf;
        $file = $this->file;
        $params = $this->getParameters();

        header('Content-Type: image/svg+xml');
        $cachekey = md5($file . serialize($params) . $conf['template'] . filemtime(__FILE__));
        $cache = new \cache($cachekey, '.svg');
        $cache->_event = 'SVG_CACHE';

        http_cached($cache->cache, $cache->useCache(array('files' => array($file, __FILE__))));
        if($params['e']) {
            $content = $this->embedSVG($file);
        } else {
            $content = $this->generateSVG($file, $params);
        }
        http_cached_finish($cache->cache, $content);
    }

    /**
     * Generate a new SVG based on the input file and the parameters
     *
     * @param string $file the SVG file to load
     * @param array $params the parameters as returned by getParameters()
     * @return string the new XML contents
     */
    protected function generateSVG($file, $params) {
        /** @var SvgNode $xml */
        $xml = simplexml_load_file($file, SvgNode::class);
        $xml->addStyle($this->makeStyle($params));
        $this->createBackground($xml);
        $xml->groupChildren();

        return $xml->asXML();
    }

    /**
     * Return the absolute minimum path definition for direct embedding
     *
     * No styles will be applied. They have to be done in CSS
     *
     * @param string $file the SVG file to load
     * @return string the new XML contents
     */
    protected function embedSVG($file) {
        /** @var SvgNode $xml */
        $xml = simplexml_load_file($file, SvgNode::class);

        $def = hsc((string) $xml->path['d']);
        $w = hsc($xml['width']);
        $h = hsc($xml['height']);
        $v = hsc($xml['viewBox']);

        return "<svg width=\"$w\" height=\"$h\" viewBox=\"$v\"><path d=\"$def\" /></svg>";
    }

    /**
     * Get the supported parameters from request
     *
     * @return array
     */
    protected function getParameters() {
        global $INPUT;

        $params = array(
            'e' => $INPUT->bool('e', false),
            's' => $this->fixColor($INPUT->str('s')),
            'f' => $this->fixColor($INPUT->str('f')),
            'b' => $this->fixColor($INPUT->str('b')),
            'sh' => $this->fixColor($INPUT->str('sh')),
            'fh' => $this->fixColor($INPUT->str('fh')),
            'bh' => $this->fixColor($INPUT->str('bh')),
        );

        return $params;
    }

    /**
     * Generate a style setting from the input variables
     *
     * @param array $params associative array with the given parameters
     * @return string
     */
    protected function makeStyle($params) {
        $element = 'path'; // FIXME configurable?

        if(empty($params['b'])) {
            $params['b'] = $this->fixColor('00000000');
        }

        $style = 'g rect.' . self::BACKGROUNDCLASS . '{fill:' . $params['b'] . ';}';

        if($params['bh']) {
            $style .= 'g:hover rect.' . self::BACKGROUNDCLASS . '{fill:' . $params['bh'] . ';}';
        }

        if($params['s'] || $params['f']) {
            $style .= 'g ' . $element . '{';
            if($params['s']) $style .= 'stroke:' . $params['s'] . ';';
            if($params['f']) $style .= 'fill:' . $params['f'] . ';';
            $style .= '}';
        }

        if($params['sh'] || $params['fh']) {
            $style .= 'g:hover ' . $element . '{';
            if($params['sh']) $style .= 'stroke:' . $params['sh'] . ';';
            if($params['fh']) $style .= 'fill:' . $params['fh'] . ';';
            $style .= '}';
        }

        return $style;
    }

    /**
     * Takes a hexadecimal color string in the following forms:
     *
     * RGB
     * RRGGBB
     * RRGGBBAA
     *
     * Converts it to rgba() form.
     *
     * Alternatively takes a replacement name from the current template's style.ini
     *
     * @param string $color
     * @return string
     */
    protected function fixColor($color) {
        if($color === '') return '';
        if(preg_match('/^([0-9a-f])([0-9a-f])([0-9a-f])$/i', $color, $m)) {
            $r = hexdec($m[1] . $m[1]);
            $g = hexdec($m[2] . $m[2]);
            $b = hexdec($m[3] . $m[3]);
            $a = hexdec('ff');
        } elseif(preg_match('/^([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})?$/i', $color, $m)) {
            $r = hexdec($m[1]);
            $g = hexdec($m[2]);
            $b = hexdec($m[3]);
            if(isset($m[4])) {
                $a = hexdec($m[4]);
            } else {
                $a = hexdec('ff');
            }
        } else {
            if(is_null($this->replacements)) $this->initReplacements();
            if(isset($this->replacements[$color])) {
                return $this->replacements[$color];
            }
            if(isset($this->replacements['__' . $color . '__'])) {
                return $this->replacements['__' . $color . '__'];
            }
            return '';
        }

        return "rgba($r,$g,$b,$a)";
    }

    /**
     * sets a rectangular background of the size of the svg/this itself
     *
     * @param SvgNode $g
     * @return SvgNode
     */
    protected function createBackground(SvgNode $g) {
        $rect = $g->prependChild('rect');
        $rect->addAttribute('class', self::BACKGROUNDCLASS);

        $rect->addAttribute('x', '0');
        $rect->addAttribute('y', '0');
        $rect->addAttribute('height', '100%');
        $rect->addAttribute('width', '100%');
        return $rect;
    }

    /**
     * Abort processing with given status code
     *
     * @param int $status
     */
    protected function abort($status) {
        http_status($status);
        exit;
    }

    /**
     * Initialize the available replacement patterns
     *
     * Loads the style.ini from the template (and various local locations)
     * via a core function only available through some hack.
     */
    protected function initReplacements() {
        global $conf;
        if (!class_exists('\dokuwiki\StyleUtils')) {
            // Pre-Greebo Compatibility

            define('SIMPLE_TEST', 1); // hacky shit
            include DOKU_INC . 'lib/exe/css.php';
            $ini = css_styleini($conf['template']);
            $this->replacements = $ini['replacements'];
            return;
        }

        $stuleUtils = new \dokuwiki\StyleUtils();
        $ini = $stuleUtils->cssStyleini('sprintdoc');
        $this->replacements = $ini['replacements'];
    }
}

// main
$svg = new SVG();
$svg->out();


