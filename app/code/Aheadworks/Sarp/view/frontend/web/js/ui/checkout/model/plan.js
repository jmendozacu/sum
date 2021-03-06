define(
    [
        'ko',
        'underscore',
        'Aheadworks_Sarp/js/ui/cart/model/cart',
        'Aheadworks_Sarp/js/ui/cart/model/subscription-plans'
    ],
    function (ko, _, cart, plans) {
        'use strict';

        return {
            /**
             * Get subscription plan
             *
             * @returns {Object}
             */
            getPlan: function () {
                return plans.getItemById(cart.getSubscriptionPlanId());
            }
        };
    }
);
