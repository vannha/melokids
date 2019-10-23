<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package ZookaStudio
 * @subpackage MeloKids
 * @since 1.0.0
 * @author Chinh Duong Manh
 *
 */
get_header(); ?>
<div id="content-area" class="col-12">
    <h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'melokids' ); ?></h1>
    <div class="page-content">
		<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'melokids' ); ?></p>

		<?php get_search_form(); ?>
	</div>
</div>
<?php
get_footer();