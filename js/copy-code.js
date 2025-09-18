/**
 * Adds copy-to-clipboard functionality for code blocks
 *
 * @author Karsten Kosmala <kosmala@cosmocode.de>
 */
(function($) {
    'use strict';

    /**
     * Create and insert copy button for a code element
     */
    var createCopyButton = function($codeElement) {
        var $button = $('<button>')
            .addClass('code-copy-btn')
            .attr('title', 'Copy to clipboard')
            .html('<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>')
            .on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                copyCodeToClipboard($codeElement, $button);
            });

        // Create wrapper if code element is not already wrapped
        var $wrapper = $codeElement.parent('.code-wrapper');
        if (!$wrapper.length) {
            $wrapper = $('<div>').addClass('code-wrapper');
            $codeElement.wrap($wrapper);
            $wrapper = $codeElement.parent();
        }
        
        $wrapper.addClass('has-copy-btn').append($button);
    };

    /**
     * Copy code content to clipboard
     */
    var copyCodeToClipboard = function($codeElement, $button) {
        // Get text content without HTML
        var textContent = $codeElement.text();
        
        // Create temporary textarea for copying
        var $temp = $('<textarea>')
            .css({
                position: 'absolute',
                left: '-9999px',
                top: '0'
            })
            .val(textContent)
            .appendTo('body');
        
        // Select and copy
        $temp[0].select();
        $temp[0].setSelectionRange(0, 99999); // For mobile devices
        
        try {
            var successful = document.execCommand('copy');
            if (successful) {
                showCopyFeedback($button, true);
            } else {
                showCopyFeedback($button, false);
            }
        } catch (err) {
            // Fallback for modern browsers
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(textContent).then(function() {
                    showCopyFeedback($button, true);
                }, function() {
                    showCopyFeedback($button, false);
                });
            } else {
                showCopyFeedback($button, false);
            }
        }
        
        $temp.remove();
    };

    /**
     * Show visual feedback after copy attempt
     */
    var showCopyFeedback = function($button, success) {
        var originalHtml = $button.html();
        var originalTitle = $button.attr('title');
        
        if (success) {
            $button
                .addClass('copy-success')
                .attr('title', 'Copied!')
                .html('<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>');
        } else {
            $button
                .addClass('copy-error')
                .attr('title', 'Copy failed')
                .html('<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>');
        }
        
        setTimeout(function() {
            $button
                .removeClass('copy-success copy-error')
                .attr('title', originalTitle)
                .html(originalHtml);
        }, 2000);
    };

    /**
     * Initialize copy buttons for all code elements
     */
    var initCopyButtons = function() {
        // Find all elements with class "code"
        $('.code').each(function() {
            var $code = $(this);
            // Skip if already has copy button
            if ($code.parent('.has-copy-btn').length) return;
            
            createCopyButton($code);
        });
        
        // Also handle pre > code combinations
        $('pre > code').each(function() {
            var $code = $(this);
            var $pre = $code.parent();
            // Skip if already has copy button
            if ($pre.parent('.has-copy-btn').length) return;
            
            createCopyButton($pre);
        });
    };

    // Initialize on DOM ready
    $(function() {
        initCopyButtons();
        
        // Re-initialize when new content is loaded (e.g., via AJAX)
        $(document).on('DOMContentLoaded', initCopyButtons);
    });

})(jQuery);
