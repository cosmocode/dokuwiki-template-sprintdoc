<?php
    if (!defined('DOKU_INC')) die();

    if ($conf['useacl'] && $showTools): ?>

                            <nav class="nav-usermenu <?php echo $navClass?>">
                                <h6 class="sr-only" role="heading" aria-level="2"><?php echo $lang['user_tools']; ?></h6>
                                <ul>
                                    <li class="log"><?php tpl_actionlink('login'); ?></li>
                                    <?php if($_SERVER['REMOTE_USER']){
                                        echo '<a class="profile" href="'.wl(tpl_getConf('user_ns').$_SERVER['REMOTE_USER'].':') . '">'.hsc($USERINFO['name']).'</a>';
                                    }?>

                                    <?php /* dokuwiki user tools */
                                    tpl_toolsevent('usertools', array(
                                        'admin'     => tpl_action('admin', 1, 'li', 1),
                                        'register'  => tpl_action('register', 1, 'li', 1),
                                    )); ?>

                                </ul>
                            </nav><!-- #dokuwiki__usertools -->
    <?php endif ?>

