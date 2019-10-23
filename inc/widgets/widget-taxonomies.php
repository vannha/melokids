<?php
if(!class_exists('EF4Framework')) return;
/**
 * Widget API: MeloKids_Widget_Taxonomies class
 *
 * @package WordPress
 * @subpackage Widgets
 * @since 4.4.0
 */

/**
 * Core class used to implement a Categories widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */

function MeloKids_Widget_Taxonomies() {
    register_ef4_widget('MeloKids_Widget_Taxonomies');
}
add_action('widgets_init', 'MeloKids_Widget_Taxonomies');

class MeloKids_Widget_Taxonomies extends WP_Widget {

	/**
	 * Sets up a new Categories widget instance.
	 *
	 * @since 2.8.0
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_taxonomies widget_categories',
			'description' => esc_html__( 'A list of taxonomies.','melokids' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'taxonomies', esc_html__( '[MeloKids] Taxonomies','melokids' ), $widget_ops );
	}

	/**
	 * Outputs the content for the current Categories widget instance.
	 *
	 * @since 2.8.0
	 *
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Categories widget instance.
	 */
	public function widget( $args, $instance ) {
		$current_taxonomy = $this->_get_current_taxonomy( $instance );
        $current_category = [];
        $terms = get_terms($current_taxonomy);
        $prefix_field = $this->build_checkbox_name($current_taxonomy);
        $keys = array_keys($instance);
        foreach ($keys as $key)
        {
            if(strpos($key,$prefix_field)!== 0)
                continue;
            if($instance[$key] !== 'yes')
                continue;
            $current_cat_slug = substr($key,strlen($prefix_field));
            $term = get_term_by('slug',$current_cat_slug,$current_taxonomy);
            if(!$term instanceof WP_Term)
                continue;
            $current_category[] = $term->term_id;
        }
        $exclude_term = [];
        if(!empty($current_category))
        {
            foreach ($terms as $term)
            {
                if(!in_array($term->term_id,$current_category))
                    $exclude_term[] = $term->term_id;
            }
        }

		if ( ! empty( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			if ( 'category' === $current_taxonomy ) {
				$title = esc_html__( 'Categories','melokids' );
			} else {
				$tax = get_taxonomy( $current_taxonomy );
				$title = $tax->labels->name;
			}
		}

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$c = ! empty( $instance['count'] ) ? '1' : '0';
		$h = ! empty( $instance['hierarchical'] ) ? '1' : '0';

		echo wp_kses_post($args['before_widget']);

		if ( $title ) {
			echo wp_kses_post($args['before_title']) . esc_html($title) . wp_kses_post($args['after_title']);
		}

		$cat_args = array(
			'orderby'      => 'name',
			'show_count'   => $c,
			'hierarchical' => $h,
			'taxonomy'	   => $current_taxonomy
		);
		if(!empty($exclude_term))
		    $cat_args['exclude']= $exclude_term;
?>
		<ul>
<?php
		$cat_args['title_li'] = '';

		/**
		 * Filters the arguments for the Categories widget.
		 *
		 * @since 2.8.0
		 * @since 4.9.0 Added the `$instance` parameter.
		 *
		 * @param array $cat_args An array of Categories widget options.
		 * @param array $instance Array of settings for the current widget.
		 */
		wp_list_categories( apply_filters( 'widget_categories_args', $cat_args, $instance ) );
?>
		</ul>
<?php

		echo wp_kses_post($args['after_widget']);
	}

	/**
	 * Handles updating settings for the current Categories widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $new_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['count'] = !empty($new_instance['count']) ? 1 : 0;
		$instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
		$instance['taxonomy'] = $new_instance['taxonomy'];
		return $instance;
	}

	/**
	 * Outputs the settings form for the Categories widget.
	 *
	 * @since 2.8.0
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'widget_categories' => array()) );
		$title = sanitize_text_field( $instance['title'] );
		$count = isset($instance['count']) ? (bool) $instance['count'] :false;
		$hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;

		$taxonomies = get_taxonomies( array( 'show_tagcloud' => true ), 'object' );
		$current_taxonomy = $this->_get_current_taxonomy($instance);

		$id = $this->get_field_id( 'taxonomy' );
		$name = $this->get_field_name( 'taxonomy' );


		?>
		<p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e( 'Title:','melokids' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<?php 
			printf(
				'<p><label for="%1$s">%2$s</label>' .
				'<select class="widefat" id="%1$s" name="%3$s">',
				$id,
				esc_html__( 'Taxonomy:', 'melokids' ),
				$name
			);

			foreach ( $taxonomies as $taxonomy => $tax ) {
				printf(
					'<option value="%s"%s>%s</option>',
					esc_attr( $taxonomy ),
					selected( $taxonomy, $current_taxonomy, false ),
					$tax->labels->name
				);
			}

			echo '</select></p>';

			foreach ( $taxonomies as $taxonomy => $tax ) {
				printf(
					'<p for="%s"> - <b>%s</b> %s %s %s</p>',
					esc_attr( $taxonomy ),
					$tax->labels->name,
					esc_html__('( Choose the','melokids'),
					$tax->labels->name,
					esc_html__('you want to show. Leave Blank to show all! )','melokids')
				);
				$terms = get_terms($tax->name);
				if(count($terms) < 1)
                {
                    ?><i><?php esc_html_e('Empty Taxonomy!','melokids'); ?></i><?php
                    ?><br><?php
                }
                else
                {
                    ?><table><?php
                    $index = 1;
                    foreach($terms as $term){
                        if($index % 2 == 1)
                        {
                            ?><tr><?php
                        }
                        $field_value = $this->build_checkbox_name($tax,$term);
                        $field_name = $this->get_field_name($field_value);
                        $field_id = $this->get_field_id($field_value);
                        ?>
                        <td>
                            <input type="checkbox" id="<?php echo esc_attr($field_id)?>"
                                   name="<?php echo esc_attr($field_name)?>" value="yes"
                                <?php if(isset($instance[$field_value]) && $instance[$field_value] =='yes' ) checked(1,1); ?> />
                            <label for="<?php echo esc_attr($field_id)?>">
                                <?php echo esc_html($term->name)?>
                            </label>
                        </td>
                        <?php
                        if($index++ % 2 == 0 )
                        {
                            ?></tr><?php
                        }
                    }
                    ?></table><?php
                }

			}
		?>
	    <h3><?php esc_attr_e('Other Options','melokids')?></h3>
		<input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('count')); ?>" name="<?php echo esc_attr($this->get_field_name('count')); ?>"<?php checked( $count ); ?> />
		<label for="<?php echo esc_attr($this->get_field_id('count')); ?>"><?php esc_html_e( 'Show post counts','melokids' ); ?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('hierarchical')); ?>" name="<?php echo esc_attr($this->get_field_name('hierarchical')); ?>"<?php checked( $hierarchical ); ?> />
		<label for="<?php echo esc_attr($this->get_field_id('hierarchical')); ?>"><?php esc_html_e( 'Show hierarchy','melokids' ); ?></label></p>
		<?php
	}
	/**
	 * Retrieves the taxonomy for the current Tag cloud widget instance.
	 *
	 * @since 4.4.0
	 *
	 * @param array $instance Current settings.
	 * @return string Name of the current taxonomy if set, otherwise 'post_tag'.
	 */
	function build_checkbox_name($tax,$term = '')
    {
        if($tax instanceof WP_Taxonomy)
            $tax_slug = $tax->name;
        else
            $tax_slug = $tax;
        if($term instanceof WP_Term)
            $term_slug = $term->slug;
        else
            $term_slug = $term;
        return 'checkbox_'.$tax_slug.'_'.$term_slug;
    }
	public function _get_current_taxonomy($instance) {
		if ( !empty($instance['taxonomy']) && taxonomy_exists($instance['taxonomy']) )
			return $instance['taxonomy'];

		return 'category';
	}

}
