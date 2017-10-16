<!DOCTYPE html>
<?php
/**
 * DokuWiki sprintDoc Detail Template
 *
 * @link     FIXME
 * @author   Jana Deutschlaender <deutschlaender@cosmocode.de>
 * @author   Michael Grosse <grosse@cosmocode.de>
 * @license  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */
use dokuwiki\template\sprintdoc\Template;

if (!defined('DOKU_INC')) die();                        /* must be run from within DokuWiki */
header('X-UA-Compatible: IE=edge,chrome=1');

global $JSINFO;
if (empty($JSINFO['template'])) {
    $JSINFO['template'] = array();
}
$JSINFO['template']['sprintdoc'] = array('sidebar_toggle_elements' => tpl_getConf('sidebar_sections'));

$showTools = true;
$showSidebar =  true;

?>
<html class="edge no-js" lang="<?php echo $conf['lang'] ?>" dir="<?php echo $lang['direction'] ?>">
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
/* page title */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
?>
<title><?php echo hsc(tpl_img_getTag('IPTC.Headline', $IMG)) ?> [<?php echo strip_tags($conf['title']) ?>]</title>

<script type="text/javascript">(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
<?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* favicons */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
?>
<?php
include('tpl/favicon_tiles.php');
?>
<?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* Include Hook: meta.html */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
?>
<?php tpl_includeFile('meta.html') ?>
</head>

<body id="dokuwiki__top" class="<?php echo tpl_classes(); ?> wide-content showSidebar">
<div id="dokuwiki__site">
    <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* template Include: tpl/nav-direct */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
    ?>
    <?php include('tpl/nav-direct.php') ?>


    <div class="page-wrapper <?php echo ($showSidebar) ? 'hasSidebar' : ''; ?>">
        <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* Include Hook: header.html */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
            tpl_includeFile('header.html');
        ?>

        <div id="dokuwiki__header" class="header no-print">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="claim main-sidebar">
                            <div class="menu-togglelink mobile-only">
                                <a href="#">
                                    <span class="sr-out"><?php echo tpl_getLang('a11y_sidebartoggle'); ?></span>
                                </a>
                            </div>

                            <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* Logo */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* upload your logo into the data/media folder (root of the media manager) and replace 'logo.png' in der template config accordingly: */
                                include('tpl/main-sidebar-logo.php');
                            ?>
                            <div class="main-title">
                                <?php if ($conf['title']):


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* Wiki Title Mobile */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */ ?>
                                    <p class="title mobile-only"><?php echo $conf['title'] ?></p>
                                <?php endif ?>
                            </div><!-- .main-title -->

                            <div class="menu-tool-select">
                                <h5 class="sr-only" role="heading" aria-level="2"><?php echo tpl_getLang('head_menu_tool-select') ?></h5>
                                <?php tpl_actiondropdown($lang['tools'], "test"); ?>
                            </div><!-- .menu-tool-select -->
                        </div><!-- .headings -->
                    </div><!-- .col -->


                    <div class="col-xs-12">
                        <div class="main-title desktop-only">
                            <?php if ($conf['title']):


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* Wiki Title Desktop */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */ ?>
                                <p class="title"><?php echo $conf['title'] ?></p>
                            <?php endif ?>
                            <?php if ($conf['tagline']):


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* Wiki Tagline Desktop */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */ ?>
                                <p class="claim"><?php echo $conf['tagline'] ?></p>
                            <?php endif ?>
                        </div><!-- .main-title -->
                    </div><!-- .col -->

                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .header -->
        <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* headline menu area (Accessibility ) */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
        ?>

        <div class="sr-only nav-area-head">
            <h5 class="sr-only" aria-level="1"><?php echo tpl_getLang('nav-area-head') ?></h5>
        </div><!-- .nav-area-head -->

        <div class="tools">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="search main-sidebar">
                            <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* search form */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                                include('tpl/main-sidebar-search.php');
                            ?>
                        </div><!-- .search -->

                        <div class="sidebarheader main-sidebar">
                            <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* Include Hook: sidebarheader.html */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                                tpl_includeFile('sidebarheader.html')
                            ?>
                        </div><!-- .sidebarheader -->

                        <div id="dokuwiki__aside">

                            <?php
                            echo Template::getInstance()->getInclude(
                                'sidebarheader',
                                '<div class="sidebarheader">',
                                '<div class="clearer"></div></div>'
                            );
                            ?>

                            <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* sidebar */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                                include('tpl/main-sidebar-nav.php');
                            ?>

                            <?php
                            echo Template::getInstance()->getInclude(
                                'sidebarfooter',
                                '<div class="sidebarfooter">',
                                '<div class="clearer"></div></div>'
                            );
                            ?>
                        </div><!-- .aside -->

                    </div><!-- .col -->
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .tools -->


        <div class="top-header">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">

                        <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* User Tools but no MagicMatcher Bar */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                        $showTools = true;
                        include('tpl/nav-usertools-buttons.php');


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* Include Hook: header.html */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                        tpl_includeFile('header.html');
                        ?>

                    </div><!-- .col -->
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- /top-header -->


        <div id="dokuwiki__detail">

            <?php tpl_flush(); /* flush the output buffer */ ?>

            <div class="content group">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="breadcrumbs" data-do="<?php echo tpl_getLang('image_detail') ?>">

                                <div class="togglelink page_main-content">
                                    <a id="spr__toggle-content" href="#"><span class="sr-out"><?php echo tpl_getLang('a11y_sidebartoggle') ?></span></a>
                                </div>

                                <h6 class="sr-only" role="heading" aria-level="2"><?php echo tpl_getLang('head_menu_status') ?></h6>

                                <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* breadcrumb */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                                include('tpl/nav-breadcrumb.php');
                                ?>

                                <h6 class="sr-only" role="heading" aria-level="2"><?php echo $lang['page_tools'] ?></h6>

                                <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* page tools */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                                ?>
                                <nav id="dokuwiki__pagetools">
                                    <div class="tools">
                                        <ul>
                                            <?php
                                            echo '<li>' . dokuwiki\template\sprintdoc\tpl::pageToolAction('mediaManager') . '</li>';
                                            echo '<li>' . dokuwiki\template\sprintdoc\tpl::pageToolAction('img_backto') . '</li>';
                                            ?>
                                        </ul>
                                    </div>
                                </nav>

                            </div>
                            <div id="dokuwiki__content" class="page main-content">

                                <div id="spr__meta-box"></div>
                                <div class="msg-area"><?php html_msgarea();/*msg('Information.', 0);msg('Success', 1);msg('Notification', 2);msg('Fehler', -1);*/ ?></div>


                                <?php if ($ERROR): print $ERROR; ?>
                                <?php else: ?>

                                <?php if ($REV) {
                                    echo p_locale_xhtml('showrev');
                                } ?>

                                <h1><?php echo hsc(tpl_img_getTag('IPTC.Headline', $IMG)) ?></h1>
                                <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* image */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                                ?>
                                <div class="img-link">
                                    <?php tpl_img(900, 700); /* the image; parameters: maximum width, maximum height (and more) */ ?>
                                </div>
                                <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* meta data of image */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                                ?>
                                <div class="img_detail">
                                    <?php
                                        $simple_title = hsc(tpl_img_getTag('simple.title'));
                                        if(strlen($simple_title) > 0) {
                                    ?>
                                    <h4><?php print nl2br(hsc(tpl_img_getTag('simple.title'))); ?></h4>
                                    <?php
                                        } else {
                                            echo '<h4>' . tpl_getLang('meta_data') . '</h4>';
                                        }
                                    ?>

                                    <?php
                                    tpl_img_meta();


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* open street maps if geo data is available */
/** @var helper_plugin_spatialhelper_index $spatial */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                                    $spatial = plugin_load('helper', 'spatialhelper_index');
                                    if ($spatial && plugin_load('helper', 'geophp')) {
                                        global $IMG;
                                        $point = $spatial->getCoordsFromExif($IMG);
                                        if ($point) {
                                            $long = $point->getX();
                                            $lat = $point->getY();
                                            $latShort = round($lat, 3);
                                            $longShort = round($long, 3);

                                            $hrefOSM = "https://www.openstreetmap.org/?mlat=$lat&mlon=$long#map=18/$lat/$long";
                                            $srcOSM = 'https://www.openstreetmap.org/export/embed.html?bbox=' . ($long - 0.004) . ',' . ($lat - 0.002) . ',' . ($long + 0.004) . ',' . ($lat + 0.002) . '&layer=mapnik&marker=' . $lat . ',' . $long;
                                            echo '<div class="os-map">';
                                            echo '<h4 lang="en">OSM (Open Street Maps):</h4>';
                                            echo '<iframe width="100%" height="350" frameborder="0" src="' . $srcOSM . '"></iframe><br/><p><a class="button" target="_blank" title="' . tpl_getLang('osm_zoom_link_title') . '" href="' . $hrefOSM . '">' . tpl_getLang('osm_zoom_link_text') . '</a></p>';
                                            echo '</div>';
                                        }
                                    }
                                    ?>
                                    <?php //Comment in for Debug// dbg(tpl_img_getTag('Simple.Raw')); ?>
                                </div>
                            </div><!-- .main-content -->
                        </div><!-- .col -->
                    </div><!-- .row -->
                </div><!-- .container -->
            </div><!-- /.content -->


        <?php endif; ?>
        </div>
    </div><!-- /wrapper -->


    <!-- ********** FOOTER ********** -->

    <div id="dokuwiki__footer">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">

                    <div class="main-footer">
                        <p>
                            <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* copyright */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                            tpl_license($img = false, $imgonly = false, $return = false, $wrap = false);
                            ?>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div><!-- /footer -->


    <?php tpl_includeFile('footer.html') ?>
</div><!-- .dokuwiki__site -->

<div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>

</body>
</html>
