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
$has_media = melokids_format_opts_value();
if($has_media)
	$class = 'col-md-8 col-xl-7';
else 
	$class = 'col-12';
?>
<article class="entry-list row overlay-wrap hoverdir-wrap hoverdir-swing"><?php
	if($has_media) {
		echo '<div class="col-md-4 col-xl-5">'; melokids_entry_media(['size' => 'medium']); echo '</div>';
	}
	?><div class="<?php echo esc_attr($class);?>"><?php 
		melokids_entry_header(['meta' => 'before', 'meta_args' => [
			//'date_icon' => '', 
			//'author_icon' => '', 
			//'cat_icon' => '', 
			//'cmt_icon' => '', 
			//'view_icon' => '',
			//'like_icon' => '',
			//'liked_icon' => '',
			//'share_icon' => ''
		] ]); 
		melokids_entry_excerpt();
		melokids_entry_tag();
		melokids_entry_readmore();
?></div></article>

