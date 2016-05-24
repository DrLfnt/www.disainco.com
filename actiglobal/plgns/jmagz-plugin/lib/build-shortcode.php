<?php

function jeg_relatedpost($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'class' => '',
            'size' => 6
        ),
        $atts
    );

    $isempty = false;

    $html = '';
    $html .=
        '<aside class="aside-post">
                <h6 class="aside-heading">' . __('People Also Read', 'jmagz-plugin') . '</h6>
                    <div class="aside-post-list">';

    $posttype = get_post_type();
    if($posttype === 'post') {
        $category_ids = array();
        if ( has_category() ) {
            $categories = get_the_category();
            foreach( $categories as $individual_category ) $category_ids[] = $individual_category->term_id;
        }

        $args = array(
            'category__in'        => $category_ids,
            'showposts'           => $atts['size'],
            'ignore_sticky_posts' => 1,
            'post__not_in'        => array(get_the_ID())
        );

        add_filter('posts_where', 'filter_where_prev');
        $the_query = new WP_Query( $args );
        remove_filter( 'posts_where', 'filter_where_prev');
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) :
                $the_query->the_post();
                $html .= '<a href="' . get_permalink(get_the_ID()) . '" class="post-title">' . get_the_title() . '</a>';
            endwhile;
        } else {
            $isempty = true;
        }
        wp_reset_postdata();

    } else if ($posttype === 'review') {
        $category_ids = array();
        $reviewcategory = get_the_terms(get_the_ID(), 'review-category');
        foreach( $reviewcategory as $revcat ) $category_ids[] = $revcat->term_id;

        $statement = array(
            'post_type'             => 'review',
            'post_status'			=> array('publish'),
            'showposts'             => $atts['size'],
            'post__not_in'          => array(get_the_ID())
        );

        if(!empty($category_ids)) {
            $statement['tax_query'][] = array(
                'taxonomy' => 'review-category',
                'terms' => $category_ids,
                'field' => 'id',
            );
        }

        $the_query = new WP_Query( $statement );
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) :
                $the_query->the_post();
                $html .= '<a href="' . get_permalink(get_the_ID()) . '" class="post-title">' . get_the_title() . '</a>';
            endwhile;
        } else {
            $isempty = true;
        }
        wp_reset_postdata();
    }

    $html .= "</div>
        </aside>";

    if($isempty) {
        return null;
    } else {
        return $html;
    }
}

add_shortcode('related' , 'jeg_relatedpost');

/** row fluid **/
function jeg_row($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'class' => '',
        ),
        $atts
    );

    return "<div class='row clearfix {$atts['class']}'>"
    . do_shortcode($content) .
    "</div>";
}

add_shortcode('row' , 'jeg_row');

/** column */
function jeg_column($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'size' => '',
            'offset' => '0',
            'class' => '',
        ),
        $atts
    );

    return "<div class='col-md-{$atts['size']} {$atts['class']} col-xs-offset-{$atts['offset']}'>"
    . do_shortcode($content) .
    "</div>";
}

add_shortcode('column' , 'jeg_column');

/** intro */
function jeg_intro($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'class' => '',
        ),
        $atts
    );

    return "<p class='intro-text {$atts['class']}'>"
    . do_shortcode($content) .
    "</p>";
}

add_shortcode('intro' , 'jeg_intro');

/** dropcaps **/
function jeg_dropcap($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'class' => '',
        ),
        $atts
    );

    return '<span class="dropcaps ' . $atts['class'] . '">' . do_shortcode($content) . '</span>';
}

add_shortcode('dropcap' , 'jeg_dropcap');

/** pull quote **/
function jeg_pullquote($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'position' => '',
            'class' => '',
        ),
        $atts
    );

    return '<blockquote class="pullquote-' . $atts['position'] . ' ' . $atts['class'] . '">
                <span>' . do_shortcode($content) . '</span>
            </blockquote>';
}

add_shortcode('pullquote' , 'jeg_pullquote');


/** Highlight **/
function jeg_highlight($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'text_color' => 'fff',
            'bg_color' => '000',
            'class' => '',
        ),
        $atts
    );

    return "<span class='highlight {$atts['class']}' style='background-color: {$atts['bg_color']}; color: {$atts['text_color']};'>" . do_shortcode($content) . "</span>";
}

add_shortcode('highlight' , 'jeg_highlight');

