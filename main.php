<?php

/**
 * DokuWiki sprintDoc Template
 *
 * @link     FIXME
 * @author   Jana Deutschlaender <deutschlaender@cosmocode.de>
 * @license  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

use dokuwiki\template\sprintdoc\Template;
Template::getInstance();

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
<!DOCTYPE html>
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

<title><?php tpl_pagetitle() ?> [<?php echo strip_tags($conf['title']) ?>]</title>

<script type="text/javascript">(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>

<?php
    include('tpl/favicon_tiles.php');
?>
<?php tpl_includeFile('meta.html') ?>
</head>
<?php


/* #dokuwiki__top used as anchor for "back to top" button/link links */
$classWideContent = (Template::getInstance())->fullWidthClass();
?>
<body id="dokuwiki__top" class="<?php echo ($ACT) ? 'do-'.$ACT : 'do-none'; ?> <?php echo $classWideContent; ?><?php echo ($showSidebar) ? 'showSidebar' : ''; ?> <?php echo tpl_getConf('header_layout'); ?>">

<div id="dokuwiki__site" class="<?php echo tpl_classes(); ?>">
    <?php include('tpl/nav-direct.php') ?>


    <div class="page-wrapper <?php echo ($showSidebar) ? 'hasSidebar' : ''; ?>">
        <?php
            tpl_includeFile('header.html');
            /** @var \helper_plugin_magicmatcher_context $mm */
            $mm = plugin_load('helper', 'magicmatcher_context');
            $headerClass = ""; /* for additionial class in #dokuwiki__header */
            $navClass = "";    /* for additionial class in #dokuwiki__usertools (header.html) */

            if($mm){
                $matcher = $mm->getIssueContextBar();
                if($matcher !== ""){
                    $headerClass = "has-magicmatcher";
                    $navClass = "has-bar";
                }
            }
        ?>

        <div id="dokuwiki__header" class="header <?php echo $headerClass; ?> no-print">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="claim main-sidebar">
                            <?php if(!tpl_getConf('closedwiki') || $INPUT->server->has('REMOTE_USER')) { ?>
                                <div class="menu-togglelink mobile-only">
                                    <a href="#">
                                        <span class="sr-out"><?php echo tpl_getLang('a11y_sidebartoggle'); ?></span>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php include('tpl/main-sidebar-logo.php'); ?>

                            <div class="main-title">
                                <?php if ($conf['title']): ?>
                                    <p class="title mobile-only"><?php echo $conf['title'] ?></p>
                                <?php endif ?>
                            </div><!-- .main-title -->

                            <div class="menu-tool-select">
                                <h5 class="sr-only" role="heading" aria-level="2"><?php echo tpl_getLang('head_menu_tool-select') ?></h5>
                                <?php
                                if (file_exists(DOKU_INC . 'inc/Menu/MobileMenu.php')) {
                                    echo (new \dokuwiki\Menu\MobileMenu())->getDropdown();
                                } else {
                                    //Pre-Greebo Backwards compatibility
                                    tpl_actiondropdown($lang['tools'], "test");
                                }
                                ?>
                            </div><!-- .menu-tool-select -->
                        </div><!-- .headings -->
                    </div><!-- .col -->


                    <div class="col-xs-12">
                        <div class="main-title desktop-only">
                            <?php if ($conf['title']): ?>
                                <p class="title"><?php echo $conf['title'] ?></p>
                            <?php endif ?>
                            <?php if ($conf['tagline']): ?>
                                <p class="claim"><?php echo $conf['tagline'] ?></p>
                            <?php endif ?>
                        </div><!-- .main-title -->
                    </div><!-- .col -->

                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .header -->

        <div class="sr-only nav-area-head">
            <h5 class="sr-only" role="heading" aria-level="1"><?php echo tpl_getLang('nav-area-head') ?></h5>
        </div><!-- .nav-area-head -->

        <?php if(!tpl_getConf('closedwiki') || $INPUT->server->has('REMOTE_USER')) { ?>
            <div class="tools">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="search main-sidebar">
                            <?php include('tpl/main-sidebar-search.php'); ?>
                        </div><!-- .search -->

                        <div class="sidebarheader main-sidebar">
                            <?php tpl_includeFile('sidebarheader.html') ?>
                        </div><!-- .sidebarheader -->

                        <div id="dokuwiki__aside">

                            <?php
                            echo Template::getInstance()->getInclude(
                                'sidebarheader',
                                '<div class="sidebarheader">',
                                '<div class="clearer"></div></div>'
                            );
                            ?>

                            <?php include('tpl/main-sidebar-nav.php'); ?>

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
        <?php } // closed wiki check?>

        <div class="top-header">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">

                        <?php
                            include('tpl/nav-usertools-buttons.php');
                            if($mm && $matcher !== ""){
                                include('tpl/nav-magicmatcher.php');
                            }
                        ?>

                    </div><!-- .col -->
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- /top-header -->


        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <?php tpl_flush(); /* flush the output buffer */?>

                        <div class="breadcrumbs" data-do="<?php echo $ACT?>">

                            <?php if(!tpl_getConf('closedwiki') || $INPUT->server->has('REMOTE_USER')) { ?>
                            <div class="togglelink page_main-content">
                                <a id="spr__toggle-content" href="#"><span class="sr-out"><?php echo tpl_getLang('a11y_sidebartoggle')?></span></a>
                            </div>
                            <?php } ?>

                            <h6 class="sr-only" role="heading" aria-level="2"><?php echo  tpl_getLang('head_menu_status')  ?></h6>

                            <?php include('tpl/nav-page-attributes.php'); ?>

                            <?php include('tpl/nav-breadcrumb.php'); ?>

                            <h6 class="sr-only" role="heading" aria-level="2"><?php echo  $lang['page_tools']  ?></h6>

                            <?php
                                if(!tpl_getConf('closedwiki') || $INPUT->server->has('REMOTE_USER')) {
                                    include('tpl/nav-page-tools.php');
                                }
                            ?>

                        </div>

                        <div id="dokuwiki__content" class="page main-content">
                            <div id="spr__meta-box">
                                <h6 class="sr-only" role="heading" aria-level="2"><?php echo  tpl_getLang('head_meta_box')  ?></h6>
                                <?php include('tpl/nav-meta-box.php'); ?>
                            </div>

                            <div class="qc-output"></div>
                            <?php
                            /** @var action_plugin_highlightparent $highlightParent */
                            $highlightParent = plugin_load('action', 'highlightparent');
                            if ($highlightParent) {
                                echo $highlightParent->tpl();
                            }
                            ?>
                            <?php
                            /** @var helper_plugin_translation $translation */
                            $translation = plugin_load('helper','translation');
                            if ($translation) {
                                echo $translation->showTranslations();
                            }
                            ?>
                            <div class="page-content">
                                <div class="msg-area"><?php html_msgarea();/*msg('Information.', 0);msg('Success', 1);msg('Notification', 2);msg('Fehler', -1);*/ ?></div>
                                <div class="clearer"></div>
                            </div>
                            <?php
                                tpl_includeFile('pageheader.html');
                                tpl_content(false); /* the main content */
                            ?>
                            <div class="clearer"></div>
                            <?php
                                tpl_includeFile('pagefooter.html');
                                if($ACT == 'show') echo Template::getInstance()->getInclude(
                                    'footer',
                                    '<div class="wikipagefooter"><hr>',
                                    '<div class="clearer"></div></div>'
                                );
                            ?>
                        </div><!-- .main-content -->


                        <div class="page-footer">
                            <?php
                                tpl_pageinfo()
                            ?>
                        </div>

                    </div><!-- .col -->
                </div><!-- .row -->
            </div><!-- .container -->


            <?php
                tpl_flush()
            ?>
        </div><!-- /content -->


        <div class="clearer"></div>

    </div><!-- /wrapper -->



<!-- ********** FOOTER ********** -->

    <div id="dokuwiki__footer">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">

                    <div class="main-footer">
                        <?php include 'tpl/main-footer.php'; ?>
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
