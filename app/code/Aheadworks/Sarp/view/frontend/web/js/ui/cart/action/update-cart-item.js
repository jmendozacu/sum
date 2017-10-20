define(
    [
        'jquery',
        'Aheadworks_Sarp/js/ui/cart/model/cart',
        'Aheadworks_Sarp/js/ui/model/url-builder',
        'mage/storage',
        'Aheadworks_Sarp/js/ui/cart/model/full-screen-loader',
        'Aheadworks_Sarp/js/ui/model/error-processor'
    ],
    function (
        $,
        cart,
        urlBuilder,
        storage,
        fullScreenLoader,
        errorProcessor
    ) {
        'use strict';

        return function (cartItem) {
            var serviceUrl = urlBuilder.createUrl('/awSarp/update-cart-item', {}),
                payload = {
                    item: cartItem
                };

            fullScreenLoader.startLoader();

            return storage.post(
                serviceUrl, JSON.stringify(payload)
            ).done(
                function (response) {
                    cart.setCartData(response);
                }
            ).fail(
                function (response) {
                    errorProcessor.process(response);
                }
            ).always(
                function () {
                    fullScreenLoader.stopLoader();
                }
            );
        };
    }
);
