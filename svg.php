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
}

/**
 * Manage SVG recoloring
 */
class SVG {

    const IMGDIR = __DIR__ . '/img/';
    const BACKGROUNDCLASS = 'sprintdoc-background';

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
        $g = $this->wrapChildren();
        $this->setBackground($g);
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
            'b' => $this->fixColor($INPUT->str('b')),
            'sh' => $this->fixColor($INPUT->str('sh')),
            'fh' => $this->fixColor($INPUT->str('fh')),
            'bh' => $this->fixColor($INPUT->str('bh')),
        );

        if (empty($colors['b'])) {
            $colors['b'] = $this->fixColor('00000000');
        }

        $style = 'g rect.' . self::BACKGROUNDCLASS . '{fill:' . $colors['b'] . ';}';

        if($colors['bh']) {
            $style .= 'g:hover rect.' . self::BACKGROUNDCLASS . '{fill:' . $colors['bh'] . ';}';
        }

        if($colors['s'] || $colors['f']) {
            $style .= 'g ' . $element . '{';
            if($colors['s']) $style .= 'stroke:' . $colors['s'] . ';';
            if($colors['f']) $style .= 'fill:' . $colors['f'] . ';';
            $style .= '}';
        }

        if($colors['sh'] || $colors['fh']) {
            $style .= 'g:hover ' . $element . '{';
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
     * sets a rectangular background of the size of the svg/this itself
     *
     * @param SvgNode $g
     * @return SvgNode
     */
    protected function setBackground(SvgNode $g) {
        $attributes = $this->xml->attributes();
        $rect = $g->prependChild('rect');
        $rect->addAttribute('class', self::BACKGROUNDCLASS);

        $rect->addAttribute('x', '0');
        $rect->addAttribute('y', '0');
        $rect->addAttribute('height', $attributes['height']);
        $rect->addAttribute('width', $attributes['width']);
        return $rect;
    }

    /**
     * Wraps all elements of $this in a `<g>` tag
     *
     * @return SvgNode
     */
    protected function wrapChildren() {
        $svgChildren = array();
        foreach ($this->xml->children() as $child) {
            $svgChildren[] = $this->xml->removeChild($child);
        }
        $g = $this->xml->prependChild('g');
        foreach ($svgChildren as $child) {
            $g->appendNode($child);
        }
        return $g;
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

