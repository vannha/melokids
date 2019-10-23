<?php
/**
 * Custom output HTML of some widget 
*/

/** 
 * Custom Widget Archive 
 * This code filters the Archive widget to include the post count inside the link 
 * @since 1.0.0
*/
if(!function_exists('melokids_archive_count_span')){
	add_filter('get_archives_link', 'melokids_archive_count_span');
	function melokids_archive_count_span($links) {
	    $dir = is_rtl() ? 'left' : 'right';
	    $links = str_replace('</a>&nbsp;(', ' <span class="count '.$dir.'">(', $links);
	    $links = str_replace(')</li>', ')</span></a></li>', $links);
	    return $links;
	}
}

/**
 * Widget Tag Cloud
 * Change separator text, font size, ...
 * Hook filter: widget_tag_cloud_args
*/
if(!function_exists('melokids_widget_tag_cloud_args')){
	add_filter('widget_tag_cloud_args', 'melokids_widget_tag_cloud_args');
	function melokids_widget_tag_cloud_args($args){
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