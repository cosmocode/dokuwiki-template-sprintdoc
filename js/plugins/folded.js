/**
 * prevents Uncaught TypeError in detail template if folded plug-in is installed
 *
 * @author Jana Deutschlaender <deutschlaender@cosmocode.de>
 *
 */
(function($) {


    var debugFoldedOnDetailTemplate = function(){

        var $detail = $('#dokuwiki__detail');
        if (!$detail.length) return;

        if(JSINFO.plugin_folded === undefined) {
            JSINFO.plugin_folded = {};
            JSINFO.plugin_folded.reveal = '';
            JSINFO.plugin_folded.hide = '';
        }
    };

    $(function(){
        debugFoldedOnDetailTemplate();
    });


})(jQuery);
