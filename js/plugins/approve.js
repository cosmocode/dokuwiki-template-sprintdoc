/**
 * Approve plugin banner
 */
jQuery(function () {
    const $icon = jQuery('span.plugin_approve-icon');
    const $metaBox = jQuery('#spr__meta-box');
    const $banner = jQuery('#plugin__approve');
    const title = $banner.find('strong').text();

    $icon.addClass($banner.attr('class'));
    $icon.attr('title', title);

    // anchor to the sprintdoc meta box
    $metaBox.after($banner);

    $icon.click(function (e) {
        e.preventDefault();
        $banner.dw_toggle();
    });

});
