<?php
/**
 * Dequeue script/ style from newsletter plugin.
 *
 * Hooked to the wp_enqueue_scripts action, with a late priority (100),
 * so that it is after the script was enqueued.
 */
function melokids_newsletter_dequere_scripts()
{
    /* Remove Newsletter subscription style*/
    wp_dequeue_style('newsletter');
    wp_deregister_style('newsletter');
}

add_action('wp_enqueue_scripts', 'melokids_newsletter_dequere_scripts', 100);