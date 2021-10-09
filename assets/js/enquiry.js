;(function($) {

    $('#nhrrob-plugin-enquiry-form form').on('submit', function(e) {
        e.preventDefault();

        var data = $(this).serialize();

        $.post(nhrrobPlugin.ajaxurl, data, function(response) {
            if (response.success) {
                console.log(response.success);
            } else {
                alert(response.data.message);
            }
        })
        .fail(function() {
            alert(nhrrobPlugin.error);
        })

    });

})(jQuery);
