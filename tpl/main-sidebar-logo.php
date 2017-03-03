<?php
if(!defined('DOKU_INC')) die();

echo '<div class="menu-togglelink mobile-only">';
echo '<a href="#">';
echo inlineSVG(__DIR__ . '/../img/menu.svg');
echo '<span class="sr-out">'.tpl_getLang('a11y_sidebartoggle').'</span>';
echo '</a>';
echo '</div>';

echo '<div class="logo">';
\dokuwiki\template\sprintdoc\Template::getInstance()->mainLogo();
echo '<hr class="structure" />';
echo '</div>';
