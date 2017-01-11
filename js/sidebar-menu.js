( function( $, spc ) {

    var addToggleLink = function($elem){
            $elem.wrapInner('<a href="#toggleMenu" class="toggler"></a>');
        },

        setContentMinHeight = function(){
            var $sidebar = $('.page-wrapper').find('> .tools').find('.col-xs-12');

            if($sidebar.length == 1){
                var h = $sidebar.height(),
                    num = parseFloat(h);
                if(!isNaN(num)){
                    $('#dokuwiki__content').css('minHeight',num + 100);
                }

            }

        },
        setWideContent = function(){
            $('body').addClass('wide-content');
        },
        setDefaultContent= function(){
            $('body').removeClass('wide-content');
        },
        toggleState = function($toggler){
            $toggler.toggleClass('closed');
            $toggler.toggleClass('opened');
        },
        focusFirstSubLink = function($elem, is2nd){

            var $foc = (is2nd) ? $elem.find('a')[1] : $elem.find('a')[0];

            if($foc){
                $foc.focus();
            }
            return $foc;
        },
        focusLastSubLink = function($elem){

            var $foc = $elem.find('a:last-child'),
                height = $elem.find('p').scrollHeight;

            if($foc){
                $foc.focus();
            }
            $elem.scrollTop(height);
            return $foc;
        },

        mainMenu = function(){
            var $menu = $('.nav-main').find('> ul');

            try{
                if($menu.length > 0){
                    var $toggler = $menu.find('> li.level1 > .li'),
                        $submenu = $menu.find('> li.level1 > ul');

                    if($toggler.length > 0 && $submenu.length > 0){

                        $toggler.addClass('closed');
                        addToggleLink($toggler);
                        $toggler.each(function( index ) {
                            $(this).on( "click", function(e) {
                                e.preventDefault();
                                var $this = $(this);
                                toggleState($this);
                                if($this.hasClass('opened')){
                                    var $foc = focusFirstSubLink($this.closest('li.level1'), true);
                                }
                                if($('body').hasClass('wide-content')){
                                    setDefaultContent();
                                }

                            });
                        });


                        //FIXME: store current nav state with local storage
                    }


                }

            }catch(err){

            }
        },
        toggleMainContent = function(){
            var $toggler = $('.togglelink.page_main-content').find('a');
            $toggler.on("click", function (e) {
                e.preventDefault();
                var $link = $(this);

                if($('body').hasClass('wide-content')){
                    setDefaultContent();
                }else{
                    setWideContent();
                }

            });
        },
        sideMenu = function(){
            var $menus = $('.tools').find('.toggle-menu');


            try{
                $menus.each(function( ) {
                    var $menu = $(this);
                    if($menu.length > 0){
                        var $toggler = $menu.find('h6'),
                            $submenu = $menu.find('nav > ul, nav > div');
                        if($toggler.length > 0 && $submenu.length > 0) {

                            $toggler.addClass('closed');
                            addToggleLink($toggler);
                            $toggler.each(function (index) {
                                $(this).on("click", function (e) {
                                    e.preventDefault();
                                    var $this = $(this);
                                    toggleState($this);
                                    if ($this.hasClass('opened')) {
                                        var $elem = ($submenu.is('div')) ? focusLastSubLink($submenu): focusFirstSubLink($submenu,false);
                                    }
                                    if($('body').hasClass('wide-content')){
                                        setDefaultContent();
                                    }
                                });
                            });

                            //FIXME: store current nav state with local storage
                        }
                    }
                });


            }catch(err){
                //console.log('err');
            }
        };

    $(function(){
        mainMenu();
        sideMenu();
        toggleMainContent();
        setContentMinHeight();
    });

} )( jQuery, spc );

