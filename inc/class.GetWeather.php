<?php

class GetWeather extends WP_Widget {
    /**
     * Register wiget with Wordpress
     *
     */
    public function __construct() {
        parent::__construct(
            'get_weather',
            'Get Weather Forecast',
            ['description' => __('A widget for showing weather forecast', 'getweather')]
        );
    }

    /**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
    public function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);

        /**
         * Start widget
         *
         */
        echo $before_widget;

        /**
         * Title
         *
         */
        if (! empty($title)) {
            echo $before_title . $title . $after_title;
        }

        $city = ('' !== $instance['city']) ? $instance['city'] : '';
        ?>
        <div class="gw__city" data-city="<?php echo $city; ?>">
            <p><?php _e('Loading ...', 'getweather'); ?></p>
        </div>
        <?php

        /**
         * close widget
         *
         */
        echo $after_widget;
    }

    /**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
    public function form($instance) {
        $title = (isset($instance['title']))
                ? $instance['title']
                : get_option('gw_default_widget_title', __('Get Weather Forecast', 'getweather'));

        $city = (isset($instance['city']))
                ? $instance['city']
                : '';

        ?>
        <!-- TITLE -->
        <p>
            <label for="<?php echo $this->get_field_name('title'); ?>"><?php _e('Title:', 'getweather'); ?></label>
            <input
                type="text"
                id="<?php echo $this->get_field_id('title'); ?>"
                name="<?php echo $this->get_field_name('title'); ?>"
                value="<?php echo esc_attr($title); ?>"
            >
        </p>
        <!-- /TITLE -->

        <!-- CITY -->
        <p>
            <label for="<?php echo $this->get_field_name('city'); ?>"><?php _e('City:', 'getweather'); ?></label>
            <input
                type="text"
                id="<?php echo $this->get_field_id('city'); ?>"
                name="<?php echo $this->get_field_name('city'); ?>"
                value="<?php echo esc_attr($city); ?>"
            >
        </p>
        <!-- /CITY -->
        <?php
    }

    /**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['title'] = (! empty($new_instance['title']))
                            ? strip_tags($new_instance['title'])
                            : '';

        $instance['city'] = (! empty($new_instance['city']))
                            ? strip_tags($new_instance['city'])
                            : '';

        return $instance;
    }
}
