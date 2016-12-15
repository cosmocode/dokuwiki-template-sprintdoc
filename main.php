<!DOCTYPE html>
<?php

/**
 * DokuWiki sprintDoc Template
 *
 * @link     FIXME
 * @author   Jana Deutschlaender <deutschlaender@cosmocode.de>
 * @license  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

if (!defined('DOKU_INC')) die();                        /* must be run from within DokuWiki */
@require_once(dirname(__FILE__).'/tpl_functions.php');  /* include hook for template functions */
header('X-UA-Compatible: IE=edge,chrome=1');

$showTools = !tpl_getConf('hideTools') || ( tpl_getConf('hideTools') && !empty($_SERVER['REMOTE_USER']) );
$showSidebar = page_findnearest($conf['sidebar']) && ($ACT=='show');


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
<?php


/* #dokuwiki__top used as anchor for "back to top" button/link links */
?>
<body id="dokuwiki__top" class="<?php echo tpl_classes(); ?>">

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
/* Message AREA */
/* FIXME: position of error + info messages. Does it have to be on top of the page? */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
            html_msgarea();


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* Include Hook: header.html */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
            tpl_includeFile('header.html');
            ?>

            <div id="dokuwiki__header" class="header no-print">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="headings main-sidebar">
                                <?php if (tpl_getConf('logo') && file_exists(mediaFN(tpl_getConf('logo')))){


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* Logo */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* upload your logo into the data/media folder (root of the media manager) and replace 'logo.png' in der template config accordingly: */
                                    include('tpl/main-sidebar-logo.php');
                                 } ?>
                                <?php if ($conf['tagline']): ?>
                                    <p class="claim"><?php echo $conf['tagline'] ?></p>
                                <?php endif ?>

                            </div><!-- .headings -->
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
                <h5 class="sr-only" role="heading" aria-level="1"><?php echo tpl_getLang('nav-area-head') ?></h5>
            </div><!-- .nav-area-head -->
            <?php if ($showSidebar): ?>

            <div class="tools">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="sidebarheader main-sidebar">
                                <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* Include Hook: sidebarheader.html */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                                tpl_includeFile('sidebarheader.html') ?>

                            </div><!-- .sidebarheader -->

                            <div class="search main-sidebar">

                                <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* search form */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                                include('tpl/main-sidebar-search.php'); ?>

                            </div><!-- .search -->

                            <div id="dokuwiki__aside" class="menu main-sidebar">
                                <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* main menu */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                                include('tpl/nav-main.php');
                                ?>

                            </div><!-- .menu -->

                            <div class="site-tools main-sidebar">
                                <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* site tools */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                                include('tpl/nav-sitetools.php'); ?>

                            </div><!-- .site-tools -->


                            <div class="sidebarfooter main-sidebar">
                                <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* Include Hook: sidebarfooter.html */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                                tpl_includeFile('sidebarfooter.html') ?>

                            </div><!-- .sidebarheader -->

                        </div><!-- .col -->
                    </div><!-- .row -->
                </div><!-- .container -->
            </div><!-- .tools -->
            <?php endif ?>


            <div class="top-header">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">

                            <?php


    /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
    /* User Tools */
    /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                            include('tpl/nav-usertools.php');

                            ?>

                            <?php
    /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
    /* MagicMatcher */
    /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                            include('tpl/nav-magicmatcher.php');


    /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
    /* Include Hook: header.html */
    /* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                            tpl_includeFile('header.html');
                            ?>

                        </div><!-- .col -->
                    </div><!-- .row -->
                </div><!-- .container -->
            </div><!-- /top-header -->

        <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">

                            <?php tpl_flush(); /* flush the output buffer */


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* Include Hook: pageheader.html */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                            tpl_includeFile('pageheader.html')
                            ?>

                            <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* breadcrumb */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                            include('tpl/nav-breadcrumb.php'); ?>

                            <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* page quality / page tasks */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                            include('tpl/nav-page-quality-tasks.php'); ?>

                            <div id="dokuwiki__content" class="page main-content">


                                <?php


/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
/* wikipage start / main  content */
/* + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + + */
                                tpl_content() /* the main content */ ?>
+
                            </div><!-- .main-content -->

                        </div><!-- .col -->
                    </div><!-- .row -->
                </div><!-- .container -->








                <?php tpl_flush() ?>
                <?php tpl_includeFile('pagefooter.html') ?>
            </div></div><!-- /content -->

            <div class="clearer"></div>
            <hr class="a11y" />

            <!-- PAGE ACTIONS -->
            <?php if ($showTools): ?>
                <div id="dokuwiki__pagetools">

                    <?php include('tpl/nav-status.php');?>

                    <h3 class="a11y"><?php echo $lang['page_tools'] ?></h3>
                    <ul>
                        <?php tpl_toolsevent('pagetools', array(
                            'edit'      => tpl_action('edit', 1, 'li', 1),
                            'discussion'=> _tpl_action('discussion', 1, 'li', 1),
                            'revisions' => tpl_action('revisions', 1, 'li', 1),
                            'backlink'  => tpl_action('backlink', 1, 'li', 1),
                            'subscribe' => tpl_action('subscribe', 1, 'li', 1),
                            'revert'    => tpl_action('revert', 1, 'li', 1),
                            'top'       => tpl_action('top', 1, 'li', 1),
                        )); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div><!-- /wrapper -->

        <!-- ********** FOOTER ********** -->
        <div id="dokuwiki__footer"><div class="pad">
            <div class="doc"><?php tpl_pageinfo() /* 'Last modified' etc */ ?></div>
            <?php tpl_license('button') /* content license, parameters: img=*badge|button|0, imgonly=*0|1, return=*0|1 */ ?>
        </div></div><!-- /footer -->

        <?php tpl_includeFile('footer.html') ?>
    </div><!-- .dokuwiki__site -->

    <div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>

</body>
</html>
