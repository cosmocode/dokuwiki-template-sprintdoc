
/* DOKUWIKI:include js/base/helper.js */
/* DOKUWIKI:include js/base/spc.js */

( function( $, spc, lang ) {

    var setLang = function(){
        try{
            if(lang==="de"){
                /* DOKUWIKI:include lang/de/lang.js */
            } else if(lang==="en"){
                /* DOKUWIKI:include lang/en/lang.js */
            } else{
                /* default */
                /* DOKUWIKI:include lang/de/lang.js */
            }
        }catch(err){
        }
    };

    $(function(){
        setLang();
    });

} )( jQuery, spc, wikiLang );

/* DOKUWIKI:include js/plugins/do_tasks.js */

/* DOKUWIKI:include js/sidebar-menu.js */
/* DOKUWIKI:include js/meta-box.js */