/** tooltip **/
function jeg_tooltip($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'text' => '',
            'url' => '',
            'class' => '',
        ),
        $atts
    );

    return "<a data-original-title='{$atts['text']}' href='{$atts['url']}' data-toggle='tooltip' data-animation='fade' class=' {$atts['class']}'>" . do_shortcode($content) . "</a>";
}

add_shortcode('tooltip' , 'jeg_tooltip');


/** spacing **/

function jeg_spacing($atts) {
    $atts = shortcode_atts(
        array(
            'size' => '10',
            'class' => '',
        ),
        $atts
    );

    return "<div class='clearfix {$atts['class']}' style='padding-bottom: {$atts['size']}px'></div>";
}

add_shortcode('spacing' , 'jeg_spacing');


/** single icon */
function jeg_singleicon($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'id' 			=> '',
            'color'			=> '',
            'size'			=> '',
            'class' 		=> ''
        ),
        $atts
    );

    $additionalstyle = '';

    if(!empty($atts['color'])) 	$additionalstyle .=  "color : {$atts['color']};";
    if(!empty($atts['size'])) 	$additionalstyle .=  "font-size : {$atts['size']}em;";


    return "<i class='fa {$atts['class']} {$atts['id']}' style='{$additionalstyle}'></i>";
}

add_shortcode('singleicon', 'jeg_singleicon');


/** icon list wrapepr */
function jeg_iconlistwrapper($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'class' 		=> ''
        ),
        $atts
    );
    return "<ul class='fa-ul {$atts['class']}'>" . do_shortcode($content) . "</ul>";
}

add_shortcode('iconlistwrapper', 'jeg_iconlistwrapper');


/** icon list */
function jeg_iconlist($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'class' 		=> '',
            'id' 			=> '',
            'spin'			=> '',
            'color'			=> '',
        ),
        $atts
    );

    $additionalstyle = '';
    if(!empty($atts['color'])) 	$additionalstyle .=  "color : {$atts['color']};";

    $spinclass = '';
    if($atts['spin'] === 'true') $spinclass = 'fa-spin';

    return "<li><i class='fa fa-fw {$spinclass} {$atts['id']}' style='$additionalstyle'></i> " . do_shortcode($content) . "</li>";
}

add_shortcode('iconlist', 'jeg_iconlist');


/** googlemap **/
function jeg_googlemap($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'title' => '',
            'lat' => '',
            'lng' => '',
            'zoom' => '14',
            'ratio' => '0.1',
            'popup' => '',
            'class' => '',
        ),
        $atts
    );

    return
        "<div id='" . uniqid() . "' class='jrmap {$atts['class']}' data-lat='{$atts['lat']}' data-lng='{$atts['lng']}' data-zoom='{$atts['zoom']}' data-ratio='{$atts['ratio']}' data-showpopup='{$atts['popup']}' data-title='{$atts['title']}'><div class='contenthidden'>"
        . do_shortcode($content) .
        "</div></div>";
}

add_shortcode('googlemap' , 'jeg_googlemap');



/** alert  **/
function jeg_alert ($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'type' => 'success',
            'main_text' => '',
            'second_text' => '',
            'show_close' => 'false',
            'class' => '',
        ),
        $atts
    );

    $closebutton = '';
    if($atts['show_close'] === 'true') $closebutton = "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";

    return
        "<div class='{$atts['class']} alert alert-{$atts['type']} alert-dismissable'>
		{$closebutton}
		<strong>{$atts['main_text']}</strong> {$atts['second_text']}
	</div>";
}

add_shortcode('alert' , 'jeg_alert');


/** alert  **/
function jeg_button ($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'type' => 'default',
            'text' => '',
            'url' => '#',
            'open_new_tab' => 'false',
            'class' => '',
        ),
        $atts
    );


    $target = '';
    if($atts['open_new_tab'] === 'true') $target = 'target="_blank"';

    return
        "<a href='{$atts['url']}' {$target} class='btn {$atts['class']} btn-{$atts['type']}'>{$atts['text']}</a>";
}

add_shortcode('button' , 'jeg_button');



/*** accordion ***/
$panelgroupid = 0;
$uniqueid = 0;
function jeg_accordion ($atts, $content = null) {
    global $panelgroupid;
    $panelgroupid = $panelgroupid + 1;

    $atts = shortcode_atts(
        array(
            'class' => '',
        ),
        $atts
    );

    return"<div class='panel-group {$atts['class']}' id='panel_group_" . $panelgroupid  . "'>" . do_shortcode($content) . "</div>";
}

