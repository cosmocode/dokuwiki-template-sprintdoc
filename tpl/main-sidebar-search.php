<?php
    if (!defined('DOKU_INC')) die();

    echo '<h6 class="sr-only" role="heading" aria-level="2">'.tpl_getLang('head_quick_search').'</h6>'; ?>
    <p class="toggleSearch"><a href="#qsearch__out"><span class="prefix">Zur Suche springen</span></a></p>
<?php tpl_searchform(); ?>
