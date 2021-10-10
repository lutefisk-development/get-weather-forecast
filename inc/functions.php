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

    }
}
