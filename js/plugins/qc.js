/**
 * Add custom QC functionality instead of using the plugin's mechanism
 *
 * @author Andreas Gohr <gohr@cosmocode.de>
 * @author Jana Deutschlaender <deutschlaender@cosmocode.de>
 */
jQuery(function () {
    var $panel = jQuery('div.qc-output').hide();

    // load summary
    jQuery('.page-attributes .plugin_qc a').load(
        DOKU_BASE + 'lib/exe/ajax.php',
        {
            call: 'plugin_qc_short',
            id: JSINFO['id']
        },
        function () {
            jQuery(this).find('span span').addClass('num');
        }
    ).click(function (e) {
        e.preventDefault();

        if ($panel.html() == '') {
            // load output
            $panel.load(
                DOKU_BASE + 'lib/exe/ajax.php',
                {
                    call: 'plugin_qc_long',
                    id: JSINFO['id']
                },
                function () {
                    $panel.dw_show();
                }
            );
        } else {
            $panel.dw_toggle();
        }
    });

});
