/**
* Copyright 2016 aheadWorks. All rights reserved.
* See LICENSE.txt for license details.
*/

define([
    'jquery'
], function ($) {
    'use strict';

    $.widget('mage.awSarpPager', {
        url: '',
        options: {
            currentPage: 0,
            lastPage: 0,
        },

        /**
         * Initialize widget
         */
        _create: function() {
            this.url = location.href;

            $('[data-role=previous-button]').click({me: this}, function(event) {
                var me = event.data.me;
                me.openPage(me.options.currentPage-1);
            });
            $('[data-role=next-button]').click({me: this}, function(event) {
                var me = event.data.me;
                me.openPage(me.options.currentPage+1);
            });
            $('[data-role="current-page"]').keypress({me: this}, function(event) {
                var me = event.data.me;
                me.inputPage(event, me.options.lastPage);
            });
        },

        /**
         * Add page variable to url
         * @param url
         * @param varName
         * @param varValue
         * @returns {string|*}
         * @private
         */
        _addPageToUrl:function (url, varName, varValue) {
            var re = new RegExp('\/(' + varName + '\/.*?\/)');
            var parts = url.split(new RegExp('\\?'));
            url = parts[0].replace(re, '/');
            url += varName + '/' + varValue + '/';
            if (parts.length > 1) {
                url += '?' + parts[1];
            }
            return url;
        },

        /**
         * Open page by input value
         * @param event
         * @param maxPage
         */
        inputPage:function (event, maxPage) {
            var element = $(event.target);
            var keyCode = event.keyCode || event.which;
            if (keyCode == 13) {
                var value = parseInt(element.val());
                if (isNaN(value) || value < 1) {
                    value = 1;
                }
                if (value > maxPage) {
                    value = maxPage;
                }
                this.openPage(value);
            }
        },

        /**
         * Open page
         * @param page
         */
        openPage:function (page) {
            this.url = this._addPageToUrl(this.url, 'page', page);
            window.location = this.url;
        },
    });

    return $.mage.awSarpPager;
});
