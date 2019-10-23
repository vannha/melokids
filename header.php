<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="zk-page">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ZookaStudio
 * @subpackage MeloKids
 * @since 1.0.0
 * @author Chinh Duong Manh
 *
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); melokids_body_atts(); ?>>
	<?php do_action('melokids_before_main_content'); ?>
	<div <?php melokids_page_atts();?>><?php
			if(function_exists('melokids_header_banner')) melokids_header_banner();
			if(function_exists('melokids_header_top')) melokids_header_top();
			melokids_header();
			melokids_page_title();
		?><main <?php melokids_main_atts();?>>
			<div class="row">