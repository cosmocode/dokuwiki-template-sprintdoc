<?php
    if (!defined('DOKU_INC')) die();
?>
    <nav class="nav-main">
        <h6 class="sr-only" role="heading" aria-level="2"><?php echo $lang['site_tools']; ?></h6>
        <?php tpl_include_page($conf['sidebar'], 1, 1) /* includes the nearest sidebar page */ ?>
    </nav>
