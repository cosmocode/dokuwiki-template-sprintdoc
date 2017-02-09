<?php
    if (!defined('DOKU_INC')) die();

    echo '<div class="menu-togglelink mobile-only"><a href=\'#\'>MOB</a></div>';
    echo '<div class="logo">';

    /* homepage logo should not link to itself (BITV accessibility requirement) */
    if (strcmp(wl(), $_SERVER['REQUEST_URI']) === 0 ){
        echo '<img class="mobile-hide" src="'.ml(tpl_getConf('logo')).'" alt="'.tpl_getLang('adjunct_start_logo_text').$conf['title'].'" />';
        echo '<img class="mobile-only" src="'.tpl_getMediaFile(array(':wiki:favicon-32x32.png', 'images/fav/favicon-32x32.png')).'" alt="'.tpl_getLang('adjunct_start_logo_text').$conf['title'].'" />';

    } else{
        tpl_link( wl(),'<img class="mobile-hide" src="'.ml(tpl_getConf('logo')).'" alt="'.$conf['title'].tpl_getLang('adjunct_linked_logo_text').'" />','accesskey="h" title="[H]"' );
        tpl_link( wl(),'<img class="mobile-only" src="'.tpl_getMediaFile(array(':wiki:favicon-32x32.png', 'images/fav/favicon-32x32.png')).'" alt="'.$conf['title'].tpl_getLang('adjunct_linked_logo_text').'" />','accesskey="h" title="[H]"' );
    }
    echo "<hr class=\"structure\" /></div>";
