<?php
    if (!defined('DOKU_INC')) die();
    if ($showSidebar):

    echo "<nav class=\"nav-main\">";
    echo "<h6 class=\"sr-only\" role=\"heading\" aria-level=\"2\">".tpl_getLang('head_menu_main')."</h6>";
    echo PHP_EOL;
    tpl_include_page($conf['sidebar'], 1, 1);
    echo PHP_EOL;
    echo "</nav>";

    endif ?>
