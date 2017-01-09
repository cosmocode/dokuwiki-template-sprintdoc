(function ($, spc) {

    var toggleTabs = function () {

        var $metaBox = $('#meta-box'),
            $tabLinks = $metaBox.find('.meta-tabs').find('a'),
            $tabPanels = $metaBox.find('.meta-content').find('.tab-pane');

            try {
                $tabLinks.each(function () {
                    $(this).on("click", function (e) {
                        e.preventDefault();
                        var $link = $(this),
                            $panel = $($link.attr('href'));

                        //reset
                        resetTabs();

                        //current state
                        $link.addClass('active').attr('aria-expanded','true');
                        $panel.addClass('active').attr('aria-hidden','false');
                    });
                });


            } catch (err) {
                alert('err');
            }
        },
        resetTabs = function($tabLinks,$tabPanels){
            $tabLinks.closest('li').removeClass('active');
            $tabLinks.attr('aria-expanded','false');
            $tabPanels.removeClass('active').attr('aria-hidden','true');
        };

    $(function () {
        toggleTabs();
    });

})(jQuery, spc);

