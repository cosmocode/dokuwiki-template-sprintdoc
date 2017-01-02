<?php
    if (!defined('DOKU_INC')) die();

    echo '<h6 class="sr-only" role="heading" aria-level="2">'.tpl_getLang('head_quick_search').'</h6>';

    tpl_searchform();
