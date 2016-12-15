<?php
    if (!defined('DOKU_INC')) die();
?>
<nav class="nav-status">
    <h6 class="sr-only" role="heading" aria-level="2"><?php echo $lang['site_status']; ?></h6>
    <?php tpl_include_page($conf['statusbar'], 1, 1) /* includes the nearest statusbar page */ ?>
</nav>
