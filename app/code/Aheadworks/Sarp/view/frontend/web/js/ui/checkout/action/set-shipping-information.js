define(
    [
        'Aheadworks_Sarp/js/ui/checkout/model/shipping-address',
        'Aheadworks_Sarp/js/ui/checkout/model/shipping-save-processor'
    ],
    function (shippingAddress, shippingSaveProcessor) {
        'use strict';

        return function () {
            return shippingSaveProcessor.saveShippingInformation(shippingAddress.address().getType());
        }
    }
);
