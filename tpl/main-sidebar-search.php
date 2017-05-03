<?php
if(!defined('DOKU_INC')) die();

echo '<h6 class="sr-only" role="heading" aria-level="2">' . tpl_getLang('head_quick_search') . '</h6>';
echo '<p class="toggleSearch"><a href="#qsearch__out"><span class="prefix">' . tpl_getLang('jump_to_quicksearch') . '</span></a></p>';
tpl_searchform(true, false);
