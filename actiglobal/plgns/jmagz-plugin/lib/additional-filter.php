<?php


/** author social */
function jeg_add_author_socials( $contactmeta ) {
    $contactmeta['facebook'] = "Facebook";
    $contactmeta['twitter'] = "Twitter";
    $contactmeta['google'] = "Google";
    $contactmeta['linkedin'] = "Linkedin";
    return $contactmeta;
}
add_filter('user_contactmethods','jeg_add_author_socials',99);


/**
 * Upload Mime
 */
function jeg_add_custom_mime_types($mimes){
    return array_merge($mimes,array (
        'webm' => 'video/webm',
        'ico' 	=> 'image/vnd.microsoft.icon',
        'ttf'	=> 'application/octet-stream',
        'otf'	=> 'application/octet-stream',
        'woff'	=> 'application/x-font-woff',
        'svg'	=> 'image/svg+xml',
        'eot'	=> 'application/vnd.ms-fontobject'
    ));
}

add_filter('upload_mimes','jeg_add_custom_mime_types');


/**
 * Comment Extend
 */

class Jeg_Walker_Comment extends Walker_Comment {

    /**
     * Output a single comment.
     *
     * @access protected
     * @since 3.6.0
     *
     * @see wp_list_comments()
     *
     * @param object $comment Comment to display.
     * @param int    $depth   Depth of comment.
     * @param array  $args    An array of arguments.
     */
    protected function comment( $comment, $depth, $args ) {
        if ( 'div' == $args['style'] ) {
            $tag = 'div';
            $add_below = 'comment';
        } else {
            $tag = 'li';
            $add_below = 'div-comment';
        }
        ?>
        <<?php echo $tag; ?> <?php comment_class( $this->has_children ? 'parent' : '' ); ?> id="comment-<?php comment_ID(); ?>">
        <?php if ( 'div' != $args['style'] ) : ?>
            <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
        <?php endif; ?>
        <div class="comment-author vcard">
            <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
            <?php printf( __( '<cite class="fn">%s</cite> <span class="says">says:</span>', 'jmagz-plugin' ), get_comment_author_link() ); ?>
        </div>
        <?php if ( '0' == $comment->comment_approved ) : ?>
            <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' , 'jmagz-plugin') ?></em>
            <br />
        <?php endif; ?>

        <div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
                <?php echo human_time_diff(mysql2date('U',$comment->comment_date), current_time('timestamp') ) . __(' ago', 'jmagz-plugin') ?>
                </a><?php edit_comment_link( __( '(Edit)' , 'jmagz-plugin'), '&nbsp;&nbsp;', '' );
            ?>
        </div>

        <?php comment_text( get_comment_id(), array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

        <?php
        comment_reply_link( array_merge( $args, array(
            'add_below' => $add_below,
            'depth'     => $depth,
            'max_depth' => $args['max_depth'],
            'before'    => '<div class="reply">',
            'after'     => '</div>'
        ) ) );
        ?>

        <?php if ( 'div' != $args['style'] ) : ?>
            </div>
        <?php endif; ?>
    <?php
    }

}

/**
 * gallery extended
 */

function jeg_print_media_template() {
    ?>
    <script type="text/html" id="tmpl-jmagz-slider-gallery">
        <label class="setting">
            <div class="setting-slider-gallery">
                <span>Enable Jmagz Slider Gallery</span>
                <input type="checkbox" data-setting="jmagzslider" />
            </div>
            <em>All option above will be ignored except random order</em>
        </label>
    </script>

    <script>
        function do_execute_gallery(){
            if(typeof wp !== 'undefined') {
                _.extend(wp.media.gallery.defaults, {
                    jmagzslider: false
                });
                wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
                    template: function(view){
                        return wp.media.template('gallery-settings')(view)
                        + wp.media.template('jmagz-slider-gallery')(view);
                    }
                });
            }
        }

        function do_gallery(){
            setTimeout(function(){
                do_execute_gallery();
            }, 500);
        }

        jQuery(window).bind('load',function(){ do_gallery() });
        jQuery(document).bind('ready',function(){ do_gallery() });
    </script>
<?php
}

add_action('print_media_templates', 'jeg_print_media_template');

/**
 * insert ads
 */


