<?php
global $conf;

if ($conf['license']) {
    echo '<p>';
    tpl_license($img = false, $imgonly = false, $return = false, $wrap = false);
    echo '</p>';
}

if (tpl_getConf('copyright')) {
    $copy = str_replace(
        [
            '%year%',
            '%title%',
            '%TITLE%',
        ],
        [
            date('Y'),
            $conf['title'],
            dokuwiki\Utf8\PhpString::strtoupper($conf['title']),
        ],
        tpl_getConf('copyright')
    );
    echo '<p>' . $copy . '</p>';
}
