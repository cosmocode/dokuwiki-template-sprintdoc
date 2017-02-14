/**
 * Initialize the sidebar to have a toggleable menu system with icon support
 */
jQuery(function () {
    const $nav = jQuery('#dokuwiki__aside').find('nav.nav-main');
    if (!$nav.length) return;

    const ELEMENT = 'h1,h2,h3,h4,h5'; // FIXME move to config
    const $elements = $nav.find(ELEMENT);
    $elements.each(function () {
        const $me = jQuery(this);

        // prepare text and the optional icon
        const data = $me.text().split('@', 2);
        const text = data[0].trim();
        const $icon = jQuery('<span>')
            .text(text.substr(0, 1).toUpperCase() + text.substr(1, 1).toLowerCase());
        if (data[1]) {
            const src = data[1].trim();
            $icon.load(DOKU_BASE + 'lib/tpl/sprintdoc/svg.php?svg=' + src + '&e=1'); // directly embed
        }

        // make the new toggler
        const $toggler = jQuery('<h6>')
                .addClass('navi-toggle')
                .text(text)
                .prepend($icon)
            ;

        // wrap all following sibling til the next element in a wrapper
        const $wrap = jQuery('<div>').addClass('navi-pane');
        const $sibs = $me.nextAll();
        for (let i = 0; i < $sibs.length; i++) {
            const $sib = jQuery($sibs[i]);
            if($sib.is(ELEMENT)) break;
            $sib.detach().appendTo($wrap);
        }
        $wrap.hide();
        $wrap.insertAfter($me);

        // replace element with toggler
        $me.replaceWith($toggler);

        // add toggling the wrapper
        $toggler.click(function () {
            $wrap.dw_toggle(undefined, function () {
                $me.toggleClass('open');
            });
        });

    });

});
