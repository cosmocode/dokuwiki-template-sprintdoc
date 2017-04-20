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
                    $tasks = $doplugin->loadTasks(array('status' => array('undone'),'user'   => $_SERVER['REMOTE_USER']));
                    $num = count($tasks);
                    if ($num === 0) {
                        $title = tpl_getLang('tasks_user_none');
                    } else {
                        $title = sprintf(tpl_getLang('tasks_user_intime'), $num);
                    }

                    $doInner = "<span class=\"prefix\">".tpl_getLang('prefix_tasks_user')." </span><span class=\"num\">".count($tasks)."</span>";

                    $userpage = $doplugin->getConf('userpage');
                    if ($userpage && $_SERVER['REMOTE_USER'] && $num > 0) {
                        $linktarget = sprintf($userpage, $_SERVER['REMOTE_USER']) . ':' . 'dashboard';
                        $linktarget = str_replace('::', ':', $linktarget);
                        echo '<li class="user-task" title="'.$title.'"><a href="'.wl($linktarget).'">'.$doInner.'</a></li>';
                    } else {
                        echo '<li class="user-task" title="'.$title.'"><strong>'.$doInner.'</strong></li>';
                    }
                } ?>

            </ul>
        </nav><!-- #dokuwiki__usertools -->
    <?php endif ?>

