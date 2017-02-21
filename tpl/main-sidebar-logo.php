<?php
    if (!defined('DOKU_INC')) die();

    echo '<div class="menu-togglelink mobile-only"><a href=\'#\'>MOB</a></div>';
    echo '<div class="logo">';

    \dokuwiki\template\sprintdoc\Template::getInstance()->mainLogo();

    echo "<hr class=\"structure\" /></div>";
