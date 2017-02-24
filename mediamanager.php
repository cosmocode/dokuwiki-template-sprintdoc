<?php
/**
 * DokuWiki Media Manager Popup
 *
 * @link     FIXME
 * @author   Andreas Gohr <andi@splitbrain.org>, Jana Deutschlaender <deutschlaender@cosmocode.de>
 * @license  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */
// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();
header('X-UA-Compatible: IE=edge,chrome=1');

/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* conditional comments for IE8 / IE9 browser detection if needed */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
?>
<!--[if lt IE 9]> <html class="no-js lt-ie10 lt-ie9" lang="<?php echo $conf['lang'] ?>" dir="<?php echo $lang['direction'] ?>"> <![endif]-->
<!--[if IE 9]> <html class="no-js lt-ie10 ie-9" lang="<?php echo $conf['lang'] ?>" dir="<?php echo $lang['direction'] ?>"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="edge no-js" lang="<?php echo $conf['lang'] ?>" dir="<?php echo $lang['direction'] ?>"> <!--<![endif]-->
<head>
    <?php


    /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
    /* meta and link relations */
    /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
    ?>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php tpl_metaheaders() ?>
    <?php


    /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
    /* conditional comments for HTML5 / media queries support in IE8 */
    /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
    ?>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php


    /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
    /* page title */
    /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
    ?>
    <title><?php tpl_pagetitle() ?> [<?php echo strip_tags($conf['title']) ?>]</title>

    <script type="text/javascript">(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>

    <?php


    /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
    /* favicons */
    /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
    ?>
    <?php
    echo tpl_favicon(array('favicon')); /* DokuWiki: favicon.ico  */
    include('tpl/favicon_tiles.php');
    ?>
    <?php


    /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
    /* Include Hook: meta.html */
    /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
    ?>
    <?php tpl_includeFile('meta.html') ?>
</head>

<body>
    <?php


    /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
    /* uses body markup of main.php following markup is included with tpl_content();
    /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
    ?>

    <div id="media__manager" class="dokuwiki">
        <?php html_msgarea() ?>
        <div id="mediamgr__aside">
            <div class="pad">
                <h1><?php echo hsc($lang['mediaselect'])?></h1>

                <?php /* keep the id! additional elements are inserted via JS here */?>
                <div id="media__opts"></div>

                <?php tpl_mediaTree() ?>
            </div>
        </div>
        <div id="mediamgr__content">
            <div class="pad">
                <?php tpl_mediaContent() ?>
            </div>
        </div>
    </div>

</body>
</html>
