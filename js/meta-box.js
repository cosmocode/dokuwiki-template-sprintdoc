(function ($, spc, $lang) {

    var toggleTabs = function () {

        var $metaBox = $('#meta-box'),
            $tabLinks = $metaBox.find('.meta-tabs').find('a'),
            $tabPanels = $metaBox.find('.meta-content').find('.tab-pane');

            try {
                $tabLinks.each(function () {
                    $(this).on("click", function (e) {
                        e.preventDefault();
                        var $link = $(this),
                            $li = $link.closest('li'),
                            $panel = $($link.attr('href'));

                        /* close panel */
                        if($li.hasClass('active')){
                            //reset
                            resetTabs($tabLinks,$tabPanels);

                        /* close panel */
                        }else{
                            //reset
                            resetTabs($tabLinks,$tabPanels);
                            //current state
                            $li.addClass('active');
                            $link.attr('aria-expanded','true');
                            $panel.addClass('active').attr('aria-hidden','false');
                        }

                    });
                });


            } catch (err) {
                //alert('err');
            }
        },
        resetTabs = function($tabLinks,$tabPanels){
            $tabLinks.closest('li').removeClass('active');
            $tabLinks.attr('aria-expanded','false');
            $tabPanels.removeClass('active').attr('aria-hidden','true');
        },
        findJiraTickets = function(){
            var $tickets = $('#dokuwiki__content').find('a.jiralink');
            if($tickets.length >0){
                var $panel = $('#tab-jira'),
                    $num = $('a[href="#tab-jira"]').find('.num');

                if($panel.length > 0 && $num.length > 0){
                    $num.empty().append($tickets.length);
                    $panel.find('> div').empty().append('<ul></ul>');
                    var $ul = $panel.find('ul');
                    $tickets.each(function (){
                        var $ticket = $(this).clone();
                        $ul.prepend('<li></li>');
                        $ul.find('li:first-child').append($ticket);
                    });
                }
            }
        },
        findSitemap = function(){
            var $panel =  $('#tab-toc'),
                $toc = $panel.find('ul'),
                $num = $('a[href="#tab-toc"]').find('.num');
            if($toc.length == 0){
                $panel.append('<div><p>'+$_LANG['meta_box_sitemap_none']+'</p></div>');
            }else{
                $num.empty().append('1');
            }
        };

    $(function () {
        toggleTabs();
        findJiraTickets();
        findSitemap();
    });

})(jQuery, spc, $_LANG);

