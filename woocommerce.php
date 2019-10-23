<?php
/**
 * The main template file to display WooCommerce Archive page
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 * @link https://docs.woocommerce.com/wc-apidocs/function-woocommerce_content.html
 *
 *
 * @package ZookaStudio
 * @subpackage MeloKids
 * @since 1.0.0
 * @author Chinh Duong Manh
 *
 */
$layout = melokids_get_opts('archive_content_layout','list');
get_header(); ?>
<div <?php melokids_content_atts(['class' => 'zk-wc-wrappers']);?>>
	<div class="zk-wc-loop">
	    <?php woocommerce_content(); ?>
	</div>
</div>
<?php
    get_sidebar();
get_footer();