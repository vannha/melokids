<?php
    wp_enqueue_style('animate-css');
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );

    $username      = melokids_get_opts('instagram_api_username');
    $limit         = $number;
    $target        = $target;
    $size          = $size;
    $columns_space = $columns_space;

    switch ($columns) {
        case '1':
            $span = "col-12";
            break;
        case '2':
            $span = "col-6";
            break;
        case '3':
            $span = "col-4";
            break;
        case '4':
            $span = "col-3";
            break;
        case '6':
            $span = "col-2";
            break;
        case '12':
            $span = "col-1";
            break;
        case '7':
            $span = "col-1/7";
            break;
        case 'auto':
            $span = "col";
            break;
        default:
            $span = "col-4";
    }

    if ($username != '') {
        $media_array = melokids_instagram($username);
        if ( is_wp_error($media_array) ) {
           echo esc_html($media_array->get_error_message());
        } else {
            // filter for images only?
            if ( $images_only = apply_filters( 'melokids_instagram_images_only', false ) )
                $media_array = array_filter( $media_array, array( $this, 'melokids_instsgram_images_only' ) );
            
            $media_array = array_slice( $media_array, 0, $limit );
            ?>
            <div class="<?php echo trim(implode(' ', array('zk-instagram', $class))); ?>">
                <?php if ($show_author) {
                    ?><div class="user text-center">
                        <a href="//instagram.com/<?php echo trim($username); ?>" target="<?php echo esc_attr( $target ); ?>"><?php if(!empty($author_text)) echo '<span class="author-text">'.esc_html($author_text).'</span><span class="name">@'.esc_html($username).'</span>'; ?></a></div><?php
                } ?>
                <div class="row gutters-<?php echo esc_attr($columns_space);?> clearfix">
                <?php foreach ($media_array as $item) { ?>
                    <div class="<?php echo trim(implode(' ', array('instagram-item', $span, 'overlay-wrap', 'text-center')));?>">
                        <a href="<?php echo esc_url( $item['link'] ); ?>" target="<?php echo esc_attr( $target );?>">
                            <img src="<?php echo (is_array($item[$size])) ? esc_url($item[$size]['url']) : esc_url($item[$size]) ;?>" alt="<?php echo esc_attr($item['description']);?>" />
                        </a>
                        <a href="<?php echo esc_url( $item['link'] );?>" target="<?php echo esc_attr( $target );?>" class="overlay d-flex align-items-center animated zoomOut" data-animation-in="zoomIn" data-animation-out="zoomOut">
                            <div class="overlay-inner col-12 text-center">
                                <?php if(!$show_like && !$show_comments) :?><span class="d-block"  target="<?php echo esc_attr( $target );?>"><span class="fa fa-instagram"></span></span><?php endif; ?>
                                <?php if( $show_like):?><span class="like"><span class="fa fa-heart-o"></span>&nbsp;<?php echo esc_html($item['likes']);?></span><?php endif; ?>
                                <?php if( $show_comments):?><span class="comments"><span class="fa fa-comments-o"></span>&nbsp;<?php echo esc_html($item['comments']);?></span><?php endif; ?>
                            </div>
                        </a>
                    </div>
                <?php } ?>
                </div>
            </div>
            <?php
        }
    }