<?php
if(!defined('DOKU_INC')) die();

echo '<div class="logo">';
\dokuwiki\template\sprintdoc\Template::getInstance()->mainLogo();
echo '<hr class="structure" />';
echo '</div>';
