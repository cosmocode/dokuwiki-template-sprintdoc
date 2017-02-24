/**
 * Sets up the breadcrumb behaviour (adds do / ACT status information)
 */
jQuery(function () {
    const $breadcrumb = jQuery('.breadcrumbs');
    if (!$breadcrumb.length) return;

    /**
     * add ACT status to breadcrumb (if not show)
     *
     */
    const mode = $breadcrumb.attr('data-do');
    if(mode && mode.indexOf('show') !== 0){
        var markup = '<bdi lang="en"><span class="curid"> : <strong>' + mode + '</strong></span></bdi>';
        $breadcrumb.find('p').append(markup);
    }

});
