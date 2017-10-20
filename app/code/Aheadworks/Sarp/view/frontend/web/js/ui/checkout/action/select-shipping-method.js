define(
    [
        'Aheadworks_Sarp/js/ui/cart/model/cart'
    ],
    function (cart) {
        'use strict';

        return function (shippingMethod) {
            cart.shippingMethod(shippingMethod)
        }
    }
);