add_shortcode('accordion' , 'jeg_accordion');



/*** accordion element ***/
function jeg_accordion_element ($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'title' => 'Accordion Title',
            'collapsed' => 'false',
            'class' => '',
        ),
        $atts
    );
    global $panelgroupid;
    global $uniqueid;
    $uniqueid = $uniqueid + 1;
    $collapsed = ( $atts['collapsed'] === 'true' ) ? "in" : "";

    return
        "<div class='panel panel-default {$atts['class']}'>
		<div class='panel-heading'>
	  		<h4 class='panel-title'>
	    		<a class='accordion-toggle' data-toggle='collapse' data-parent='#panel_group_{$panelgroupid}' href='#accordion_{$uniqueid}'>
	      			{$atts['title']}
	    		</a>
	  		</h4>
		</div>
		<div id='accordion_{$uniqueid}' class='panel-collapse collapse {$collapsed}'>
  			<div class='panel-body'>
    			" . do_shortcode($content) . "
			</div>
		</div>
  	</div>";
}

add_shortcode('accordion-element' , 'jeg_accordion_element');




/** tab heading wrapper **/

function jeg_tab_heading_wrapper ($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'class' => '',
        ),
        $atts
    );
    return"<ul class='nav nav-tabs {$atts['class']}'>" . do_shortcode($content) . "</ul>";
}

add_shortcode('tab-heading-wrapper' , 'jeg_tab_heading_wrapper');



/** tab heading  **/

function jeg_tab_heading ($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'id' => '',
            'active' => 'false',
            'title' => '',
        ),
        $atts
    );

    $active = ( $atts['active'] === 'true' ) ? "active" : "";

    return
        "<li class='{$active }'><a href='#{$atts['id']}' data-toggle='tab'>{$atts['title']}</a></li>";
}

add_shortcode('tab-heading' , 'jeg_tab_heading');



/** tab content wrapper **/

function jeg_tab_content_wrapper ($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'class' => '',
        ),
        $atts
    );
    return"<div class='tab-content {$atts['class']}'>" . do_shortcode($content) . "</div>";
}

add_shortcode('tab-content-wrapper' , 'jeg_tab_content_wrapper');



/** tab content **/

function jeg_tab_content ($atts, $content = null) {
    $atts = shortcode_atts(
        array(
            'id' => '',
            'active' => 'false',
        ),
        $atts
    );

    $active = ( $atts['active'] === 'true' ) ? " in active " : "";

    return
        "<div class='tab-pane fade {$active}' id='{$atts['id']}'><p>" . do_shortcode($content) . "</p></div>";
}

add_shortcode('tab-content' , 'jeg_tab_content');



