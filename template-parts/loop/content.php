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
$grid_col = melokids_get_opts('archive_content_coloumn','2');
$classes =  ['entry-grid grid-item zk-hoverdir'];
$classes[] = 'col-md-'.round(12 / $grid_col);
?>
<article class="<?php echo trim(implode(' ', $classes));?>"><?php 
	melokids_entry_header(); 
	melokids_entry_media(['size' => 'medium']);
	melokids_entry_excerpt();
	melokids_entry_tag();
	melokids_entry_readmore();
?></article>