add_filter( 'the_content', 'prefix_insert_post_ads' );
function prefix_insert_post_ads( $content ) {
    $enableads = vp_option('joption.enable_inline_content_ads', 0);
    if($enableads) {

        $adstype = vp_option('joption.inline_content_ads_type');
        $intsys = vp_option('joption.inline_content_ads_int_system', 0);
        if($adstype === 'googleads' && $intsys) {
            $position = array('center', 'right');

            $pnumber = explode( '<p>', $content );
            $maxparagraph = count($pnumber) - 1;
            $showrelated = vp_option('joption.show_related_post', 0);

            if($showrelated) {
                $minparagraph = 2;
            } else {
                $minparagraph = 0;
            }

            $randkey = array_rand( $position , 1 );
            $position = $position[$randkey];
            if($position === 'center') {
                $size = array(
                    'desktop' => array('728','90'),
                    'tab' => array('468','60'),
                    'phone' => array('320', '50')
                );
            } else if($position === 'right') {
                $size = array(
                    'desktop' => array('300','250'),
                    'tab' => array('300','250'),
                    'phone' => array('300', '250')
                );
                $maxparagraph = $maxparagraph - 3;
            }

            if($minparagraph <= $maxparagraph) {
                $adsposition = rand( $minparagraph, $maxparagraph );
                $ad_code = "<div class='inline_promotion_" . $position . "'>" . jeg_render_ads_int('inline_content_ads', $size) . "</div>";

                if ( is_single() && ! is_admin() ) {
                    return prefix_insert_after_paragraph($ad_code, $adsposition, $content);
                }
            }
        } else {
            $position = vp_option('joption.inline_content_ads_position', 'promotion_center');
            $ad_code = "<div class='inline_" . $position . "'>" . jeg_render_ads('inline_content_ads') . "</div>";

            $adsposition = vp_option('joption.inline_content_ads_paragraph', 3);
            if ( is_single() && ! is_admin() ) {
                return prefix_insert_after_paragraph( $ad_code, $adsposition, $content );
            }
        }
    }
    return $content;
}

function prefix_insert_after_paragraph( $insertion, $paragraph_id, $content ) {
    $begin_p = '</p>';
    $paragraphs = explode( $begin_p, $content );
    foreach ($paragraphs as $index => $paragraph) {
        if ( $paragraph_id == $index ) {
            $paragraphs[$index] .= $insertion;
        }
        if ( trim( $paragraph ) ) {
            $paragraphs[$index] .= $begin_p;
        }
    }
    return implode( '', $paragraphs );
}



/**
 * OG
 */
function jeg_fb_og() {
    $html = '';
    if(vp_option('joption.enable_og_content', 0)) {
        $posttype = get_post_type(get_the_ID());
        // Title
        $html .= "<meta property=\"og:title\" content=\"" . get_the_title() . "\" />\n";
        // site name
        $html .= "<meta property=\"og:site_name\" content=\"" . get_bloginfo('name') . ' - ' . get_bloginfo('description') . "\" />\n";
        // url
        $html .= "<meta property=\"og:url\" content=\"" . get_permalink() . "\" />\n";
        // image
        $imgsrc = apply_filters('jeg_get_image_attachment', null, get_post_thumbnail_id(get_the_ID()), 'post-featured');
        if(empty($imgsrc)) {
            $websitelogo = get_theme_mod('website_logo', get_template_directory_uri() . '/public/img/logo.png');
            if(ctype_digit($websitelogo) || is_int($websitelogo)) {
                $websitelogo = wp_get_attachment_image_src($websitelogo, "full");
                $websitelogo = $websitelogo[0];
            }
            $imgsrc = $websitelogo;
        }
        $html .= "<meta property=\"og:image\" content=\"" . $imgsrc . "\" />\n";
        // fb app id
        $html .= "<meta property=\"fb:app_id\" content=\"" . vp_option('joption.og_app_id') . "\" />\n";
        // locale
        // $html .= "<meta property=\"og:locale\" content=\"" . get_bloginfo('language') . "\" />\n";
        // publisher
        $html .= "<meta property=\"article:publisher\" content=\"" . vp_option('joption.og_publisher') . "\" />\n";

        if($posttype == 'post' || $posttype == 'review') {
            // content
            $html .= "<meta property=\"og:description\" content=\"" . jeg_get_excerpt_by_id(get_the_ID()) . "\" />\n";
            // author
            $authorid = get_post_field( 'post_author', get_the_ID() );
            $html .= "<meta property=\"article:author\" content=\"" . get_the_author_meta( 'facebook' , $authorid ) . "\" />\n";
        }
    }
    echo $html;
}

add_action('wp_head', 'jeg_fb_og');

/** woocommerce number */
function jeg_shop_per_page() {
    return vp_option('joption.product_number', 12);
}

add_filter( 'loop_shop_per_page', 'jeg_shop_per_page', 20 );


/** additional rss feed */
function jeg_feed_request($qv) {
    if (isset($qv['feed']) && !isset($qv['post_type']))
        $qv['post_type'] = array('post', 'review');
    return $qv;
}
add_filter('request', 'jeg_feed_request');
