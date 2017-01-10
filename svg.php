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
}

/**
 * Manage SVG recoloring
 */
class SVG {

    const IMGDIR = __DIR__ . '/img/';

    /** @var SvgNode */
    protected $xml;

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
            // media files are ACL protected
            if(auth_quickaclcheck($svg)) $this->abort(403);
            $file = mediaFN($svg);
        }
        // check if media exists
        if(!file_exists($file)) $this->abort(404);

        $this->xml = simplexml_load_file($file, SvgNode::class);
    }

    /**
     * Generate and output
     */
    public function out() {
        $this->setStyle();
        header('image/svg+xml');
        echo $this->xml->asXML();
    }

    /**
     * Generate a style setting from the input variables
     *
     * @return string
     */
    protected function makeStyle() {
        global $INPUT;

        $element = 'path'; // FIXME configurable?

        $colors = array(
            's' => $this->fixColor($INPUT->str('s')),
            'f' => $this->fixColor($INPUT->str('f')),
            'sh' => $this->fixColor($INPUT->str('sh')),
            'fh' => $this->fixColor($INPUT->str('fh')),
        );

        $style = '';
        if($colors['s'] || $colors['f']) {
            $style .= $element . '{';
            if($colors['s']) $style .= 'stroke:' . $colors['s'] . ';';
            if($colors['f']) $style .= 'fill:' . $colors['f'] . ';';
            $style .= '}';
        }

        if($colors['sh'] || $colors['fh']) {
            $style .= $element . ':hover{';
            if($colors['sh']) $style .= 'stroke:' . $colors['sh'] . ';';
            if($colors['fh']) $style .= 'fill:' . $colors['fh'] . ';';
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
     * Converts it to rgba() form
     *
     * @param string $color
     * @return string
     */
    protected function fixColor($color) {
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
            return '';
        }

        return "rgba($r,$g,$b,$a)";
    }

    /**
     * Apply the style to the SVG
     */
    protected function setStyle() {
        $defs = $this->xml->defs;
        if(!$defs) {
            $defs = $this->xml->prependChild('defs');
        }
        $defs->addChild('style', $this->makeStyle());
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

}

// main
$svg = new SVG();
$svg->out();

