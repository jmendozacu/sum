define(
    [
        'Aheadworks_Sarp/js/ui/checkout/model/shipping-address'
    ],
    function(shippingAddress) {
        'use strict';

        return function(address) {
            shippingAddress.address(address);
        };
    }
);
