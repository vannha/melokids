<?php
function melokids_instagram( $username ) {
    global $wp_version;
    $instagram_api_key = melokids_get_opts('instagram_api_key','6500395100.1677ed0.96ebe958c36346fca373fd4ed7016e47');
    $user_id = explode('.', $instagram_api_key)[0];
    
    $proxies = array(
        'https://boomproxy.com/browse.php?u=',
        'https://us.hidester.com/proxy.php?u=',
        'https://proxy-us1.toolur.com/browse.php?u=',
        'https://proxy-fr1.toolur.com/browse.php?u=',
    );
    $username = trim( strtolower( $username ) );
    switch ( substr( $username, 0, 1 ) ) {
        case '#':
            $url              = 'https://www.instagram.com/explore/tags/' . str_replace( '#', '', $username ) . '?__a=1';
            $transient_prefix = 'h';
            break;
        default:
            $url              = 'https://www.instagram.com/' . str_replace( '@', '', $username ) . '?__a=1';
            $transient_prefix = 'u';
            break;
    }
    if ( $proxy = apply_filters( 'wpiw_proxy', false ) ) {
        $url = $proxies[ array_rand( $proxies ) ] . urlencode( $url );
    }
    $instagram = get_transient( 'wpiw-01-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ) );
    if ( false === $instagram || empty($instagram[0]['thumbnail']) ) {
        if(empty($instagram_api_key)){
            $remote = wp_remote_get( $url, array(
                'user-agent' => 'Instagram/' . $wp_version . '; ' . home_url()
            ) );
        } else {
            $remote = wp_remote_get("https://api.instagram.com/v1/users/".$user_id."/media/recent/?access_token=".$instagram_api_key, true);
        }

        if ( is_wp_error( $remote ) ) {
            return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'wp-instagram-widget' ) );
        }
        if ( 200 !== wp_remote_retrieve_response_code( $remote ) ) {
            return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'wp-instagram-widget' ) );
        }

        $insta_array = json_decode( $remote['body'], true );

        if ( ! $insta_array ) {
            return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data1.', 'wp-instagram-widget' ) );
        }

        if ( isset( $insta_array['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
            $images = $insta_array['graphql']['user']['edge_owner_to_timeline_media']['edges'];
        } elseif ( isset( $insta_array['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
            $images = $insta_array['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
        } elseif(isset($insta_array['data'])){
            $images = $insta_array['data'];
        } else {
            return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data2.', 'wp-instagram-widget' ) );
        }
        if ( ! is_array( $images ) ) {
            return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data3.', 'wp-instagram-widget' ) );
        }
        $instagram = array();
        if(empty($instagram_api_key)) {
            foreach ( $images as $image ) {
                if ( true === $image['node']['is_video'] ) {
                    $type = 'video';
                } else {
                    $type = 'image';
                }
                $caption = __( 'Instagram Image', 'wp-instagram-widget' );
                if ( ! empty( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'] ) ) {
                    $caption = wp_kses( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'], array() );
                }
                $instagram[] = array(
                    'description' => $caption,
                    'link'        => trailingslashit( '//www.instagram.com/p/' . $image['node']['shortcode'] ),
                    'time'        => $image['node']['taken_at_timestamp'],
                    'comments'    => $image['node']['edge_media_to_comment']['count'],
                    'likes'       => $image['node']['edge_liked_by']['count'],
                    'thumbnail'   => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][0]['src'] ),
                    'small'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][2]['src'] ),
                    'large'       => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][4]['src'] ),
                    'original'    => preg_replace( '/^https?\:/i', '', $image['node']['display_url'] ),
                    'type'        => $type,
                );
            } // End foreach().
        } else {
            foreach ($images as $image) {
                $image['link']                          = preg_replace( "/^http:/i", "", $image['link'] );
                $image['images']['thumbnail']           = preg_replace( "/^http:/i", "", $image['images']['thumbnail'] );
                $image['images']['small']               = preg_replace( "/^http:/i", "", $image['images']['thumbnail'] );
                $image['images']['standard_resolution'] = preg_replace( "/^http:/i", "", $image['images']['standard_resolution'] );
                $image['images']['original']            = preg_replace( "/^http:/i", "", $image['images']['standard_resolution'] );

                $instagram[] = array(
                    'description'   => $image['caption']['text'],
                    'link'          => $image['link'],
                    'time'          => $image['created_time'],
                    'comments'      => $image['comments']['count'],
                    'likes'         => $image['likes']['count'],
                    'thumbnail'     => $image['images']['thumbnail'],
                    'small'         => $image['images']['small'],
                    'large'         => $image['images']['standard_resolution'],
                    'original'      => $image['images']['original'],
                    'type'          => $image['type']
                );
            }
        }
        // do not set an empty transient - should help catch private or empty accounts. Set a shorter transient in other cases to stop hammering Instagram
        if ( ! empty( $instagram ) ) {
            $instagram = base64_encode( serialize( $instagram ) );
            set_transient( 'wpiw-01-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * 3 ) );
        } else {
            $instagram = base64_encode( serialize( array() ) );
            set_transient( 'wpiw-01-' . $transient_prefix . '-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', MINUTE_IN_SECONDS * 10 ) );
        }
    }
    if ( ! empty( $instagram ) ) {
        return unserialize( base64_decode( $instagram ) );
    } else {
        return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'wp-instagram-widget' ) );
    }
}

function melokids_instsgram_images_only( $media_item ) {

    if ( 'image' === $media_item['type'] ) {
        return true;
    }

    return false;
}