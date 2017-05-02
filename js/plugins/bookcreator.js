/**
 * prevents Uncaught TypeError in detail template if bookcreator plug-in is installed
 *
 * @author Jana Deutschlaender <deutschlaender@cosmocode.de>
 *
 */
(function($) {


    var debugBookCreatorOnDetailTemplate = function(){

        var $detail = $('#dokuwiki__detail');
        if (!$detail.length) return;

        if(JSINFO.bookcreator === undefined) {
            JSINFO.bookcreator = {};
            JSINFO.bookcreator.areToolsVisible = false;
        }
    };

    $(function(){
        debugBookCreatorOnDetailTemplate();
    });


})(jQuery);
