<?php
/**
 *
 * This is the template that displays page layout
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
get_header();
?><div <?php melokids_content_atts();?>><?php
    while ( have_posts() ) : the_post();
        get_template_part( 'template-parts/single/content', get_post_format() );
        /* author info */
        melokids_author_info();
        /* Next / Prev */
        melokids_single_post_nav();
        
        /*If comments are open or we have at least one comment, load up the comment template.*/
        melokids_comment();

        // Comment form 
        melokids_comment_respond();
        
    endwhile;
?></div><?php
    get_sidebar();
?><div class="single-post-bottom col-12"><?php 
	while ( have_posts() ) : the_post();
        /* Related */
        melokids_post_related();
    endwhile;
?></div>
<?php
get_footer();