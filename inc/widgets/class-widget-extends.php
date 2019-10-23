<?php
/**
 * This class simply add a field to widgets that allows you to add additional css class to it for further styling
 *
 * @version 1.0
 * @package MeloKids
 * @since   1.0
 */

if ( ! defined( 'ABSPATH' ) )
{
    die();
}

class MeloKids_Widget_Extends
{
    /**
     * Construction
     */
    function __construct()
    {
        global $pagenow;

        if ( is_admin() )
        {
            add_action( 'in_widget_form', array( $this, 'extend_widget_form' ), 10, 3 );
            add_filter( 'widget_update_callback', array( $this, 'extend_widget_update' ), 10, 4 );
        }
        add_filter( 'dynamic_sidebar_params', array( $this, 'extend_widget_params'), 10, 2 );
    }


    /**
     * Adds form fields to the end of Widget form
     * 
     * @param   $widget     object  WP_Widget | The widget instance, passed by reference.
     * @param   $return     null    Return null if new fields are added.
     * @param   $instance   array   An array of the widget's settings.
     * @return  array               An array of the new widget's settings.
     */
    function extend_widget_form( $widget, $return, $instance )
    {
        
        $el_class        = isset( $instance['el_class'] ) ? $instance['el_class'] : '';
        $use_theme_style = isset( $instance['use_theme_style'] ) ? (bool) $instance['use_theme_style'] : false;
        $hide_title      = isset( $instance['hide_title'] ) ? (bool) $instance['hide_title'] : false;
        ?>
        <p>
            <input type="checkbox" 
                name="widget-<?php echo esc_attr( $widget->id_base . '[' . $widget->number . '][hide_title]' ); ?>" 
                id="widget-<?php echo esc_attr( $widget->id_base . '-' . $widget->number ); ?>-hide_title" 
                <?php checked( $hide_title ); ?> />
            <label for="widget-<?php echo esc_attr( $widget->id_base . '-' . $widget->number ); ?>-hide_title"><?php esc_html_e( 'Hide widget title', 'melokids' ); ?></label>
        </p>
        <p>
            <label for="widget-<?php echo esc_attr( $widget->id_base . '-' . $widget->number ); ?>-el_class"><?php esc_html_e( 'CSS Class', 'melokids' ); ?></label>
            <input type="text" class="widefat code" 
                name="widget-<?php echo esc_attr( $widget->id_base . '[' . $widget->number . '][el_class]' ); ?>" 
                id="widget-<?php echo esc_attr( $widget->id_base . '-' . $widget->number ); ?>-el_class" 
                value="<?php echo esc_attr( $el_class ); ?>" />
        </p>
        <?php
        return $instance;
    }


    /**
     * Add css class param to the widget before saving
     * 
     * @param   $instance       array   The current widget instance's settings.
     * @param   $new_instance   array   Array of new widget settings.
     * @return  array                   An array of the new widget's settings.
     */
    function extend_widget_update( $instance, $new_instance, $old_instance, $object )
    {
        $instance['el_class']        = isset( $new_instance['el_class'] ) ? $new_instance['el_class'] : '';
        $instance['hide_title']      = isset( $new_instance['hide_title'] ) ? (bool) $new_instance['hide_title'] : false;
        $instance['use_theme_style'] = isset( $new_instance['use_theme_style'] ) ? (bool)$new_instance['use_theme_style'] : false;   
        
        return $instance;
    }

    /**
     * Add css class to widget front-end display by filtering widget params
     * @param   $params array
     * @return  array   Extended widget parameters
     */
    function extend_widget_params( $params )
    {
        global $wp_registered_widgets;
        
        $widget_obj = $wp_registered_widgets[$params[0]['widget_id']];
        $widget_num = $widget_obj['params'][0]['number'];
        $instances = get_option( $widget_obj['callback'][0]->option_name );
        $instance = $instances[$widget_num];
        // Add classs
        $classes = array();

        preg_match( '/\sclass=".+?"/', $params[0]['before_widget'], $matches );

        $origin_classes = ! ( empty( $matches ) || empty( $matches[0] ) ) ? substr( $matches[0], 8, -1 ) : '';

        if ( $origin_classes )
        {
            $classes[] = $origin_classes;
        }

        if ( isset( $instance['use_theme_style'] ) && $instance['use_theme_style'] )
        {
            $classes[] = 'theme-style';
        }
        

        if ( isset( $instance['el_class'] ) )
        {
            $classes[] = $instance['el_class'];
        }

        $classes = array_map( 'esc_attr', $classes );
        $class_string = join( ' ', $classes );
        $class_string = trim( $class_string );

        if ( strlen( $class_string ) )
        {
            $params[0]['before_widget'] = preg_replace( '/\sclass=".+?"/', sprintf( ' class="%s"', $class_string ), $params[0]['before_widget'] );
        }
        
        // Hide Title
        if ( isset( $instance['hide_title'] ) && $instance['hide_title'] )
        {
            $params[0]['before_title'] = '<div class="screen-reader-text d-none">' . $params[0]['before_title'];
            $params[0]['after_title'] = $params[0]['after_title'] . '</div>';
        }

        return $params;
    }
}

new MeloKids_Widget_Extends();
