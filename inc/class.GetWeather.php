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

        /**
         * Start widget
         *
         */
        echo $before_widget;

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

        return $instance;
    }
}
