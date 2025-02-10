define([
    'Magento_Ui/js/grid/massactions'
], function (Massactions) {
    'use strict';

    return Massactions.extend({
        defaults: {
            ajaxSettings: {
                method: 'POST',
                dataType: 'json'
            }
        },

        /**
         * Default action callback
         */
        defaultCallback: function (response) {
            if (response.success) {
                this.notify('success', response.message);
            } else {
                this.notify('error', response.message);
            }
        }
    });
}); 