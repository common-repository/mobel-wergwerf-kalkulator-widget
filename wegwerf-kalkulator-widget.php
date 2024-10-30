<?php
/**
 * Plugin Name: Möbel Wergwerf Kalkulator - Widget
 * Plugin URI: https://weitergeben.org
 * Description: Dieses Plugin stellt ein Widget bereit, mit dem man Schätzungen, für die wöchentlich weggeworfenen Möbel einer Stadt nachsehen kann. Um dies zu bewerkstelligen wird mit dem Weitergeben.Org Server kommuniziert.
 * Version: 2019.09.001
 * Author: Moritz Hannemann
 * Author URI: https://linkedin.com/in/moritz-h-523b95117
 * License: GPL2
 */

// Register widget
add_action( 'widgets_init', 'register_wgorg_furniture_calucaltor_widget' );

function register_wgorg_furniture_calucaltor_widget() {
    register_widget( 'Furniture_Calculator_Widget' );
}



class Furniture_Calculator_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'furniture_calculator_widget', // Base ID
            'Möbel Wegwerf-Kalkulator', // Name
            array( 'description' => __( 'Dieses Widget schätzt anhand der Daten von Weitergeben.Org die weggeschmissenen Möbel einer Stadt, innerhalb einer Woche.', 'text_domain' ), ) // Args
        );

        add_action('wp_enqueue_scripts', 'furniture_calculator_enqueue_scripts');
        add_action('admin_enqueue_scripts', 'furniture_calculator_enqueue_scripts');
        function furniture_calculator_enqueue_scripts() {
            wp_enqueue_style('furniture-calculator-css', plugins_url('./wegwerf_kalkulator_widget.css', __FILE__));
            wp_enqueue_script('furniture-calculator-js', plugins_url('./wegwerf_kalkulator_widget.js', __FILE__));
        }
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        //$title = apply_filters( 'widget_title', $instance['title'] );
        $title = apply_filters( 'widget_title', "Check: Müll-Möbel" );

        echo $before_widget;
        echo $before_title . $title . $after_title;

        //echo __( 'Hello, World!', 'text_domain' );
        $readonly = $instance['default_edit'] ? '' : 'readonly';
        ?>
        <div class="wgorg_autocomplete">
        	<p>Wieviele Möbel werden in dieser Stadt wöchentlich weggeworfen?</p>
        	<input id="moebel_kalkulator_input" type="text" placeholder="Stadt" value="<?php echo $instance['default_city'] ?>" <?php echo $readonly; ?>>
        	<button class="wgorg_calculate-furniture-button" onclick="calculate_furniture();">Abschicken</button>
    	    <p id="moebel_kalkulator_text"></p>
        </div>


        <script>
            var link_allowed = <?php echo( (bool) $instance['default_link_weitergeben'] ? 1 : 0); ?>;
            autocomplete(document.getElementById("moebel_kalkulator_input"));
        </script>
        <?php

        echo $after_widget;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $default_city = ! empty( $instance['default_city'] ) ? $instance['default_city'] : '';
        $default_editable = $instance['default_edit'] ? true : false;
        $default_link_weitergeben  = $instance['default_link_weitergeben'] ? true : false;
        ?>
        <p>
            <label for="<?php echo $this->get_field_name( 'default_city' ); ?>"><?php _e( 'Voreingestellte Stadt:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'default_city' ); ?>" name="<?php echo $this->get_field_name( 'default_city' ); ?>" type="text" value="<?php echo esc_attr( $default_city ); ?>" />
            <br>
            <label for="<?php echo $this->get_field_name( 'default_edit' ); ?>"><?php _e( 'Stadt vom Benutzer änderbar?' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'default_edit' ); ?>" name="<?php echo $this->get_field_name( 'default_edit' ); ?>" type="checkbox" value=<?php echo esc_attr( $default_editable ); ?> />
            <br><br>
            <label for="<?php echo $this->get_field_name( 'default_link_weitergeben' ); ?>"><?php _e( 'Hiermit erteile ich die Erlaubnis, dass auf www.weitergeben.org verlinkt werden darf.' ); ?></label>
            <input id="<?php echo $this->get_field_id( 'default_link_weitergeben' ); ?>" name="<?php echo $this->get_field_name( 'default_link_weitergeben' ); ?>" type="checkbox" value=<?php echo esc_attr( $default_link_weitergeben ); ?> />
        </p>

        <script>
            var link_allowed = false;
            autocomplete(document.getElementById("<?php echo $this->get_field_id( 'default_city' ); ?>"))
        </script>
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
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['default_city'] = ( !empty( $new_instance['default_city'] ) ) ? strip_tags( $new_instance['default_city'] ) : '';
        $instance['default_edit'] = $new_instance['default_edit'];
        $instance['default_link_weitergeben'] = $new_instance['default_link_weitergeben'];

        return $instance;
    }
}

?>
