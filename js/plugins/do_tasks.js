( function( $, spc ) {

    var togglePageAnalysis = function(){
            var $this = $('.page-attributes').find('.plugin__qc');
            try{
                var $link = $this.find('#plugin__qc__link'),
                    $container = $this.find('#plugin__qc__wrapper');
                if($container.length < 1){
                    $this.remove();
                }else{
                    $container.attr('aria-hidden','true');
                    var $icon = $container.find('#plugin__qc__icon');
                    $container.find('#plugin__qc__out').removeAttr('style');
                    $link.on( 'click', function(e){
                        e.preventDefault();
                        $icon.trigger('click');
                        var oldState = ($link.attr('aria-expanded')=== "true" );
                        $container.attr('aria-hidden',oldState);
                        $(this).attr('aria-expanded',!oldState);

                    });
                }

            }catch(err){
                $this.remove();
            }
    };

    $(function(){
        togglePageAnalysis();
    });

} )( jQuery, spc );




