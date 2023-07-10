<?php

use dokuwiki\Menu\Item\AbstractItem;
use dokuwiki\Menu\Item\Admin;
use dokuwiki\Menu\Item\Login;
use dokuwiki\Menu\Item\Register;

if (!defined('DOKU_INC')) die();

if ($conf['useacl']): ?>

    <nav id="dokuwiki__usertools" class="nav-usertools <?php echo $navClass ?>">
        <h6 class="sr-only" role="heading" aria-level="2"><?php echo $lang['user_tools']; ?></h6>
        <ul>
            <?php
            try {
                $item = new Login();
                if ($item->visibleInContext(AbstractItem::CTX_DESKTOP))
                    echo '<li class="log">' . $item->asHtmlLink() . '</li>';
            } catch (RuntimeException $ignored) {
                // item not available
            }

            if (!empty($_SERVER['REMOTE_USER'])) {
                echo '<li class="user"><span class="sr-only">' . $lang['loggedinas'] . ' </span>' . userlink() . '</li>';
            }

            try {
                $item = new Admin();
                if ($item->visibleInContext(AbstractItem::CTX_DESKTOP)) {
                    echo '<li class="admin">' . $item->asHtmlLink() . '</li>';
                }
            } catch (RuntimeException $ignored) {
                // item not available
            }

            try {
                $item = new Register();
                if ($item->visibleInContext(AbstractItem::CTX_DESKTOP)) {
                    echo '<li class="register">' . $item->asHtmlLink() . '</li>';
                }
            } catch (RuntimeException $ignored) {
                // item not available
            }

            /** @var helper_plugin_do $doplugin */
            $doplugin = plugin_load('helper', 'do');
            if ($doplugin !== null && isset($_SERVER['REMOTE_USER'])) {
                $icon = $doplugin->tpl_getUserTasksIconHTML();
                if ($icon) {
                    echo '<li class="user-task">' . $icon . '</li>';
                }
            }
            ?>

        </ul>
    </nav><!-- #dokuwiki__usertools -->
<?php endif ?>

