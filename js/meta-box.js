jQuery(function () {
    const $metaBox = jQuery('#spr__meta-box');
    if (!$metaBox.length) return;

    /**
     * Register the click handler for the tabs
     *
     * Tabs can be added dynamically later on and this handler will still
     * provide the open/close functionality
     */
    $metaBox.on('click', '.meta-tabs a', function (e) {
        e.preventDefault();
        const $tab = jQuery(this);

        // disable all existing tabs
        $metaBox.find('.meta-tabs li')
            .removeClass('active')
            .find('a')
            .attr('aria-expanded', false);
        $metaBox.find('.meta-content .tab-pane')
            .removeClass('active')
            .attr('aria-hidden', false);

        // enable current tab
        $tab
            .attr('aria-expanded', true)
            .closest('li')
            .addClass('active');
        $metaBox.find($tab.attr('href'))
            .addClass('active')
            .attr('aria-hidden', false);

    });




});
