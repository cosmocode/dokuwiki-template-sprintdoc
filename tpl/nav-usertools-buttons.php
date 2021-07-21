<?php
    if (!defined('DOKU_INC')) die();

    if ($conf['useacl']): ?>

        <nav id="dokuwiki__usertools" class="nav-usertools <?php echo $navClass?>">
            <h6 class="sr-only" role="heading" aria-level="2"><?php echo $lang['user_tools']; ?></h6>
            <ul>
                <li class="log"><?php
                    try {
                        if (empty($_SERVER['REMOTE_USER'])) {
                            echo (new \dokuwiki\Menu\Item\Login())->asHtmlLink();
                        } else {
                            echo (new \dokuwiki\Menu\Item\Login())->asHtmlButton();
                        }
                    } catch (\RuntimeException $ignored) {
                        // item not available
                    }
                    ?>
                </li>

                <?php
                if (!empty($_SERVER['REMOTE_USER'])) {
                    echo '<li class="user"><span class="sr-only">'.$lang['loggedinas'].' </span>'.userlink().'</li>';
                }?>

                <?php /* dokuwiki user tools */
                try{
                    echo '<li class="admin">' . (new \dokuwiki\Menu\Item\Admin())->asHtmlLink() . '</li>';
                } catch(\RuntimeException $ignored) {
                    // item not available
                }
                try{
                    echo '<li class="register">' . (new \dokuwiki\Menu\Item\Register())->asHtmlLink() . '</li>';
                } catch(\RuntimeException $ignored) {
                    // item not available
                }
                ?>

                <?php /* tasks do Plug-In */
                /** @var \helper_plugin_do $doplugin */
                $doplugin = plugin_load('helper','do');
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

