<?php
    if (!defined('DOKU_INC')) die();

    if ($conf['useacl'] && $showTools): ?>

                        <nav id="dokuwiki__usertools" class="nav-usertools">
                            <h6 class="sr-only" role="heading" aria-level="2"><?php echo $lang['user_tools']; ?></h6>
                            <ul>
                                <?php
                                if (!empty($_SERVER['REMOTE_USER'])) {
                                    echo '<li class="user"><span class="sr-only">'.$lang['loggedinas'].' </span>'.userlink().'</li>';
                                }?>
                                <li class="log"><?php tpl_actionlink('login'); ?></li>

                                <?php tpl_toolsevent('usertools', array(
                                    'admin'     => tpl_action('admin', 1, 'li', 1),
                                    'userpage'  => _tpl_action('userpage', 1, 'li', 1),
                                    'profile'   => tpl_action('profile', 1, 'li', 1),
                                    'register'  => tpl_action('register', 1, 'li', 1),
                                )); ?>

                            </ul>
                        </nav><!-- #dokuwiki__usertools -->
<?php endif ?>
