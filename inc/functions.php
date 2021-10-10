<?php

require('class.GetWeather.php');

/**
 * Register Widget
 *
 */
add_action('widgets_init', 'gw_widget');
if (! function_exists('gw_widget')) {
    function gw_widget() {
        register_widget('GetWeather');
    }
}

/**
 * Enqueue files
 *
 */
add_action('wp_enqueue_scripts', 'gw_enqueue_files');
if (! function_exists('gw_enqueue_files')) {
    function gw_enqueue_files() {
        wp_enqueue_style('get_weather_css', plugin_dir_url(__FILE__) . '../assets/style.css');
	    wp_enqueue_script('get_weather_js', plugin_dir_url(__FILE__) . '../assets/main.js', ['jquery'], false, true);
        wp_localize_script('get_weather_js', 'ajax_obj', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }
}

/**
 * AJAX response
 *
 */
add_action('wp_ajax_get_gw_data', 'get_gw_data');
add_action('wp_ajax_nopriv_get_gw_data', 'get_gw_data');
if (! function_exists('get_gw_data')) {
    function get_gw_data() {
        $response = gw_get_weather();

        if ($response) {
            wp_send_json_success($response);
        } else {
            wp_send_json_error('Something went wrong!');
        }
    }
}

/**
 * Function for making http - GET requests to weatherapi.com
 *
 */
if (! function_exists('gw_get_weather')) {
    function gw_get_weather() {
        $api_key = get_option('gw_add_api_key', false);
        $base_url = 'http://api.weatherapi.com/v1';

        // Error handling for API key
        if(!$api_key || '' === $api_key) {
            return [
                'success'   => false,
                'error'     => 'Not a valid API key',
            ];
        }

        // Make API request
        $response = wp_remote_get("{$base_url}/current.json?q=" . $_POST['city'] . "&key={$api_key}");

        // Error handling - check for valid response
        if(is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
            return [
                'success'	=> false,
                'error' 	=> wp_remote_retrieve_response_code($response),
            ];
        }

        // Parse response
        $data = json_decode(wp_remote_retrieve_body($response));

        // Cherry pick data
        $weather_data = [];
        $weather_data['temp'] = $data->current->temp_c;
        $weather_data['humidity'] = $data->current->humidity;
        $weather_data['condition'] = $data->current->condition->text;
        $weather_data['condition_icon'] = $data->current->condition->icon;
        $weather_data['country'] = $data->location->country;
        $weather_data['region'] = $data->location->region;
        $weather_data['lat'] = $data->location->lat;
        $weather_data['lng'] = $data->location->lon;

        // Return valid data
        return [
            'success'   => true,
            'data'      => $weather_data,
        ];
    }
}
