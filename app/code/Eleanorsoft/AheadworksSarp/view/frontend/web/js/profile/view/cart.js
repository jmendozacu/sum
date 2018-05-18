define([
    'jquery',
    'uiComponent',
    'ko',
    'mage/storage',
    'Magento_Catalog/js/price-utils',
    'Aheadworks_Sarp/js/ui/cart/model/cart'
], function ($, Component, ko, storage, priceUtils, cart) {
    'use script';
    return Component.extend({
        defaults: {
            template: 'Eleanorsoft_AheadworksSarp/profile/view/cart',
            urlSubscriptionProductsList: null,
            urlProductsList: null,
            urlAddProduct: null,
            urlSaveProduct: null
        },

        subscriptionProductsList: ko.observableArray([]),
        productsList: ko.observableArray([]),
        chosenProduct: ko.observableArray([]),
        subtotal: 0,

        initialize: function () {
            this.subtotal = ko.pureComputed(function () {
                var current_subtotal = 0;
                for (var i = 0; i < this.subscriptionProductsList().length; i++) {
                    current_subtotal += this.subscriptionProductsList()[i].qty * this.subscriptionProductsList()[i].price_int;
                }
                return priceUtils.formatPrice(current_subtotal, cart.getPriceFormat());
            }, this);
            this._super();
            this.getSubscriptionProducts();
            this.getAllProducts();
        },

        getAllProducts: function () {
            var self = this;
            
            return storage.post
            (
                this.urlProductsList,
                ''
            ).done(function (response) {
                response.forEach(function (item) {
                    self.productsList.push(item);
                });
            }).fail(function (response) {
                console.log(response)
            });
        },

        getSubscriptionProducts: function () {
            var self = this;

            return storage.post
            (
                this.urlSubscriptionProductsList,
                ''
            ).done(function (response) {
                response.forEach(function (item) {
                    item.item_total = priceUtils.formatPrice(item.item_total, cart.getPriceFormat());
                    item.price = priceUtils.formatPrice(item.price, cart.getPriceFormat());

                    self.subscriptionProductsList.push(item);
                });
            }).fail(function (response) {
                console.log(response)
            });
        },

        increment: function (item) {
            for (var i = 0; i < this.subscriptionProductsList().length; i++) {
                if (this.subscriptionProductsList()[i].id == item.id) {
                    this.subscriptionProductsList()[i].qty++;

                    var current_total_price = this.subscriptionProductsList()[i].price_int * this.subscriptionProductsList()[i].qty;
                    this.subscriptionProductsList()[i].item_total = priceUtils.formatPrice(current_total_price, cart.getPriceFormat());

                    break;
                }
            }
            this.subscriptionProductsListSlice();
        },

        decrement: function (item) {
            for (var i = 0; i < this.subscriptionProductsList().length; i++) {
                if (this.subscriptionProductsList()[i].name == item.name) {
                    if (this.subscriptionProductsList()[i].qty > 0) {
                        this.subscriptionProductsList()[i].qty --;

                        var current_total_price = this.subscriptionProductsList()[i].price_int * this.subscriptionProductsList()[i].qty;
                        this.subscriptionProductsList()[i].item_total = priceUtils.formatPrice(current_total_price, cart.getPriceFormat());

                        break;
                    }
                }
            }
            this.subscriptionProductsListSlice();
        },

        addProduct: function () {
            var self = this;
            var data_selected = {product_id: this.chosenProduct()[0]};

            this.productsList().forEach(function (item) {
                if (item.id == data_selected.product_id) {
                    if (item.parent_id != null) {
                        data_selected.parent_id = item.parent_id;
                    }
                }
            });

            return storage.post
            (
                this.urlAddProduct,
                data_selected,
                '',
                'application/x-www-form-urlencoded'
            ).done(function (response) {
                response.item_total = priceUtils.formatPrice(response.item_total, cart.getPriceFormat());
                response.price = priceUtils.formatPrice(response.price, cart.getPriceFormat());
                self.subscriptionProductsList.push(response);
            }).fail(function (response) {
                console.log(response)
            });

            this.subscriptionProductsListSlice();
        },

        saveProduct: function () {
            var ids = [];

            for (var i = 0; i < this.subscriptionProductsList().length; i++) {
                ids[i] =
                    {
                        product_id: this.subscriptionProductsList()[i].id,
                        qty: this.subscriptionProductsList()[i].qty
                    }
            }
            var data = JSON.stringify(ids);

            return storage.post
            (
                this.urlSaveProduct,
                data
            ).done(function (response) {
                if (response.redirectUrl) {
                    window.location = response.redirectUrl;
                }
                console.log(response)
            }).fail(function (response) {
                console.log(response)
            });
        },

        subscriptionProductsListSlice: function () {
            var data = this.subscriptionProductsList().slice(0);
            this.subscriptionProductsList([]);
            this.subscriptionProductsList(data);
        }
    });
});