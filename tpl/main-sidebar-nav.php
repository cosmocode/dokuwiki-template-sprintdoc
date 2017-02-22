<nav class="nav-main">
    <?php /* main navigation, loaded from sidebar, fixed up by javascript */
    tpl_include_page($conf['sidebar'], 1, 1);
    ?>
</nav>

<nav class="nav-sitetools">
    <a class="nav" role="heading" aria-level="2">
        <span class="ico"><?php echo inlineSVG(__DIR__ . '/../img/sitemap.svg') ?></span>
        <span class="lbl"><?php echo $lang['site_tools']; ?></span>
    </a>
    <div class="nav-panel level1">
        <ul>
            <?php
            tpl_toolsevent(
                'sitetools',
                array(
                    'recent' => tpl_action('recent', 1, 'li', 1),
                    'media' => tpl_action('media', 1, 'li', 1),
                    'index' => tpl_action('index', 1, 'li', 1),
                )
            );
            ?>
        </ul>
    </div>
</nav>


<nav class="nav-usermenu">
    <a class="nav" role="heading" aria-level="2">
        <span class="ico"><?php echo inlineSVG(__DIR__ . '/../img/account-settings.svg') ?></span>
        <span class="lbl"><?php echo $lang['user_tools']; ?></span>
    </>
    <div class="nav-panel level1">
        <ul>
            <?php /* dokuwiki user tools */
            tpl_toolsevent(
                'usertools',
                array(
                    'login' => tpl_action('login', 1, 'li', 1),
                    'profile' => tpl_action('profile', 1, 'li', 1),
                    'admin' => tpl_action('admin', 1, 'li', 1),
                    'register' => tpl_action('register', 1, 'li', 1),
                )
            );
            ?>
        </ul>
    </div>
</nav>


<?php if($conf['breadcrumbs']): ?>
    <a class="nav" role="heading" aria-level="2">
        <span class="ico"><?php echo inlineSVG(__DIR__ . '/../img/apple-safari.svg') ?></span>
        <span class="lbl"><?php echo tpl_getLang('head_menu_trace'); ?></span>
    </a>
    <div class="nav-panel level1">
        <ul>
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
<?php endif ?>
