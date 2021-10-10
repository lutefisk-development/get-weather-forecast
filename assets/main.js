(function($) {
    $('.widget_get_weather .gw__city').each(function(i, widget) {
        let city = $(widget).data('city');

        if ('' !== city) {
            $.post(ajax_obj.ajax_url, {
                action: 'get_gw_data',
                city: city,
            })
            .done(function(response) {
                let output = '';
                if (response.success) {
                    let data = response.data;

                    console.log(data);

                    output += `<p>Weather Forecast for: ${city}</p><br>`;

                }
                $(widget).html(output);
            })
            .fail(function(error) {
                console.error(error)
            });
        }
    });
})(jQuery);
