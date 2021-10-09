;(function($) {

    $('table.wp-list-table.contacts').on('click', 'a.submitdelete', function(e) {
        e.preventDefault();

        if (!confirm(nhrrobPlugin.confirm)) {
            return;
        }

        var self = $(this),
            id = self.data('id');

        // wp.ajax.send('wd-nhrrob-plugin-delete-contact', {
        //     data: {
        //         id: id,
        //         _wpnonce: nhrrobPlugin.nonce
        //     }
        // })
        wp.ajax.post('wd-nhrrob-plugin-delete-contact', {
            id: id,
            _wpnonce: nhrrobPlugin.nonce
        })
        .done(function(response) {

            self.closest('tr')
                .css('background-color', 'red')
                .hide(400, function() {
                    $(this).remove();
                });

        })
        .fail(function() {
            alert(nhrrobPlugin.error);
        });
    });

})(jQuery);
