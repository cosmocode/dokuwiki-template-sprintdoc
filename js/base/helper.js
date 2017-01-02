/**
 * @file helper funcs
 *
 */

// + + + + + + + + + + + + + + + + + + + + + + + + + + + +
// shuffle func for random values
// + + + + + + + + + + + + + + + + + + + + + + + + + + + +
Array.prototype.shuffle = function(){
    var tmp, rand;
    for(var i =0; i < this.length; i++){
        rand = Math.floor(Math.random() * this.length);
        tmp = this[i];
        this[i] = this[rand];
        this[rand] =tmp;
    }
};
// + + + + + + + + + + + + + + + + + + + + + + + + + + + +
// js trim func for ie
// + + + + + + + + + + + + + + + + + + + + + + + + + + + +
if(typeof String.prototype.trim !== 'function') {
    String.prototype.trim = function() {
        return this.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
    };
}
var linkTo_UnCryptMailto = function(s){
    location.href=decryptString(s,-2);
};
var decryptCharcode = function(n, start, end, offset) {
    n = n + offset;
    if (offset > 0 && n > end) {
        n = start + (n - end - 1);
    } else if (offset < 0 && n < start) {
        n = end - (start - n - 1);
    }
    return String.fromCharCode(n);
};
var decryptString = function(enc, offset) {
    var dec = '';
    var len = enc.length;
    for (var i = 0; i < len; i++) {
        var n = enc.charCodeAt(i);
        if (n >= 43 && n <= 58) {
            dec += decryptCharcode(n, 43, 58, offset);
        } else if (n >= 64 && n <= 90) {
            dec += decryptCharcode(n, 64, 90, offset);
        } else if (n >= 97 && n <= 122) {
            dec += decryptCharcode(n, 97, 122, offset);
        } else {
            dec += enc.charAt(i);
        }
    }
    return dec;
};
/**
 * simplify setting and getting state out of a node
 * $("#my_id").data("my_data_attr") equals $$("#my_id").my_data_attr and
 * $("#my_id").data("my_data_attr", "my_data_val") equals $$("#my_id").my_data_attr = my_data_val
 * you can also do
 * $$("#my_id").my_data_val = $$("#my_id").my_data_val + 1.
 */
var $$ = function(param) {
    var node = $(param)[0];
    var id = $.data(node);
    $.cache[id] = $.cache[id] || {};
    $.cache[id].node = node;
    return $.cache[id];
};
var alertFB = false;
if (typeof console === "undefined" || typeof console.log === "undefined") {
    console = {};
    if (alertFB) {
        console.log = function(msg) {
            alert(msg);
        };
    } else {
        console.log = function() {};
    }
}
