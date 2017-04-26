<?php
    if (!defined('DOKU_INC')) die();

    if ($conf['useacl']): ?>

        <nav id="dokuwiki__usertools" class="nav-usertools <?php echo $navClass?>">
            <h6 class="sr-only" role="heading" aria-level="2"><?php echo $lang['user_tools']; ?></h6>
            <ul>
                <li class="log"><?php tpl_actionlink('login'); ?></li>

                <?php
                if (!empty($_SERVER['REMOTE_USER'])) {
                    echo '<li class="user"><span class="sr-only">'.$lang['loggedinas'].' </span>'.userlink().'</li>';
                }?>

                <?php /* dokuwiki user tools */
                tpl_toolsevent('usertools', array(
                    'admin'     => tpl_action('admin', 1, 'li', 1),
                    'register'  => tpl_action('register', 1, 'li', 1),
                )); ?>

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