remove_shortcode('gallery');
add_shortcode('gallery', 'jeg_gallery_shortcode');
function jeg_gallery_shortcode( $attr ) {
    $post = get_post();

    static $instance = 0;
    $instance++;

    if ( ! empty( $attr['ids'] ) ) {
        // 'ids' is explicitly ordered, unless you specify otherwise.
        if ( empty( $attr['orderby'] ) ) {
            $attr['orderby'] = 'post__in';
        }
        $attr['include'] = $attr['ids'];
    }

    /**
     * Filter the default gallery shortcode output.
     *
     * If the filtered output isn't empty, it will be used instead of generating
     * the default gallery template.
     *
     * @since 2.5.0
     *
     * @see gallery_shortcode()
     *
     * @param string $output The gallery output. Default empty.
     * @param array  $attr   Attributes of the gallery shortcode.
     */
    $output = apply_filters( 'post_gallery', '', $attr );
    if ( $output != '' ) {
        return $output;
    }

    $html5 = current_theme_supports( 'html5', 'gallery' );
    $atts = shortcode_atts( array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post ? $post->ID : 0,
        'itemtag'    => $html5 ? 'figure'     : 'dl',
        'icontag'    => $html5 ? 'div'        : 'dt',
        'captiontag' => $html5 ? 'figcaption' : 'dd',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => '',
        'link'       => '',
        'jmagzslider' => ''
    ), $attr, 'gallery' );

    if(vp_option('joption.enable_image_zoom', '1')) {
        $atts['link'] = 'file';
    }

    $id = intval( $atts['id'] );

    if ( ! empty( $atts['include'] ) ) {
        $_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( ! empty( $atts['exclude'] ) ) {
        $attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
    } else {
        $attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
    }

    if ( empty( $attachments ) ) {
        return '';
    }

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment ) {
            $output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
        }
        return $output;
    }

    $itemtag = tag_escape( $atts['itemtag'] );
    $captiontag = tag_escape( $atts['captiontag'] );
    $icontag = tag_escape( $atts['icontag'] );
    $valid_tags = wp_kses_allowed_html( 'post' );
    if ( ! isset( $valid_tags[ $itemtag ] ) ) {
        $itemtag = 'dl';
    }
    if ( ! isset( $valid_tags[ $captiontag ] ) ) {
        $captiontag = 'dd';
    }
    if ( ! isset( $valid_tags[ $icontag ] ) ) {
        $icontag = 'dt';
    }

    $columns = intval( $atts['columns'] );
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";

    $gallery_style = '';

    if($atts['jmagzslider']) {

        $output .= '<div class="gallery-slider-wrapper ' . $selector . '">
                        <div class="gallery-slider" itemscope itemtype="http://schema.org/ImageGallery">';

        foreach ( $attachments as $id => $attachment ) {
            $imagebig = apply_filters('jeg_get_image_attachment', null, $attachment->ID, 'large');
            $output .=
                '<figure class="slide" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                    <a itemprop="contentUrl" href="' . $attachment->guid . '">
                        <img itemprop="thumbnail" class="lazyOwl" src="' . JMAGZ_PLUGIN_URL . '/assets/placeholder/900x450.png" data-src="' . $imagebig . '" alt="' . $attachment->post_title . '">
                    </a>
                    <figcaption itemprop="caption description" class="slide-caption">
                        ' . $attachment->post_excerpt . '
                    </figcaption>
                </figure>';
        }

        $output .= '</div>
                <div class="gallery-slider-thumbnail-wrapper">
                    <div class="gallery-slider-thumbnail">';

        foreach ( $attachments as $id => $attachment ) {
            $imagethumb = apply_filters('jeg_get_image_attachment', null, $attachment->ID, 'one-third-post-featured');
            $output .=
                '<div class="slide-thumbnail"><img class="lazyOwl" src="' . JMAGZ_PLUGIN_URL . '/assets/placeholder/150x75.png" data-src="' . $imagethumb . '" alt="' . $attachment->post_title . '"></div>';
        }

        $output .= '</div></div></div>';

    } else {
        /**
         * Filter whether to print default gallery styles.
         *
         * @since 3.1.0
         *
         * @param bool $print Whether to print default gallery styles.
         *                    Defaults to false if the theme supports HTML5 galleries.
         *                    Otherwise, defaults to true.
         */
        if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
            $gallery_style = "
            <style type='text/css'>
                #{$selector} {
                    margin: auto;
                }
                #{$selector} .gallery-item {
                    float: {$float};
                    margin-top: 10px;
                    text-align: center;
                    width: {$itemwidth}%;
                }
                #{$selector} img {
                    border: 2px solid #cfcfcf;
                }
                #{$selector} .gallery-caption {
                    margin-left: 0;
                }
                /* see gallery_shortcode() in wp-includes/media.php */
            </style>\n\t\t";
        }

        $size_class = sanitize_html_class( $atts['size'] );
        $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

        /**
         * Filter the default gallery shortcode CSS styles.
         *
         * @since 2.5.0
         *
         * @param string $gallery_style Default CSS styles and opening HTML div container
         *                              for the gallery shortcode output.
         */
        $output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

        $i = 0;
        foreach ( $attachments as $id => $attachment ) {

            $attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
            if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
                $image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
            } elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
                $image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
            } else {
                $image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
            }
            $image_meta  = wp_get_attachment_metadata( $id );

            $orientation = '';
            if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
                $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
            }
            $output .= "<{$itemtag} class='gallery-item'>";
            $output .= "
                <{$icontag} class='gallery-icon {$orientation}'>
                    $image_output
                </{$icontag}>";
            if ( $captiontag && trim($attachment->post_excerpt) ) {
                $output .= "
                    <{$captiontag} class='wp-caption-text gallery-caption' id='$selector-$id'>
                    " . wptexturize($attachment->post_excerpt) . "
                    </{$captiontag}>";
            }
            $output .= "</{$itemtag}>";
            if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
                $output .= '<br style="clear: both" />';
            }
        }

        if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
            $output .= "
                <br style='clear: both' />";
        }

        $output .= "
            </div>\n";
    }

    return $output;
}
