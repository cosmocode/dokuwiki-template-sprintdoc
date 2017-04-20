/**
 * Sets up the breadcrumb behaviour (adds do / ACT status information)
 * or adds tpl_getLang('image_detail') on detail template
 */
(function($) {


    var setBreadcrumbSuffix = function(){

        var $breadcrumb = $('.breadcrumbs');
        if (!$breadcrumb.length) return;


        /**
         * add ACT status to breadcrumb (if not show)
         * or tpl_getLang('image_detail') on detail.php
         */
        var mode = $breadcrumb.attr('data-do');
        if(mode && mode.indexOf('show') !== 0){
            var markup = '<bdi lang="en"><span class="curid"> : <strong>' + mode + '</strong></span></bdi>';
            $breadcrumb.find('p').append(markup);
        }
    };

    $(function(){
        setBreadcrumbSuffix();
    });


})(jQuery);
