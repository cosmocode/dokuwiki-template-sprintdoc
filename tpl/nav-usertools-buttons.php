<?php
    if (!defined('DOKU_INC')) die();

    if ($conf['useacl'] && $showTools): ?>

                            <nav id="dokuwiki__usertools" class="nav-usertools <?php echo $navClass?>">
                                <h6 class="sr-only" role="heading" aria-level="2"><?php echo $lang['user_tools']; ?></h6>
                                <ul>
                                    <li class="log"><?php tpl_actionlink('login'); ?></li>
                                    <?php
                                    if (!empty($_SERVER['REMOTE_USER'])) {
                                        echo '<li class="user"><span class="sr-only">'.$lang['loggedinas'].' </span>'.userlink().'</li>';
                                    }?>

                                    <?php /* tasks do Plug-In */
                                    $doplugin = plugin_load('helper','do');
                                    if ($doplugin !== null && isset($_SERVER['REMOTE_USER'])) {
                                        $tasks = $doplugin->loadTasks(array('status' => array('undone'),'user'   => $_SERVER['REMOTE_USER']));
                                        $num = count($tasks);
                                        switch ($num) {
                                            case 0: $class = 'noopentasks'; break;
                                            case 1:  $class = 'opentask'; break;
                                            default:
                                                $class = 'opentask opentasks';
                                                break;
                                        }
                                        $linktarget = tpl_getConf('tasks_page');
                                        $doInner = "<span class=\"prefix\">".tpl_getLang('prefix_tasks_user')." </span><span class=\"num\">".count($tasks)."</span>";
                                        if($linktarget){
                                            if (substr($linktarget, 0, 1) !== ':') {
                                                $linktarget = tpl_getConf('user_ns'). $_SERVER['REMOTE_USER'] .':' . $linktarget;
                                            }
                                            if($num == 0){
                                                echo '<li class="user-task '.$class.'"><strong>'.$doInner.'</strong></li>';
                                            }else{
                                                echo '<li class="user-task '.$class.'"><a href="'.wl($linktarget).'">'.$doInner.'</a></li>';
                                            }
                                        }
                                        else{
                                            echo '<li class="user-task '.$class.'"><strong>'.$doInner.'</strong></li>';
                                        }
                                    } ?>

                                    <?php /* dokuwiki user tools */
                                    tpl_toolsevent('usertools', array(
                                        'admin'     => tpl_action('admin', 1, 'li', 1),
                                        'register'  => tpl_action('register', 1, 'li', 1),
                                    )); ?>

                                </ul>
                            </nav><!-- #dokuwiki__usertools -->
    <?php endif ?>

