<?php
/**
 * The Template for displaying single post/page/custom_post_type
 *
 * @package ZookaStudio
 * @subpackage MeloKids
 * @since 1.0.0
 * @author Chinh Duong Manh
 *
 */

$show_comment = melokids_get_opts('single_comment_list_form', '1');
        

get_header();
?><div <?php melokids_content_atts();?>><?php
    while ( have_posts() ) : the_post();
        get_template_part( 'template-parts/single/content', '' );
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
?><div class="single-post-bottom col-12 order-last"><?php 
    while ( have_posts() ) : the_post(); 
        /* Related */
        melokids_post_related();
    endwhile;
    ?></div>
<?php
get_footer();