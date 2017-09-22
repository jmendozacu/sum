define(['Magento_Ui/js/form/element/abstract', 'knockout', 'jquery'], function(Abstract, ko, $) {
    return Abstract.extend({
        defaults: {
            rawCollection: ko.observable(''),
            howToCollection: ko.observable(''),
            links: {
                rawCollection: '${ $.provider }:data.product.how_to'
            }
        },

        initialize: function () {
            this._super();

            var rawData = [],
                dataArray = [];

            try {
                rawData = JSON.parse(this.rawCollection());
            } catch (err) {
            }

            rawData.each(function (item) {
                dataArray.push({
                    imageUrl    : ko.observable(item.imageUrl),
                    description : ko.observable(item.description),
                    order       : ko.observable(item.order)
                });
            });

            dataArray = this.sortHowTo(dataArray);

            this.howToCollection(dataArray);
            this.updateRawCollection();

            return this;
        },

        initObservable: function () {
            return this._super()
                .observe([
                    'rawCollection',
                    'howToCollection'
                ]);
        },

        updateHowTo: function(data, event) {
            this.howToCollection(
                this.sortHowTo(this.howToCollection())
            );
            this.updateRawCollection();
        },

        sortHowTo: function(collection) {
            return collection.sort(function(a, b) {
                return (a.order() > b.order()) ? 1 : ((b.order() > a.order()) ? -1 : 0);
            });
        },

        updateRawCollection: function() {
            this.rawCollection(ko.toJSON(this.howToCollection()));
        },

        uploadImage: function(element, item) {
            var fr = new FileReader(),
                file = element.files[0],
                imgTag = $(element).prev()[0];

            fr.onload = function () {
                imgTag.src = fr.result;
                item.imageUrl(imgTag.src);
                this.updateRawCollection()
            }.bind(this);

            fr.readAsDataURL(file);
        },

        addHowTo: function() {
            var collection = this.howToCollection(),
                maxOrder = Math.max.apply(Math, collection.map(function(item) {
                            return item.order();
                        }
                    )) + 1;

            collection.push({
                imageUrl: ko.observable(''),
                description: ko.observable(''),
                order: ko.observable(isFinite(maxOrder) ? maxOrder : 1)
            });

            this.howToCollection(collection);
            this.updateRawCollection();
        },

        removeHowTo: function(data, event) {
            this.howToCollection(
                this.howToCollection().filter(function(item) {
                    return (item != data) ? true : false;
                })
            );

            this.updateRawCollection();
        }
    });
});
