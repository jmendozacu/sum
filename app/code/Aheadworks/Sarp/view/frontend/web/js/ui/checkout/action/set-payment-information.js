define(
    [
        'mage/storage',
        'Aheadworks_Sarp/js/ui/model/url-builder',
        'Aheadworks_Sarp/js/ui/cart/model/cart',
        'Magento_Customer/js/model/customer',
        'Aheadworks_Sarp/js/ui/checkout/model/payment-method',
        'Aheadworks_Sarp/js/ui/checkout/model/billing-address',
        'Aheadworks_Sarp/js/ui/checkout/model/address-converter',
        'Aheadworks_Sarp/js/ui/model/error-processor',
        'Magento_Checkout/js/model/full-screen-loader'
    ],
    function (
        storage,
        urlBuilder,
        cart,
        customer,
        paymentMethod,
        billingAddress,
        addressConverter,
        errorProcessor,
        fullScreenLoader
    ) {
        'use strict';

        return function (messageContainer) {
            var serviceUrl = customer.isLoggedIn()
                    ? urlBuilder.createUrl('/awSarp/save-payment-information', {})
                    : urlBuilder.createUrl('/awSarp/save-guest-payment-information', {}),
                payload = {
                    cartId: cart.getCartId(),
                    paymentInformation: paymentMethod.method(),
                    billingAddress: addressConverter.getAddressDataForRequest(billingAddress.address(), 'billing')
                };

            if (!customer.isLoggedIn()) {
                payload.email = cart.guestEmail;
            }
            fullScreenLoader.startLoader();

            return storage.post(
                serviceUrl, JSON.stringify(payload)
            ).fail(
                function (response) {
                    errorProcessor.process(response, messageContainer);
                    fullScreenLoader.stopLoader();
                }
            );
        };
    }
);
