jQuery(document).ready(function ($) {
    $('#wpbody-content .wrap').on('click', '.frp-form-group .frp-form-button', function () {
        if (typeof frpOptions != 'undefined') {
            var shortcode;

            for (var option in frpOptions.shortcodes) {
                if ($(this).hasClass('frp-form-button-' + option)) {
                    shortcode = frpOptions.shortcodes[option];
                    break;
                }
            }

            if (shortcode) {
                $(this).parent().next('textarea').replaceSelectedText(shortcode);
            }
        }
    });

    $('#wpbody-content .wrap').on('click', '.frp-categories .frp-all-categories input', function () {
        $categories = $('ul li input', $(this).parents('.frp-categories'));

        if ($(this).is(':checked')) {
            $categories.attr({
                'checked':false,
                'disabled':true
            });
        } else {
            $categories.attr('disabled', false);
        }
    });

    $('#wpbody-content .wrap').on('click', '.frp-form-themes-button', function () {
        $(this).next('.frp-form-themes').slideToggle();
    });

    $('#wpbody-content .wrap').on('click', '.frp-form-theme:not(.frp-active)', function () {
        var $elem = $(this);
        var themeName = $elem.attr('data-theme-name');

        $elem.parent().children('.frp-active').removeClass('frp-active');
        $elem.addClass('frp-active');
        $elem.nextAll('input').attr('value', themeName);

        if (confirm(frpOptions.confirmReplace)) {

        }
    });

    $('[id*="flexible-recent-posts-widget"] .widget-top .widget-title-action').after('\
        <div class="frp-widget-flattr-button" style="display: none">\
            <a href="' + frpOptions.flattrLink + '" target="_blank">\
                <img src="http://api.flattr.com/button/flattr-badge-large.png" alt="Flattr this" title="Flattr this" border="0" />\
            </a>\
        </div>'
    );

    $('#wpbody-content .wrap').on('click', '[id*="flexible-recent-posts-widget"] a.widget-action', function () {
        var $widgetTitle = $(this).closest('.widget-top');
        var $widgetFlattrButton = $('.frp-widget-flattr-button', $widgetTitle);

        $widgetFlattrButton.toggle();
    });
});