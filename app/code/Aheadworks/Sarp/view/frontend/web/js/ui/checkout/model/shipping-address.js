define(
    [
        'ko',
        'Aheadworks_Sarp/js/ui/cart/model/cart',
        'Magento_Checkout/js/model/new-customer-address'
    ],
    function(ko, cart, address) {
        'use strict';

        return {
            address: ko.observable(address(cart.getAddressByType('shipping')))
        };
    }
);
