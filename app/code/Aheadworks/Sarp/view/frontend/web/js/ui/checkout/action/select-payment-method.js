define(
    [
        'Aheadworks_Sarp/js/ui/checkout/model/payment-method'
    ],
    function(paymentMethod) {
        'use strict';

        return function (method) {
            paymentMethod.method(method);
        }
    }
);
