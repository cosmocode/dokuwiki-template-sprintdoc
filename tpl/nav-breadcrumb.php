<?php
    if (!defined('DOKU_INC')) die();

    if ($conf['breadcrumbs']): ?>

                                <div class="breadcrumbs">
                                    <h6 class="sr-only" role="heading" aria-level="2"><?php echo tpl_getLang('head_breadcrumb') ?></h6>
                                    <p><?php tpl_youarehere() ?></p>
                                </div>

    <?php endif ?>
