<?php
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );
    $shortcode_atts = array(
    	'limit="'.$limit.'"',
    	'columns="'.$columns.'"'
    );
    if($orderby === 'df') $orderby = '';
	if(!empty($orderby)) $shortcode_atts[]  = 'orderby="'.$orderby.'"';
	if(!empty($order)) $shortcode_atts[]    = 'order="'.$order.'"';
	if(!empty($paginate)) $shortcode_atts[] = 'paginate="'.$paginate.'"';
	if(!empty($el_class)) $shortcode_atts[] = 'class="'.$el_class.'"';

	if($product_show === 'featured') $shortcode_atts[] 		= 'visibility="featured"';
	if($product_show === 'on_sale') $shortcode_atts[] 		= 'on_sale="true"';
	if($product_show === 'best_selling') $shortcode_atts[] 	= 'best_selling="true"';
	if($product_show === 'top_rated') $shortcode_atts[] 	= 'top_rated="true"';
	//if(!empty($category)) $shortcode_atts[] 				= 'category="160"';

    echo do_shortcode('[products '. trim(implode(' ', $shortcode_atts)).']');