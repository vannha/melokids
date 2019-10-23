<?php
/**
 * Template Name: Page Builder
 *
 * This is the template that displays page layout with Visual Composer page builder
 *
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use
 * default template.
 *
 * @package ZookaStudio
 * @subpackage Tatz
 * @since 1.0.0
 * @author Chinh Duong Manh
 */
get_header(); ?>
<div <?php melokids_content_atts();?>>
<?php
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;
?></div>
<?php
    get_sidebar();
get_footer();