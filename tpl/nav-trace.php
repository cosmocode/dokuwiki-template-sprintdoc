<?php
    if (!defined('DOKU_INC')) die();

    if ($conf['useacl'] && $showTools): ?>

                            <nav class="nav-trace <?php echo $navClass?>">
                                <h6 class="sr-only" role="heading" aria-level="2"><?php echo tpl_getLang('head_menu_trace'); ?></h6>
                                <div class="trace"><p><?php tpl_breadcrumbs(); ?></p></div>
                            </nav><!-- #dokuwiki__usertools -->
    <?php endif ?>

