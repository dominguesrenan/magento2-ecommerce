define([
    'uiComponent',
    'ko',
    'mage/storage',
    'mage/url'
], function (Component, ko, storage, urlBuilder) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Bistwobis_ListaSugestoes/lista-sugestoes',
            listas: []
        },

        initialize: function () {
            this._super();
            this.listas = ko.observableArray(this.listas);
            return this;
        },

        addAllToCart: function (lista) {
            var self = this;
            storage.get(
                urlBuilder.build('listasugestoes/lista/produtos/' + lista.entity_id)
            ).done(function (response) {
                if (response.length) {
                    response.forEach(function (product) {
                        self.addToCart(product.product_id);
                    });
                }
            });
        },

        addToCart: function (productId) {
            storage.post(
                urlBuilder.build('checkout/cart/add'),
                JSON.stringify({
                    'product': productId,
                    'qty': 1
                })
            ).done(function (response) {
                // Atualizar mini carrinho
                $('[data-block="minicart"]').trigger('contentUpdated');
            });
        }
    });
}); 