define([
    'jquery',
    'uiComponent',
    'ko',
    'mage/storage'
], function ($, Component, ko, storage) {
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

        initialize: function () {
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
            ).done(function (response) {;
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

                    var current_qty = this.subscriptionProductsList()[i].qty;
                    this.subscriptionProductsList()[i].item_total = this.subscriptionProductsList()[i].price * current_qty;

                    break;
                }
            }
            this.subscriptionProductsListSlice();
        },

        decrement: function (item) {
            for (var i = 0; i < this.subscriptionProductsList().length; i++) {
                if (this.subscriptionProductsList()[i].name == item.name) {
                    if (this.subscriptionProductsList()[i].qty > 1) {
                        this.subscriptionProductsList()[i].qty --;

                        var current_qty = this.subscriptionProductsList()[i].qty;
                        this.subscriptionProductsList()[i].item_total = this.subscriptionProductsList()[i].price * current_qty;

                        break;
                    }
                }
            }
            this.subscriptionProductsListSlice();
        },

        addProduct: function () {
            var data = {product_id: this.chosenProduct()[0]};
            var self = this;

            return storage.post
            (
                this.urlAddProduct,
                data,
                '',
                'application/x-www-form-urlencoded'
            ).done(function (response) {
                self.subscriptionProductsList.push(response);
            }).fail(function (response) {
                console.log(response)
            });

            this.subscriptionProductsListSlice();
        },

        saveProduct: function () {
            var ids = [];

            for (var i = 0; i < this.subscriptionProductsList().length; i++) {
                ids[i] = this.subscriptionProductsList()[i].id;
            }
            var data = JSON.stringify(ids);

            return storage.post
            (
                this.urlSaveProduct,
                data
            ).done(function (response) {

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