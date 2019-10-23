<?php
if(!function_exists('melokids_woocommerce_product_tag_cloud_widget_args')){
	add_filter('woocommerce_product_tag_cloud_widget_args','melokids_woocommerce_product_tag_cloud_widget_args');
	function melokids_woocommerce_product_tag_cloud_widget_args($args){
		$_args =[
			'smallest'  => '16',
			'largest'   => '16',
			'unit'      => 'px',
			'separator' => ''
		];
		$args = wp_parse_args($args, $_args);
		return $args;
	}
}

//add_filter('wp_generate_tag_cloud_data', 'melokids_wp_generate_tag_cloud_data');
function melokids_wp_generate_tag_cloud_data($tags_data){
	foreach ( $tags_data as $key => $tag_data ) {
		$tags_data[$key]['class'] .= ' wc-widget-filter';
	}
	return $tags_data;
}
