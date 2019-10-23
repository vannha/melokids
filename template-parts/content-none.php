<?php
/**
 * The template for displaying a "No posts found" message
 *
 *
 * @package ZookaStudio
 * @subpackage MeloKids
 * @since 1.0.0
 * @author Chinh Duong Manh
 *
 */
?>
<article class="no-results not-found">
	<h2 class="entry-title"><?php esc_html_e( 'Nothing Found', 'melokids' ); ?></h2>
	<div class="entry-content">
		<p><?php esc_html_e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'melokids' ); ?></p>
		<?php get_search_form(); ?>
	</div>
</article>