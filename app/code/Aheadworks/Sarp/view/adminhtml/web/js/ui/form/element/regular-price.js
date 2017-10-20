define([
    'Magento_Ui/js/form/element/abstract',
], function (Element) {
    'use strict';

    return Element.extend({
        /**
         * Make element required
         * @returns {Abstract} Chainable.
         */
        setRequired: function () {
            this.required(true);
            this.validation['required-entry'] = true;
            return this;
        },

        /**
         * Make element not required
         * @returns {Abstract} Chainable.
         */
        setNotRequired: function () {
            this.required(false);
            this.validation['required-entry'] = false;
            return this;
        },
    });
});
