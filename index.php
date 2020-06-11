<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
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
<div <?php melokids_content_atts();?>>
    <?php
        if ( have_posts() ) :
            do_action('melokids_loop_start');
                while ( have_posts() ) : the_post();
                    get_template_part( 'template-parts/loop/content', $layout );
                endwhile;
            do_action('melokids_loop_end');
            
            melokids_posts_pagination();

        else :
            get_template_part( 'template-parts/content', 'none' );
        endif; 
    ?>
</div>
<?php
    get_sidebar();
get_footer();



