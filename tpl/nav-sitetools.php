<?php
    if (!defined('DOKU_INC')) die();

    if ($showSidebar): ?>

                                <nav id="dokuwiki__sitetools" class="nav-sitetools">
                                    <h6 class="sr-only" role="heading" aria-level="2"><?php echo $lang['site_tools']; ?></h6>
                                    <ul><?php tpl_toolsevent('sitetools', array(
                                                'recent'    => tpl_action('recent', 1, 'li', 1),
                                                'media'     => tpl_action('media', 1, 'li', 1),
                                                'index'     => tpl_action('index', 1, 'li', 1),
                                            )); ?></ul>
                                </nav>
    <?php endif ?>
