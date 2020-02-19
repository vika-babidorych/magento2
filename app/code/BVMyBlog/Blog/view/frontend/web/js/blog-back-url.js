define([
    'jquery',
    'jquery/ui',
    'redirectUrl'
], function($){
    'use strict';

    $.widget('mage.blogBackUrl', {
        options: {
            title: 'title'
        },

        /**
         * Widget initialization
         * @private
         */
        _create: function() {
            $(this.element).redirectUrl({url: this.options.redirectUrl.url});
        }
    });

    return $.mage.blogBackUrl;
});