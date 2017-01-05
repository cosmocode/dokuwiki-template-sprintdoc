( function( $, spc ) {

    var mainMenu = function(){
        var $menu = $('.nav-main').find('> ul');

        try{
            if($menu.length > 0){
                var $toggler = $menu.find('> li.level1 > .li'),
                    $submenu = $menu.find('> li.level1 > ul');
                if($toggler.length > 0 && $submenu.length > 0){
                    $toggler.addClass('closed');
                    $toggler.wrapInner('<a href="#toggleMenu" class="toggler"></a>');
                    $toggler.each(function( index ) {
                        $(this).on( "click", function(e) {
                            e.preventDefault();
                            var $this = $(this);
                            $this.toggleClass('closed');
                            $this.toggleClass('opened');
                            if($this.hasClass('opened')){
                                var $foc = $this.closest('li.level1').find('li.level2:first-child').find('a:first-child');
                                if($foc.length > 0){
                                    $foc.focus();
                                }
                            }
                        });
                    });

                    //FIXME: store current nav state with local storage
                }


            }

        }catch(err){

        }
    };

    $(function(){
        mainMenu();
    });

} )( jQuery, spc );

