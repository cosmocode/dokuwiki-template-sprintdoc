<?php
/**
 * Embed the various bookmarking icon sizes
 *
 * Basically it will first check for an exact image in the right size in the wiki namespace, then for generally named
 * logos in the wiki namespace and finally it falls back to the logo configured in the template.
 *
 *
 * @author Andreas Gohr <gohr@cosmocode.de>
 */
use dokuwiki\template\sprintdoc\Template;

if(!defined('DOKU_INC')) die();

// standard favicon
echo Template::getResizedImgTag(
    'link',
    array(
        'rel' => 'shortcut icon',
        'href' => array('wiki:favicon.ico', 'wiki:favicon.png', 'wiki:logo-square.png')
    ),
    0, 0 // no scaling
);

// square apple icons
foreach(array(57, 60, 72, 76, 114, 120, 144, 152, 180) as $size) {
    echo Template::getResizedImgTag(
        'link',
        array(
            'rel' => 'apple-touch-icon',
            'sizes' => $size . 'x' . $size,
            'href' => array('wiki:logo-' . $size . 'x' . $size . '.png', 'wiki:logo-square.png', 'wiki:favicon.ico', 'wiki:favicon.png', 'wiki:logo.png'),
        ),
        $size, $size
    );
}

// square favicons
foreach(array(32, 96, 192) as $size) {
    echo Template::getResizedImgTag(
        'link',
        array(
            'rel' => 'icon',
            'sizes' => $size . 'x' . $size,
            'href' => array('wiki:logo-' . $size . 'x' . $size . '.png', 'wiki:logo-square.png', 'wiki:favicon.ico', 'wiki:favicon.png', 'wiki:logo.png')
        ),
        $size, $size
    );
}

// square microsoft icons
foreach(array(70, 310) as $size) {
    echo Template::getResizedImgTag(
        'meta',
        array(
            'name' => 'msapplication-square' . $size . 'x' . $size . 'logo',
            'content' => array('wiki:logo-' . $size . 'x' . $size . '.png', 'wiki:logo-square.png', 'wiki:favicon.ico', 'wiki:favicon.png', 'wiki:logo.png'),
        ),
        $size, $size
    );
}

// wide micorsoft icons
foreach(array(array(310, 150)) as $size) {
    echo Template::getResizedImgTag(
        'meta',
        array(
            'name' => 'msapplication-wide' . $size[0] . 'x' . $size[1] . 'logo',
            'content' => array('wiki:logo-' . $size[0] . 'x' . $size[1] . '.png', 'wiki:logo-wide.png', 'wiki:logo.png')
        ),
        $size[0], $size[1]
    );
}
