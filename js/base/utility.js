/**
 * @file utility funcs and polyfills
 *
 */
// + + + + + + + + + + + + + + + + + + + + + + + + + + + +
// object literal with funcs for jquery plug-ins
// + + + + + + + + + + + + + + + + + + + + + + + + + + + +
    var utility = {};

// + + + + + + + + + + + + + + + + + + + + + + + + + + + +
// js trim func for ie
// + + + + + + + + + + + + + + + + + + + + + + + + + + + +
if(typeof String.prototype.trim !== 'function') {
    String.prototype.trim = function() {
        return this.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
    };
}

/**
 * custom event handler ‘show’/’hide’ events for using .on()
 */
(function ($) {
    $.each(['show', 'hide'], function (i, e) {
        var el = $.fn[e];
        $.fn[e] = function () {
            this.trigger(e);
            return el.apply(this, arguments);
        };
    });
})(jQuery);
