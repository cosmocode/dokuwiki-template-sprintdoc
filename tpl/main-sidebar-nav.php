<nav class="nav-main">
    <?php /* main navigation, loaded from sidebar, fixed up by javascript */
    tpl_include_page($conf['sidebar'], 1, 1);
    ?>
</nav>

<nav class="nav-sitetools">
    <div class="nav"><a href="#sidebar-site-tools" role="heading" aria-level="2">
        <span class="ico"><?php echo inlineSVG(__DIR__ . '/../img/sitemap.svg') ?></span>
        <span class="lbl"><?php echo $lang['site_tools']; ?></span>
    </a></div>
    <div class="nav-panel level1">
        <ul id="sidebar-site-tools" class="toollist">
            <?php
            if (file_exists(DOKU_INC . 'inc/Menu/SiteMenu.php')) {
                echo (new \dokuwiki\Menu\SiteMenu())->getListItems('toollist__listitem ');
            } else {
                //Pre-Greebo Backwards compatibility
                tpl_toolsevent(
                    'sitetools',
                    array(
                        'recent' => tpl_action('recent', 1, 'li', 1),
                        'media' => tpl_action('media', 1, 'li', 1),
                        'index' => tpl_action('index', 1, 'li', 1),
                    )
                );
            }
            ?>
        </ul>
    </div>
</nav>


<nav class="nav-usermenu">
    <div class="nav"><a href="#sidebar-user-tools" role="heading" aria-level="2">
        <span class="ico"><?php echo inlineSVG(__DIR__ . '/../img/account-settings.svg') ?></span>
        <span class="lbl"><?php echo $lang['user_tools']; ?></span>
    </a></div>
    <div class="nav-panel level1">
        <ul id="sidebar-user-tools" class="toollist">
            <?php /* dokuwiki user tools */
            if (file_exists(DOKU_INC . 'inc/Menu/UserMenu.php')) {
                echo (new \dokuwiki\Menu\UserMenu())->getListItems('toollist__listitem ');
            } else {
                //Pre-Greebo Backwards compatibility
                tpl_toolsevent(
                    'usertools',
                    array(
                        'login' => tpl_action('login', 1, 'li', 1),
                        'profile' => tpl_action('profile', 1, 'li', 1),
                        'admin' => tpl_action('admin', 1, 'li', 1),
                        'register' => tpl_action('register', 1, 'li', 1),
                    )
                );
            }
            ?>
        </ul>
    </div>
</nav>

<?php
/** @var helper_plugin_starred $plugin_starred */
$plugin_starred = plugin_load('helper', 'starred');
$stars = array();
if($plugin_starred) $stars = $plugin_starred->loadStars();
if($stars):
    ?>
    <nav class="nav-starred">
        <div class="nav"><a href="#sidebar-menu-starred" role="heading" aria-level="2">
            <span class="ico"><?php echo inlineSVG(__DIR__ . '/../img/star-circle.svg') ?></span>
            <span class="lbl"><?php echo tpl_getLang('head_menu_starred'); ?></span>
        </a></div>
        <div class="nav-panel level1 plugin_starred">
            <ul id="sidebar-menu-starred">
                <?php
                foreach($stars as $pid => $time) {
                    echo '<li>';
                    echo $plugin_starred->starHtml($ID, $pid);
                    echo '&nbsp;';
                    echo html_wikilink(":$pid");
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    </nav>
<?php endif; ?>



<?php if($conf['breadcrumbs']): ?>
    <nav class="nav-trace">
        <div class="nav"><a href="#sidebar-menu_trace" role="heading" aria-level="2">
            <span class="ico"><?php echo inlineSVG(__DIR__ . '/../img/apple-safari.svg') ?></span>
            <span class="lbl"><?php echo tpl_getLang('head_menu_trace'); ?></span>
        </a></div>
        <div class="nav-panel level1">
            <ul id="sidebar-menu_trace">
                <?php /* trace breadcrumbs as list */
                // FIXME move to helper class
                $crumbs = breadcrumbs();
                $crumbs = array_reverse($crumbs, true);
                foreach($crumbs as $id => $name) {
                    echo '<li>';
                    tpl_link(wl($id), hsc($name), 'title="' . $id . '"');
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    </nav>
<?php endif ?>
