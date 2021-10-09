<?php

/**
 * Add settings page to wp admin
 *
 */
add_action('admin_menu', 'gw_add_settings_page');
if (! function_exists('gw_add_settings_page')) {
    function gw_add_settings_page() {
        add_submenu_page(
            'options-general.php',              // parent page
            'Get Weather Forecast API key',     // page title
            'API Key',                          // menu title
            'manage_options',                   // minimum capability
            'gwsettings',                       // slug
            'gw_settings_page',                 // callback
        );
    }
}

/**
 * Register options for settings page
 *
 */
add_action('admin_init', 'gw_settings_init');
if (! function_exists('gw_settings_init')) {
    function gw_settings_init() {
        add_settings_section(
            'gw_general_option',    // id
            'Add API key',          // section title
            'gw_general_options',   // callback
            'gwsettings',           // page to add settings
        );

        /**
         * Add settings fields to: "General Options"
         *
         */
        add_settings_field(
            'gw_add_api_key',                   // id
            'Add API key from: weatherapi.com', // label
            'gw_add_api_key_cb',                // callback
            'gwsettings',                       // page to add settings field
            'gw_general_option',                // section to add settings field
        );

        register_setting('gw_general_option', 'gw_add_api_key');
    }
}

/**
 * Render settings page
 *
 */
if (! function_exists('gw_settings_page')) {
    function gw_settings_page() {
        ?>
        <div class="gw__settings-wrapper">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

            <form method="POST" action="options.php">
            <?php
                /**
                 * Output security fields
                 *
                 */
                settings_fields('gw_general_option');

                /**
                 * Output settings section
                 *
                 */
                do_settings_sections('gwsettings');

                /**
                 * Output save settings btn
                 *
                 */
                submit_button();
            ?>
            </form>
        </div><!-- /.gw__settings-wrapper -->
        <?php
    }
}

/**
 * Render Settings section
 *
 */
if (! function_exists('gw_general_options')) {
    function gw_general_options() {

        // Add section heading here

        ?>
        <!--
        <p><?php // _e('This is a test', 'getweather') ?></p>
        -->
        <?php
    }
}

/**
 * Render Settings field
 *
 */
if (! function_exists('gw_add_api_key_cb')) {
    function gw_add_api_key_cb() {
        ?>
        <input
            type="text"
            name="gw_add_api_key"
            id="gw_add_api_key"
            placeholder="Add API key here"
            value="<?php echo get_option('gw_add_api_key', false); ?>"
        >
        <?php
    }
}
