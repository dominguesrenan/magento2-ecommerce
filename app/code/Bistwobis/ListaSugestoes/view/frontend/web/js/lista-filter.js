define([
    'jquery'
], function ($) {
    'use strict';

    return function (config, element) {
        $(element).find('#category-filter').on('change', function () {
            var category = $(this).val();
            
            if (category) {
                $('.lista-item').hide();
                $('.lista-item[data-category="' + category + '"]').show();
            } else {
                $('.lista-item').show();
            }
        });
    };
}); 