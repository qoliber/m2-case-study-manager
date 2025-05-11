define([
    'jquery',
    'Magento_Ui/js/modal/alert'
], function ($, alert) {
    'use strict';

    return function (config) {
        $('#check_connection_button').on('click', function () {
            $.ajax({
                url: config.ajaxUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    form_key: window.FORM_KEY
                },
                showLoader: true,
                success: function (response) {
                    alert({
                        title: response.success ? 'Success' : 'Error',
                        content: response.message,
                        actions: {
                            always: function () {}
                        }
                    });
                },
                error: function () {
                    alert({
                        title: 'Error',
                        content: 'An error occurred while checking the connection.',
                        actions: {
                            always: function () {}
                        }
                    });
                }
            });
        });
    };
}); 