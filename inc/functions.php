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
        wp_enqueue_style('get_weather_css', plugin_dir_url(__FILE__) . 'assets/style.css');
	    wp_enqueue_script('get_weather_js', plugin_dir_url(__FILE__) . 'assets/main.js', ['jquery'], false, true);
    }
}
