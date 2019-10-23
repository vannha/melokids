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
get_header();
?><div <?php melokids_content_atts();?>><?php
    while ( have_posts() ) : the_post();
    ?>
    <div class="row">
        <div class="col-md-8">
            <?php melokids_portfolio_gallery(['size' => 'large']); ?>
            <div class="single-content">
                <?php the_content(); ?>
            </div>
        </div>
        <div class="col-md-4">
            <?php melokids_portfolio_atts(); ?>
        </div>
    </div> 
    <div class="single-cmt">
        <?php melokids_comment(); ?>
    </div>    
    <?php
    endwhile;
    ?></div><?php
    get_sidebar();
get_footer();