<nav class="nav-main">
    <?php /* main navigation, loaded from sidebar, fixed up by javascript */
    tpl_include_page($conf['sidebar'], 1, 1);
    ?>
</nav>


<nav class="nav-sitetools">
    <h6 role="heading" aria-level="2">
        <span><?php echo inlineSVG(__DIR__ . '/../img/sitemap.svg')?></span>
        <?php echo $lang['site_tools']; ?>
    </h6>
    <div class="nav-panel">
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
    <h6 role="heading" aria-level="2">
        <span><?php echo inlineSVG(__DIR__ . '/../img/account-settings.svg')?></span>
        <?php echo $lang['user_tools']; ?></h6>
    <div class="nav-panel">
        <ul>
            <?php /* dokuwiki user tools */
            tpl_toolsevent(
                'usertools',
                array(
                    'login' => tpl_action('login', 1, 'li', 1),
                    'admin' => tpl_action('admin', 1, 'li', 1),
                    'register' => tpl_action('register', 1, 'li', 1),
                )
            );
            ?>
        </ul>
    </div>
</nav>


<?php if($conf['breadcrumbs']): ?>
    <nav class="nav-trace">
        <h6 role="heading" aria-level="2">
            <span><?php echo inlineSVG(__DIR__ . '/../img/apple-safari.svg')?></span>
            <?php echo tpl_getLang('head_menu_trace'); ?></h6>
        <div class="nav-panel">
            <ul>
                <?php /* trace breadcrumbs as list */
                // FIXME move to helper class
                $crumbs = breadcrumbs();
                $crumbs = array_reverse($crumbs, true);
                foreach($crumbs as $id => $name) {
                    echo '<li>';
                    tpl_link(wl($id), hsc($name), 'class="breadcrumbs" title="' . $id . '"');
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
    </nav>
<?php endif ?>
