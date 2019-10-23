<?php
/**
 * The default template for displaying content
 *
 * Used for loop content.
 *
 * @package ZookaStudio
 * @subpackage MeloKids
 * @author Chinh Duong Manh
 * @since 1.0.0
 *
 */
if(class_exists('VC_Manager')){
	$classes = ['zk-carousel-item hoverdir-wrap hoverdir-swing'];
} else {
	$classes = ['grid-item','col-md-6', 'col-lg-4', 'hoverdir-wrap hoverdir-swing'];
}
?>
<article class="<?php echo trim(implode(' ', $classes));?>"><?php 
	melokids_entry_media(['size' => 'medium']);
	melokids_entry_header([
		'meta'      => 'before',
		'meta_args' => [
			'show_date'   => '1',
			'date_icon'   => '',
			'show_cate'   => '',
			'show_author' => '',
			'show_cmt'    => '',
			'show_view'   => '',
			'show_like'   => '',
			'show_share'  => '',
			'class'       => 'justify-content-center'
		]
	]); 
	melokids_entry_readmore();
?></article>