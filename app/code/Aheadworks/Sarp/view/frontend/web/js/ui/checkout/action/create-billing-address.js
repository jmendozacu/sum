define(
    [
        'Aheadworks_Sarp/js/ui/checkout/model/address-converter'
    ],
    function (addressConverter) {
        'use strict';

        return function (addressData) {
            return addressConverter.formAddressDataToCartAddress(addressData);
        };
    }
);
