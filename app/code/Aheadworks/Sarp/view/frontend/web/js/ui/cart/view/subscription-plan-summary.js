define(
    [
        'jquery',
        'ko',
        'uiComponent',
        'Aheadworks_Sarp/js/ui/cart/model/cart',
        'Aheadworks_Sarp/js/ui/cart/model/subscription-plan-summary',
        'Aheadworks_Sarp/js/ui/cart/action/update-cart',
        'Magento_Catalog/js/price-utils',
        'moment',
        'mage/calendar',
        'mageUtils',
        'Magento_Customer/js/model/authentication-popup'
    ],
    function(
        $,
        ko,
        Component,
        cart,
        subscriptionPlanSummary,
        updateCartAction,
        priceUtils,
        moment,
        calendar,
        utils,
        authenticationPopup
    ) {
        'use strict';

        ko.bindingHandlers.awSarpCartStartDate = {

            /**
             * Called when the binding is first applied to an element
             *
             * @param {Object} el
             * @param {Function} valueAccessor
             */
            init: function (el, valueAccessor) {
                var currentStoreDate = moment(window.awSarpCheckoutConfig.currentDate, 'MM/DD/YYYY');
                var currentClientDate = moment();
                var days = currentStoreDate.diff(currentClientDate, 'days');

                if (days < 0) {
                    days = 0;
                }

                var config = valueAccessor(),
                    value = config.value,
                    inputDateFormat = 'MM/dd/y',
                    outputDateFormat = 'y-MM-dd',
                    options = {
                        dateFormat: inputDateFormat,
                        minDate: days
                    },
                    form = $(el).parents('form[data-role=start-date-form]');

                $(el).calendar(options);
                if (value()) {
                    var dateValue = moment(value(), utils.normalizeDate(outputDateFormat));

                    $(el).datepicker(
                        'setDate',
                        moment(dateValue, utils.normalizeDate(options.dateFormat)).toDate()
                    );
                }
                $(el).blur();

                ko.utils.registerEventHandler(el, 'change', function () {
                    var dateValue = moment(this.value, utils.normalizeDate(options.dateFormat)),
                        formattedDateValue = dateValue.format(utils.normalizeDate(outputDateFormat));

                    value(formattedDateValue);
                });

                if (form.length) {
                    form.validate({
                        errorPlacement: function(error, element) {
                            var placement = element.parent();

                            error.insertAfter(placement);
                        }
                    });
                }
            }
        };

        return Component.extend({
            cart: cart.cartData,
            isPlanSelected: cart.isPlanSelected,
            numberOfPayments: subscriptionPlanSummary.getNumberOfPayments(),
            repeat: subscriptionPlanSummary.getRepeat(),
            isTrialPeriodEnabled: subscriptionPlanSummary.getIsTrialPeriodEnabled(),
            trialPeriod: subscriptionPlanSummary.getTrialPeriod(),
            start: subscriptionPlanSummary.getStart(),
            startDateType: subscriptionPlanSummary.getStartDateType(),
            startDate: subscriptionPlanSummary.getStartDate(),
            subtotal: subscriptionPlanSummary.getSubtotal(),
            trialSubtotal: subscriptionPlanSummary.getTrialSubtotal(),

            /**
             * Format price amount
             *
             * @param {Number} price
             * @returns {String}
             */
            formatPrice: function (price) {
                return priceUtils.formatPrice(price, cart.getPriceFormat());
            },

            /**
             * On continue to checkout button click event handler
             */
            onContinueToCheckoutClick: function () {
                var startDateForm = $('form[data-role=start-date-form]'),
                    canPerformAction = startDateForm.length && startDateForm.valid() || !startDateForm.length;

                if (window.awSarpCheckoutConfig.isCustomerLoggedIn === false
                    && window.awSarpCheckoutConfig.isGuestCheckoutAllowed === false
                ) {
                    authenticationPopup.showModal();
                    canPerformAction = false;
                }

                if (canPerformAction) {
                    cart.startDate(this.startDate());
                    updateCartAction(cart.cartData()).done(function () {
                        window.location = window.awSarpCheckoutConfig.checkoutUrl;
                    });
                }
            }
        });
    }
);
