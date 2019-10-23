<?php
/**
 * The default template for displaying content
 *
 * Used for single
 *
 * @package ZookaStudio
 * @subpackage MeloKids
 * @since 1.0.0
 * @author Chinh Duong Manh
 *
 */
if(is_page()){
	$sidebar_pos = melokids_get_opts('page_layout','right');
	$sidebar = melokids_get_opts('page_sidebar');
} else {
	$sidebar_pos = melokids_get_opts('single_layout','right');
	$sidebar = melokids_get_opts('single_sidebar');
}


if($sidebar_pos === 'full')
	$thumbnail_size = 'post-thumbnail';
else 
	if(is_active_sidebar($sidebar))
		$thumbnail_size = 'large';
	else 
		$thumbnail_size = 'post-thumbnail';
?>
<article <?php post_class(); ?>><?php 
	melokids_entry_header([
		'tag'       => 'h2', 
		'meta'      => 'before', 
		'class'     => 'text-center', 
		'meta_args' => [
			'show_share' => '0', 
			'class'      => 'justify-content-center',
			'date_icon'  => '' 
		] 
	]); 
	melokids_entry_media(['size' => $thumbnail_size,'default_overlay' => false]);
	melokids_entry_content();
	melokids_wp_link_pages();
	?>
	<div class="single-tags-share row justify-content-between align-items-center"><?php
		melokids_entry_tag(['class' => 'col-auto']);
		melokids_entry_share(['class' => 'col-auto']);
	?></div>
</article>
