<?php

function jeg_vc_excerpt_latest_length(  )
{
    return 22;
}
add_filter( 'excerpt_length', 'jeg_vc_excerpt_latest_length', 999 );

function jeg_vc_excerpt_latest_more()
{
    return "...";
}

add_filter('excerpt_more', 'jeg_vc_excerpt_latest_more');

function vc_theme_vc_row($atts, $content) {
    $atts = shortcode_atts(array(
        'el_class' => '',
        'hide_border_bottom' => '',
        'dark_section' => '',
        'no_bottom_padding' => '',
    ), $atts);

    $additionalclass = '';

    if($atts['hide_border_bottom']) {
        $additionalclass .= ' hide_border_bottom ';
    }

    if($atts['dark_section']) {
        $additionalclass .= ' darksection ';
    }

    if($atts['no_bottom_padding']) {
        $additionalclass .= ' nopaddingbottom ';
    }

    return '<section class="section ' . $atts['el_class'] .' ' . $additionalclass . '">
        <div class="row clearfix">
            ' . wpb_js_remove_wpautop($content) .'
        </div>
    </section>';
}

$jeg_row_size = 1;

function vc_theme_vc_column($atts, $content) {
	global $jeg_row_size;
    $output = $font_color = $el_class = $width = $offset = '';
    extract(shortcode_atts(array(
        'font_color'      => '',
        'el_class' => '',
        'width' => '1/1',
        'css' => '',
        'offset' => ''
    ), $atts));


	$jeg_row_size = jeg_size_column($width);
    $width = jeg_translateColumnWidthToSpan($width);
    $width = vc_column_offset_class_merge($offset, $width);


    $el_class .= ' wpb_column vc_column_container';
    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $width . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), '', $atts );
    $output .= "\n\t".'<div class="'.$css_class.'">';
    $output .= "\n\t\t".'<div class="wpb_wrapper">';
    $output .= "\n\t\t\t".wpb_js_remove_wpautop($content);

	$jeg_row_size = 1;
    $output .= "\n\t\t".'</div> ';
    $output .= "\n\t".'</div> ';

    return $output;
}

function vc_theme_jeg_top_slider ($atts) {
    $atts = shortcode_atts(
        array(
            'size' => '',
            'filter_content' => '',
            'filter_category' => '',
            'filter_tag' => '',
            'popular_range' => '',
            'filter_offset' => '',
            'unique_content' => '',
            'el_class' => '',
        ),
        $atts
    );

    global $jpostarray;
    if($atts['unique_content'] !== 'yes') {
        $jpostarray = array();
    }

    $bigslider = '';
    $smallslider = '';
	$firstslide = true;

    $statement = jeg_build_post_statement($atts['filter_content'], $atts['filter_category'], $atts['filter_tag'], $atts['size'], $atts['popular_range'], $atts['filter_offset'], $jpostarray);
    $query = new WP_Query($statement);
    if ( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
            array_push($jpostarray, get_the_ID());

            $imgsrc = apply_filters('jeg_get_image_attachment', null, get_post_thumbnail_id(get_the_ID()), 'post-featured');
            $formatclass = apply_filters('jeg_format_post_class', null, get_the_ID());

            if($imgsrc) {
	            if($firstslide) {
		            $featured = "<img src='" . $imgsrc . "' alt='" . get_the_title() . "'>";
                    $firstslide = false;
	            } else {
	                $featured = "<img class='lazyOwl' src='" . JMAGZ_PLUGIN_URL . "/assets/placeholder/900x450.png" . "' data-src='" . $imgsrc . "' alt='" . get_the_title() . "'>";
	            }
            } else {
                $featured = "<div class='no-thumbnail-wrapper {$formatclass}'><div class='no-thumbnail-inner'><i class='fa'></i></div></div>";
            }

	        // image thumbnail
	        $imgsrcthumbnail = apply_filters('jeg_get_image_attachment', null, get_post_thumbnail_id(get_the_ID()), 'mini-post-featured');

	        if($imgsrcthumbnail) {
		        $featuredthumbnail = "<img src='" . $imgsrcthumbnail . "' alt='" . get_the_title() . "'>";
	        } else {
		        $featuredthumbnail = "<div class='no-thumbnail-wrapper {$formatclass}'><div class='no-thumbnail-inner'><i class='fa'></i></div></div>";
	        }

            $categoryarray = get_the_category();
            $categorytext = '';

            if(!empty($categoryarray)) {
                $categorytext = "<div class='post-categories'><a href='" . get_category_link($categoryarray[0]->term_id) . "' rel='category'>" . $categoryarray[0]->name . "</a></div>";
            }

            $bigslider .= '<div class="featured-slide">
                                <a href="' . get_permalink(get_the_ID()) . '" class="half-thumb">' . $featured . '</a>
                                <div class="caption">
                                    <div class="caption-container">
                                        ' . $categorytext . '
                                        <h1 class="post-title"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h1>
                                    </div>
                                </div>
                            </div>';

            $smallslider .= ' <div class="featured-thumbnail"><a href="#" class="half-thumb">' . $featuredthumbnail . '</a></div>';
        }
    }
    wp_reset_postdata();

    return
    '<div class="featured-post ' . $atts['el_class'] . '">
        <div class="featured-slider">' . $bigslider . '</div>
        <div class="featured-thumbnail-container">
            <div class="featured-slider-thumbnail">' . $smallslider . '</div>
        </div>
    </div>';
}

function vc_theme_jeg_no_thumb_top_slider ($atts) {
    global $jpostarray;
    $atts = shortcode_atts(
        array(
            'size' => '',
            'filter_content' => '',
            'filter_category' => '',
            'filter_tag' => '',
            'popular_range' => '',
            'filter_offset' => '',
            'unique_content' => '',
            'el_class' => '',
        ),
        $atts
    );

    global $jpostarray;
    if($atts['unique_content'] !== 'yes') {
        $jpostarray = array();
    }

    $bigslider = '';
    $smallslider = '';
	$firstslide = true;

    $statement = jeg_build_post_statement($atts['filter_content'], $atts['filter_category'], $atts['filter_tag'], $atts['size'], $atts['popular_range'], $atts['filter_offset'], $jpostarray);
    $query = new WP_Query($statement);
    if ( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
            array_push($jpostarray, get_the_ID());

            $imgsrc = apply_filters('jeg_get_image_attachment', null, get_post_thumbnail_id(get_the_ID()), 'post-featured');
            $formatclass = apply_filters('jeg_format_post_class', null, get_the_ID());

	        if($imgsrc) {
		        if($firstslide) {
			        $featured = "<img src='" . $imgsrc . "' alt='" . get_the_title() . "'>";
                    $firstslide = false;
		        } else {
			        $featured = "<img class='lazyOwl' src='" . JMAGZ_PLUGIN_URL . "/assets/placeholder/900x450.png" . "' data-src='" . $imgsrc . "' alt='" . get_the_title() . "'>";
		        }
	        } else {
		        $featured = "<div class='no-thumbnail-wrapper {$formatclass}'><div class='no-thumbnail-inner'><i class='fa'></i></div></div>";
	        }

            $categoryarray = get_the_category();
            $categorytext = '';

            if(!empty($categoryarray)) {
                $categorytext = "<div class='post-categories'><a href='" . get_category_link($categoryarray[0]->term_id) . "' rel='category'>" . $categoryarray[0]->name . "</a></div>";
            }

            $bigslider .= '<div class="featured-slide">
                                <a href="' . get_permalink(get_the_ID()) . '" class="half-thumb">' . $featured . '</a>
                                <div class="caption">
                                    <div class="caption-container">
                                        ' . $categorytext . '
                                        <h1 class="post-title"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h1>
                                    </div>
                                </div>
                            </div>';

            $smallslider .= ' <div class="featured-item-detail"><a href="#">' . get_the_title() . '</a></div>';
        }
    }
    wp_reset_postdata();

    return
        '<div class="featured-post ' . $atts['el_class'] . '">
        <div class="featured-slider-2">' . $bigslider . '</div>
        <div class="featured-thumbnail-container">
            <div class="featured-slider-2-thumbnail">' . $smallslider . '</div>
        </div>
    </div>';

}

function vc_theme_jeg_news_block_v1 ($atts) {
    global $jpostarray;
    $atts = shortcode_atts(
        array(
            'first_title' => '',
            'second_title' => '',
            'filter_content' => '',
            'filter_category' => '',
            'filter_tag' => '',
            'popular_range' => '',
            'filter_offset' => '',
            'unique_content' => '',
            'el_class' => '',
        ),
        $atts
    );

    global $jpostarray;
    if($atts['unique_content'] !== 'yes') {
        $jpostarray = array();
    }

    $firstline = '';
    $secondline = '';
    $thirdline = '';
    $index = 1;

    $statement = jeg_build_post_statement($atts['filter_content'], $atts['filter_category'], $atts['filter_tag'], 5, $atts['popular_range'], $atts['filter_offset'], $jpostarray);
    $query = new WP_Query($statement);
    if ( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
            array_push($jpostarray, get_the_ID());

            $categoryarray = get_the_category();
            $categorytext = '';

            if(!empty($categoryarray)) {
                $categorytext = "<span class='post-category'><a href='" . get_category_link($categoryarray[0]->term_id) . "' rel='category'>" . $categoryarray[0]->name . "</a></span>";
            }

            $timeformat = "<time class='post-date' datetime='" . get_the_time("Y-m-d H:i:s") . "'>" . human_time_diff( get_the_time('U'), current_time('timestamp') ) . __(' ago', 'jmagz-plugin') . "</time>";


            if($index === 1){
                $firstline .=
                '<article class="latest-post-big">
                    ' . apply_filters('jeg_featured_figure_lazy', null, 'half-post-featured') . '
                    <header class="content">
                        <h1 class="post-title"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h1>
                        <div class="post-meta">
                            ' . $categorytext . $timeformat .  '
                        </div>
                    </header>
                    <div class="post-excerpt">
                        <p>' . get_the_excerpt() . '</p>
                    </div>
                </article>';
            } else if ($index === 2 || $index === 3) {
                $secondline .=
                '<article class="latest-post-feed">
                    ' . apply_filters('jeg_featured_figure_lazy', null, 'one-third-post-featured') . '
                    <header class="content">
                        <h1 class="post-title"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h1>
                        <div class="post-meta">
                            ' . $categorytext . $timeformat .  '
                        </div>
                    </header>
                </article>';
            } else if ($index === 4 || $index === 5) {
                $thirdline .=
                    '<article class="latest-post-feed">
                        ' . apply_filters('jeg_featured_figure_lazy', null, 'one-third-post-featured') . '
                        <header class="content">
                            <h1 class="post-title"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h1>
                            <div class="post-meta">
                                ' . $categorytext . $timeformat .  '
                            </div>
                        </header>
                    </article>';
            }

            $index++;

        }
    }
    wp_reset_postdata();

    return
        '<div class="latest-post-1 ' . $atts['el_class'] . '">
            <div class="section-heading-wrapper">
                <h3 class="section-heading">' . $atts['first_title'] .
                    ' <strong>' . $atts['second_title'] . '</strong>
                </h3>
            </div>
            <div class="row clearfix">
                <div class="col-md-6 column">' . $firstline . '</div>
                <div class="col-md-3 column">' . $secondline . '</div>
                <div class="col-md-3 column">' . $thirdline . '</div>
            </div>
        </div>';

}

function vc_theme_jeg_news_block_v2 ($atts) {
    global $jpostarray;
    $atts = shortcode_atts(
        array(
            'first_title' => '',
            'second_title' => '',
            'filter_content' => '',
            'filter_category' => '',
            'filter_tag' => '',
            'popular_range' => '',
            'filter_offset' => '',
            'unique_content' => '',
            'el_class' => '',
        ),
        $atts
    );

    global $jpostarray;
    if($atts['unique_content'] !== 'yes') {
        $jpostarray = array();
    }

    $firstline = '';
    $secondline = '';
    $index = 1;

    $statement = jeg_build_post_statement($atts['filter_content'], $atts['filter_category'], $atts['filter_tag'], 5, $atts['popular_range'], $atts['filter_offset'], $jpostarray);
    $query = new WP_Query($statement);
    if ( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
            array_push($jpostarray, get_the_ID());

            $imgsrc = apply_filters('jeg_get_image_attachment', null, get_post_thumbnail_id(get_the_ID()), 'post-featured');
            $categoryarray = get_the_category();
            $categorytext = '';

            if(!empty($categoryarray)) {
                $categorytext = "<span class='post-category'><a href='" . get_category_link($categoryarray[0]->term_id) . "' rel='category'>" . $categoryarray[0]->name . "</a></span>";
            }

            $timeformat = "<time class='post-date' datetime='" . get_the_time("Y-m-d H:i:s") . "'>" . human_time_diff( get_the_time('U'), current_time('timestamp') ) . __(' ago', 'jmagz-plugin') . "</time>";


            if($index === 1){
                $firstline .=
                    '<article class="latest-post-big">
                    ' . apply_filters('jeg_featured_figure_lazy', null, 'two-third-post-featured') . '
                    <header class="content">
                        <h1 class="post-title"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h1>
                        <div class="post-meta">
                            ' . $categorytext . $timeformat .  '
                        </div>
                    </header>
                    <div class="post-excerpt">
                        <p>' . get_the_excerpt() . '</p>
                        <a href="' . get_permalink(get_the_ID()) . '" class="read-more">' . __('Continue reading &rarr;','jmagz-plugin') . '</a>
                    </div>
                </article>';
            } else if ($index === 2 || $index === 3) {
                $secondline .=
                    '<article class="latest-post-feed">
                    ' . apply_filters('jeg_featured_figure_lazy', null, 'half-post-featured') . '
                    <header class="content">
                        <h1 class="post-title"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h1>
                        <div class="post-meta">
                            ' . $categorytext . $timeformat .  '
                        </div>
                    </header>
                </article>';
            }

            $index++;

        }
    }
    wp_reset_postdata();

    return
        '<div class="cat-latest-post ' . $atts['el_class'] . '">
            <div class="section-heading-wrapper">
                <h3 class="section-heading">' . $atts['first_title'] . ' <strong>' . $atts['second_title'] . '</strong>
                </h3>
            </div>
            <div class="row clearfix">
                <div class="col-md-7 column">' . $firstline . '</div>
                <div class="col-md-5 column">' . $secondline . '</div>
            </div>
        </div>';

}

function vc_theme_jeg_mews_block_tower ($atts) {
	global $jeg_row_size;
    global $jpostarray;
    $atts = shortcode_atts(
        array(
            'first_title' => '',
            'second_title' => '',
            'size' => '',
            'more_url' => '',
            'filter_content' => '',
            'filter_category' => '',
            'filter_tag' => '',
            'popular_range' => '',
            'filter_offset' => '',
            'unique_content' => '',
            'el_class' => '',
        ),
        $atts
    );

    global $jpostarray;
    if($atts['unique_content'] !== 'yes') {
        $jpostarray = array();
    }

    $firstline = '';
    $secondline = '';
    $index = 1;
	$imagesizename = jeg_get_image_size_text($jeg_row_size);

    $statement = jeg_build_post_statement($atts['filter_content'], $atts['filter_category'], $atts['filter_tag'], $atts['size'], $atts['popular_range'], $atts['filter_offset'], $jpostarray);
    $query = new WP_Query($statement);
    if ( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
            array_push($jpostarray, get_the_ID());

            $timeformat = "<time class='post-date' datetime='" . get_the_time("Y-m-d H:i:s") . "'>" . human_time_diff( get_the_time('U'), current_time('timestamp') ) . __(' ago', 'jmagz-plugin') . "</time>";
            $authorurl = get_author_posts_url(get_the_author_meta('ID'));
            $authorname = apply_filters('jeg_get_author_name', null);

            if($index === 1){
                $firstline .=
                    '<article class="post-big">
                        ' . apply_filters('jeg_featured_figure_lazy', null, $imagesizename) . '
                        <header class="content">
                            <h1 class="post-title"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h1>
                            <div class="post-meta">
                                <span class="post-author">'. __('By', 'jmagz-plugin') . ' <a href="' . $authorurl .'" rel="author">' . $authorname .'</a></span>
                                ' . $timeformat . '
                            </div>
                        </header>
                        <div class="post-excerpt">
                            <p>' . get_the_excerpt() . '</p>
                        </div>
                    </article>';
            } else {
                $secondline .=
                    '<li class="post-feed-item content clearfix">
                        <h1 class="post-title">
                            <a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a>
                            <span class="post-meta">' . $timeformat . '</span>
                        </h1>
                    </li>';
            }
            $index++;
        }
    }
    wp_reset_postdata();

    return
        '<div class="post-columns ' . $atts['el_class'] . '">
            <div class="section-heading-wrapper">
                <h3 class="section-heading">' . $atts['first_title'] .' <strong>' . $atts['second_title'] .'</strong></h3>
            </div>
            ' . $firstline . '
            <ul class="post-feed clearfix">
                ' . $secondline . '
            </ul>
            <p><a href="' . $atts['more_url'] . '" class="more-post">' . __('View More','jmagz-plugin') . '</a></p>
        </div>';

}

function vc_theme_jeg_mews_slider ($atts) {
    global $jpostarray;
    $atts = shortcode_atts(
        array(
            'first_title' => '',
            'second_title' => '',
            'size' => '',
            'width' => '',
            'filter_content' => '',
            'filter_category' => '',
            'filter_tag' => '',
            'popular_range' => '',
            'filter_offset' => '',
            'unique_content' => '',
            'el_class' => '',
        ),
        $atts
    );

    global $jpostarray;
    if($atts['unique_content'] !== 'yes') {
        $jpostarray = array();
    }

    $article = '';

	if($atts['width'] === '2') $imagesizename = 'two-third-post-featured';
	if($atts['width'] === '3') $imagesizename = 'half-post-featured';
	if($atts['width'] === '4') $imagesizename = 'one-third-post-featured';

    $statement = jeg_build_post_statement($atts['filter_content'], $atts['filter_category'], $atts['filter_tag'], $atts['size'], $atts['popular_range'], $atts['filter_offset'], $jpostarray);
    $query = new WP_Query($statement);
    if ( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
            array_push($jpostarray, get_the_ID());

            $timeformat = "<time class='post-date' datetime='" . get_the_time("Y-m-d H:i:s") . "'>" . human_time_diff( get_the_time('U'), current_time('timestamp') ) . __(' ago', 'jmagz-plugin') . "</time>";
            $categoryarray = get_the_category();
            $categorytext = '';

            if(!empty($categoryarray)) {
                $categorytext = "<span class='post-category'><a href='" . get_category_link($categoryarray[0]->term_id) . "' rel='category'>" . $categoryarray[0]->name . "</a></span>";
            }

            $article .=
                '<article class="latest-post-feed">
                   ' . apply_filters('jeg_featured_figure', null, $imagesizename) . '
                    <header class="content">
                        <h1 class="post-title"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h1>
                        <div class="post-meta">
                            ' . $categorytext. $timeformat . '
                        </div>
                    </header>
                </article>';

        }
    }
    wp_reset_postdata();

    return
        '<div class="latest-post ' . $atts['el_class'] . '">
            <div class="section-heading-wrapper">
                <h3 class="section-heading">' . $atts['first_title'] .' <strong>' . $atts['second_title'] .'</strong></h3>
            </div>

            <div class="carousel-post" data-width="' . $atts['width'] . '">
                ' . $article . '
            </div>
        </div>';

}


function vc_theme_jeg_mews_slider_2 ($atts) {
    global $jpostarray;
    $atts = shortcode_atts(
        array(
            'first_title' => '',
            'second_title' => '',
            'size' => '',
            'width' => '',
            'filter_content' => '',
            'filter_category' => '',
            'filter_tag' => '',
            'popular_range' => '',
            'filter_offset' => '',
            'unique_content' => '',
            'el_class' => '',
        ),
        $atts
    );

    global $jpostarray;
    if($atts['unique_content'] !== 'yes') {
        $jpostarray = array();
    }

    $article = '';

    $statement = jeg_build_post_statement($atts['filter_content'], $atts['filter_category'], $atts['filter_tag'], $atts['size'], $atts['popular_range'], $atts['filter_offset'], $jpostarray);
    $query = new WP_Query($statement);
    if ( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
            array_push($jpostarray, get_the_ID());
            $timeformat = "<time class='post-date' datetime='" . get_the_time("Y-m-d H:i:s") . "'>" . human_time_diff( get_the_time('U'), current_time('timestamp') ) . __(' ago', 'jmagz-plugin') . "</time>";

            $categoryarray = get_the_category();
            $categorytext = '';

            if(!empty($categoryarray)) {
                $categorytext = "<span class='post-category'><a href='" . get_category_link($categoryarray[0]->term_id) . "' rel='category'>" . $categoryarray[0]->name . "</a></span>";
            }

            $article .=
                '<article class="postbox-feed">
                   ' . apply_filters('jeg_featured_figure', null, 'square-slider-thumbnail') . '
                    <header class="content">
                        <h1 class="post-title"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h1>
                        <div class="post-meta">
                            ' . $categorytext. $timeformat . '
                        </div>
                    </header>
                </article>';

        }
    }
    wp_reset_postdata();

    return
        '<div class="latest-post ' . $atts['el_class'] . '">
            <div class="section-heading-wrapper">
                <h3 class="section-heading">' . $atts['first_title'] .' <strong>' . $atts['second_title'] .'</strong></h3>
            </div>

            <div class="postbox" data-width="' . $atts['width'] . '">
                ' . $article . '
            </div>
        </div>';

}

function vc_theme_jeg_mews_block ($atts) {
    global $jpostarray;
    $atts = shortcode_atts(
        array(
            'first_title' => '',
            'second_title' => '',
            'size' => '',
            'width' => '',
            'filter_content' => '',
            'filter_category' => '',
            'filter_tag' => '',
            'popular_range' => '',
            'filter_offset' => '',
            'unique_content' => '',
            'el_class' => '',
        ),
        $atts
    );

    global $jpostarray;
    if($atts['unique_content'] !== 'yes') {
        $jpostarray = array();
    }

    $article = '';
    $index = 1;

	if($atts['width'] === '2') $imagesizename = 'two-third-post-featured';
	if($atts['width'] === '3') $imagesizename = 'half-post-featured';
	if($atts['width'] === '4') $imagesizename = 'one-third-post-featured';

    $statement = jeg_build_post_statement($atts['filter_content'], $atts['filter_category'], $atts['filter_tag'], $atts['size'], $atts['popular_range'], $atts['filter_offset'], $jpostarray);
    $query = new WP_Query($statement);
    if ( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
            array_push($jpostarray, get_the_ID());

            $timeformat = "<time class='post-date' datetime='" . get_the_time("Y-m-d H:i:s") . "'>" . human_time_diff( get_the_time('U'), current_time('timestamp') ) . __(' ago', 'jmagz-plugin') . "</time>";
            $authorurl = get_author_posts_url(get_the_author_meta('ID'));
            $authorname = apply_filters('jeg_get_author_name', null);
            $width = 12 / $atts['width'];

            $article .= (( $index - 1 ) % $atts['width'] == 0) ? "<div class='clearfix'>" : "";
            $article .=
                '<div class="col-md-' . $width . ' column">
                    <article class="post-list">
                        ' . apply_filters('jeg_featured_figure_lazy', null, $imagesizename) . '
                        <header class="content">
                            <h1 class="post-title"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h1>
                            <div class="post-meta">
                                <span class="post-author">'. __('By', 'jmagz-plugin') . ' <a href="' . $authorurl .'" rel="author">' . $authorname .'</a></span>
                                ' . $timeformat . '
                            </div>
                        </header>
                    </article>
                </div>';
            $article .= ($index % $atts['width'] === 0) ? "</div>" : "";
            $index++;
        }
    }
    wp_reset_postdata();

    $article .= (( $index - 1 ) % $atts['width'] !== 0) ? "</div>" : "";

    return
        '<div class="post-columns ' . $atts['el_class'] . '">
            <div class="col-md-12 column section-heading-wrapper">
                <h3 class="section-heading">' . $atts['first_title'] .' <strong>' . $atts['second_title'] .'</strong></h3>
            </div>'
            . $article .
        '</div>';
}




function vc_theme_jeg_news_video_block ($atts) {
    global $jpostarray;
    $atts = shortcode_atts(
        array(
            'size' => '',
            'first_title' => '',
            'second_title' => '',
            'filter_content' => '',
            'filter_category' => '',
            'filter_tag' => '',
            'popular_range' => '',
            'filter_offset' => '',
            'unique_content' => '',
            'el_class' => '',
        ),
        $atts
    );

    global $jpostarray;
    if($atts['unique_content'] !== 'yes') {
        $jpostarray = array();
    }

    $firstvideo = '';
    $videolist = '';

    $statement = jeg_build_post_statement($atts['filter_content'], $atts['filter_category'], $atts['filter_tag'], $atts['size'], $atts['popular_range'], $atts['filter_offset'], $jpostarray, 'post-format-video');
    $query = new WP_Query($statement);
    if ( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
            array_push($jpostarray, get_the_ID());

            $isactive = empty($firstvideo) ? "active" : '';

            if(empty($firstvideo)) {
                $videotype = vp_metabox('jmagz_blog_video.video_type');

                if($videotype === 'youtube') {
                    $firstvideo =
                        "<div data-src='" . vp_metabox('jmagz_blog_video.video_url') . "' data-type='youtube' data-repeat='false' data-autoplay='false' class='youtube-class clearfix'>
                            <div class='video-container'></div>
                        </div> ";
                } else if($videotype === 'vimeo') {
                    $firstvideo =
                        "<div data-src='" . vp_metabox('jmagz_blog_video.video_url') . "' data-type='vimeo' data-repeat='false' data-autoplay='false' class='vimeo-class clearfix'>
                            <div class='video-container'></div>
                        </div>";
                } else if($videotype === 'html5video') {
                    $mp4video = $webmvideo = $oggvideo = '';
                    if(vp_metabox('jmagz_blog_video.video.0.videomp4') !== '') {
                        $mp4video = "<source type='video/mp4' src='" . vp_metabox('jmagz_blog_video.video.0.videomp4') . "'>";
                    }
                    if(vp_metabox('jmagz_blog_video.video.0.videowebm') !== '') {
                        $webmvideo = "<source type='video/webm' src='" . vp_metabox('jmagz_blog_video.video.0.videowebm') . "'>";
                    }
                    if(vp_metabox('jmagz_blog_video.video.0.videoogg') !== '') {
                        $oggvideo = "<source type='video/ogg' src='" . vp_metabox('jmagz_blog_video.video.0.videoogg') . "'>";
                    }
                    $featuredimage = apply_filters('jeg_get_image_attachment', null, vp_metabox('jmagz_blog_video.video.0.bgfallback'), 'full');
                    $firstvideo =
                        "<video width='640' height='360' style='width: 100%; height: 100%;' poster='" . $featuredimage . "' preload='none'>"
                        .$mp4video . $webmvideo . $oggvideo .
                        "</video>";
                }
            }

            $termstring = '';
            $termlist = get_the_category();
            if($termlist) {
                $termlist = array_values($termlist);
                $termlist = $termlist[0];
                $termstring = '<div class="video-category">' . $termlist->name . '</div>';
            }

            $imgsrc = '';
            if(has_post_thumbnail()) {
                $imgsrc = '<img class="unveil" src="' . JMAGZ_PLUGIN_URL . "/assets/placeholder/150x75.png"  . '" data-src="' . apply_filters('jeg_get_image_attachment', null, get_post_thumbnail_id(get_the_ID()), 'mini-post-featured') . '" alt="' . get_the_title() . '">';
            }

            $videolist .=
                '<a class="' . $isactive. '" href="' . get_permalink(get_the_ID()) . '" data-id="' . get_the_ID() . '">
                    <div class="video-thumb">' . $imgsrc . '</div>
                    <div class="video-detail">
                        <div class="video-title">' .  get_the_title() . '</div>
                        ' . $termstring . '
                    </div>
                </a>';

        }
    }
    wp_reset_postdata();

    return
        '<div class="video-list video-list-review ' . $atts['el_class'] . '">
            <div class="section-heading-wrapper">
                <h3 class="section-heading">'
        . $atts['first_title'] . ' <strong>' . $atts['second_title'] . '</strong>
                </h3>
            </div>
            <div class="video-playlist-row clearfix">
                <div class="video-wrapper-content">
                    ' . $firstvideo . '
                </div>
                <div class="video-wrapper-list">
                    ' . $videolist . '
                </div>
            </div>
        </div>';
}




function vc_theme_jeg_post_button ($atts) {
    $atts = shortcode_atts(
        array(
            'title' => '',
            'url' => '',
            'icon' => '',
            'el_class' => '',
        ),
        $atts
    );


    return
        '<div class="older-post center ' . $atts['el_class'] . '">
            <div class="older-post-container">
                <a href="' . $atts['url'] . '" class="btn btn-small btn-default">
                    <i class="btn-icon fa ' . $atts['icon'] . '"></i> <strong>' . $atts['title'] . '</strong>
                </a>
            </div>
        </div>';

}


function vc_theme_jeg_ads_block ($atts) {
    $atts = shortcode_atts(
        array(
            'ads_type' => '',
            'ads_image' => '',
            'ads_image_link' => '',
            'ads_image_alt' => '',
            'ads_image_new_tab' => '',
            'ads_code' => '',

            'google_publisher_id' => '',
            'google_slot_id' => '',
            'google_desktop' => '',
            'google_tab' => '',
            'google_phone' => '',
        ),
        $atts
    );

    $html = '<div class="promocentered">';
    if($atts['ads_type'] === 'imagepromotion') {
        $opennewtab =  ( $atts['ads_image_new_tab'] == 'yes') ? "target='_blank'" : "";
        $adsimage = apply_filters('jeg_get_image_attachment', null, $atts['ads_image'], 'full');
        $html .= '<a href="' . $atts['ads_image_link'] . '" ' . $opennewtab . '>
                    <img src="' . $adsimage . '" alt="' . $atts['ads_image_alt'] . '">
                </a>';;
    } else if($atts['ads_type'] === 'code') {
        $html .= $atts['ads_code'];
    } else if($atts['ads_type'] === 'googleads') {

        $publisherid    = $atts['google_publisher_id'];
        $slotid         = $atts['google_slot_id'];
        $adshtml        = '';

        $desktopsize_ad     = array('728','90');
        $tabsize_ad         = array('468','60');
        $phonesize_ad       = array('320', '50');

        $desktopsize    = $atts['google_desktop'];
        $tabsize        = $atts['google_tab'];
        $phonesize      = $atts['google_phone'];

        if($desktopsize !== 'auto') $desktopsize_ad = explode('x', $desktopsize);
        if($tabsize !== 'auto') $tabsize_ad = explode('x', $tabsize);
        if($phonesize !== 'auto') $phonesize_ad = explode('x', $phonesize);

        $adshtml .= "<div class=\"\">\n";

        /* css style */
        $randomstring = jeg_generate_random_string();
        $adshtml .= "<style type='text/css' scoped>\n";

        if($desktopsize !== 'hide') $adshtml .= ".adsslot_{$randomstring}{ width:{$desktopsize_ad[0]}px !important; height:{$desktopsize_ad[1]}px !important; }\n";
        if($tabsize !== 'hide') $adshtml .= "@media (max-width:1199px) { .adsslot_{$randomstring}{ width:{$tabsize_ad[0]}px !important; height:{$tabsize_ad[1]}px !important; } }\n";
        if($phonesize !== 'hide') $adshtml .= "@media (max-width:767px) { .adsslot_{$randomstring}{ width:{$phonesize_ad[0]}px !important; height:{$phonesize_ad[1]}px !important; } }\n";

        $adshtml .= "</style>\n\n";
        $adshtml .= "<ins class=\"adsbygoogle adsslot_{$randomstring}\" style=\"display:inline-block;\" data-ad-client=\"{$publisherid}\" data-ad-slot=\"{$slotid}\"></ins>\n";
        $adshtml .= "<script async src='//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js'></script>\n";
        $adshtml .= "<script>(adsbygoogle = window.adsbygoogle || []).push({});</script>\n";

        $html .= $adshtml;
    }
    $html .= '</div>';

    return $html;
}


/*** review block **/

function vc_theme_jeg_review_video_block ($atts) {

    $atts = shortcode_atts(
        array(
            'size' => '',
            'first_title' => '',
            'second_title' => '',
            'filter_review' => '',
            'filter_review_category' => '',
            'filter_review_brand' => '',
            'filter_review_offset' => '',
            'unique_review_content' => '',
            'el_class' => '',
        ),
        $atts
    );

    global $jreviewarray;
    if($atts['unique_review_content'] !== 'yes') {
        $jreviewarray = array();
    }

    $firstvideo = '';
    $videolist = '';

    $statement = jeg_build_review_statement($atts['filter_review'], $atts['filter_review_category'], $atts['filter_review_brand'], $atts['size'], $atts['filter_review_offset'], $jreviewarray, 'post-format-video');
    $query = new WP_Query($statement);
    if ( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
            array_push($jreviewarray, get_the_ID());

            $isactive = empty($firstvideo) ? "active" : '';

            if(empty($firstvideo)) {
                $videotype = vp_metabox('jmagz_blog_video.video_type');

                if($videotype === 'youtube') {
                    $firstvideo =
                        "<div data-src='" . vp_metabox('jmagz_blog_video.video_url') . "' data-type='youtube' data-repeat='false' data-autoplay='false' class='youtube-class clearfix'>
                            <div class='video-container'></div>
                        </div> ";
                } else if($videotype === 'vimeo') {
                    $firstvideo =
                        "<div data-src='" . vp_metabox('jmagz_blog_video.video_url') . "' data-type='vimeo' data-repeat='false' data-autoplay='false' class='vimeo-class clearfix'>
                            <div class='video-container'></div>
                        </div>";
                } else if($videotype === 'html5video') {
                    $mp4video = $webmvideo = $oggvideo = '';
                    if(vp_metabox('jmagz_blog_video.video.0.videomp4') !== '') {
                        $mp4video = "<source type='video/mp4' src='" . vp_metabox('jmagz_blog_video.video.0.videomp4') . "'>";
                    }
                    if(vp_metabox('jmagz_blog_video.video.0.videowebm') !== '') {
                        $webmvideo = "<source type='video/webm' src='" . vp_metabox('jmagz_blog_video.video.0.videowebm') . "'>";
                    }
                    if(vp_metabox('jmagz_blog_video.video.0.videoogg') !== '') {
                        $oggvideo = "<source type='video/ogg' src='" . vp_metabox('jmagz_blog_video.video.0.videoogg') . "'>";
                    }
                    $featuredimage = apply_filters('jeg_get_image_attachment', null, vp_metabox('jmagz_blog_video.video.0.bgfallback'), 'full');
                    $firstvideo =
                        "<video width='640' height='360' style='width: 100%; height: 100%;' poster='" . $featuredimage . "' preload='none'>"
                            .$mp4video . $webmvideo . $oggvideo .
                        "</video>";
                }
            }

            $termstring = '';
            $termlist = get_the_terms(get_the_ID(), 'review-brand');
            if($termlist) {
                $termlist = array_values($termlist);
                $termlist = $termlist[0];
                $termstring = '<div class="video-category">' . $termlist->name . '</div>';
            }

            $imgsrc = '';
            if(has_post_thumbnail()) {
                $imgsrc = '<img class="unveil" src="' . JMAGZ_PLUGIN_URL . "/assets/placeholder/150x75.png"  . '" data-src="' . apply_filters('jeg_get_image_attachment', null, get_post_thumbnail_id(get_the_ID()), 'mini-post-featured') . '" alt="' . get_the_title() . '">';
            }

            $videolist .=
                '<a class="' . $isactive. '" href="' . get_permalink(get_the_ID()) . '" data-id="' . get_the_ID() . '">
                    <div class="video-thumb">
                        ' . $imgsrc . '
                    </div>
                    <div class="video-detail">
                        <div class="video-title">' .  get_the_title() . '</div>
                        ' . $termstring . '
                    </div>
                </a>';

        }
    }
    wp_reset_postdata();

    return
        '<div class="video-list video-list-review ' . $atts['el_class'] . '">
            <div class="section-heading-wrapper">
                <h3 class="section-heading">'
                    . $atts['first_title'] . ' <strong>' . $atts['second_title'] . '</strong>
                </h3>
            </div>
            <div class="video-playlist-row clearfix">
                <div class="video-wrapper-content">
                    ' . $firstvideo . '
                </div>
                <div class="video-wrapper-list">
                    ' . $videolist . '
                </div>
            </div>
        </div>';
}


function vc_theme_jeg_review_block_v1 ($atts) {

    $atts = shortcode_atts(
        array(
            'first_title' => '',
            'second_title' => '',
            'filter_review' => '',
            'filter_review_category' => '',
            'filter_review_brand' => '',
            'filter_review_offset' => '',
            'unique_review_content' => '',
            'el_class' => '',
        ),
        $atts
    );

    global $jreviewarray;
    if($atts['unique_review_content'] !== 'yes') {
        $jreviewarray = array();
    }

    $firstline = '';
    $secondline = '';
    $thirdline = '';
    $index = 1;

    $statement = jeg_build_review_statement($atts['filter_review'], $atts['filter_review_category'], $atts['filter_review_brand'], 5, $atts['filter_review_offset'], $jreviewarray);
    $query = new WP_Query($statement);
    if ( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
            array_push($jreviewarray, get_the_ID());

            // rating
            $mean = get_post_meta(get_the_ID(),'rating_mean');
            $starrating = apply_filters('jeg_build_rating', null, $mean);;

            if($index === 1){
                $firstline .=
                    '<article class="latest-post-big">
                    ' . apply_filters('jeg_featured_figure_lazy', null, 'half-post-featured') . '
                    <header class="content">
                        <h1 class="post-title"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h1>
                        ' . $starrating . '
                    </header>
                    <div class="post-excerpt">
                        <p>' . get_the_excerpt() . '</p>
                    </div>
                </article>';
            } else if ($index === 2 || $index === 3) {
                $secondline .=
                    '<article class="latest-post-feed">
                    ' . apply_filters('jeg_featured_figure_lazy', null, 'one-third-post-featured') . '
                    <header class="content">
                        <h1 class="post-title"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h1>
                        ' . $starrating . '
                    </header>
                </article>';
            } else if ($index === 4 || $index === 5) {
                $thirdline .=
                    '<article class="latest-post-feed">
                        ' . apply_filters('jeg_featured_figure_lazy', null, 'one-third-post-featured') . '
                        <header class="content">
                            <h1 class="post-title"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h1>
                            ' . $starrating . '
                        </header>
                    </article>';
            }

            $index++;

        }
    }
    wp_reset_postdata();

    return
        '<div class="latest-post-1 ' . $atts['el_class'] . '">
            <div class="section-heading-wrapper">
                <h3 class="section-heading">' . $atts['first_title'] .
        ' <strong>' . $atts['second_title'] . '</strong>
                </h3>
            </div>
            <div class="row clearfix">
                <div class="col-md-6 column">' . $firstline . '</div>
                <div class="col-md-3 column">' . $secondline . '</div>
                <div class="col-md-3 column">' . $thirdline . '</div>
            </div>
        </div>';

}


function vc_theme_jeg_review_block_v2 ($atts) {
    $atts = shortcode_atts(
        array(
            'first_title' => '',
            'second_title' => '',
            'filter_review' => '',
            'filter_review_category' => '',
            'filter_review_brand' => '',
            'filter_review_offset' => '',
            'unique_review_content' => '',
            'el_class' => '',
        ),
        $atts
    );

    global $jreviewarray;
    if($atts['unique_review_content'] !== 'yes') {
        $jreviewarray = array();
    }

    $firstline = '';
    $secondline = '';
    $index = 1;

    $statement = jeg_build_review_statement($atts['filter_review'], $atts['filter_review_category'], $atts['filter_review_brand'], 5, $atts['filter_review_offset'], $jreviewarray);
    $query = new WP_Query($statement);
    if ( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
            array_push($jreviewarray, get_the_ID());

            // rating
            $mean = get_post_meta(get_the_ID(),'rating_mean');
            $starrating = apply_filters('jeg_build_rating', null, $mean);;

            if($index === 1){
                $firstline .=
                    '<article class="latest-post-big">
                    ' . apply_filters('jeg_featured_figure_lazy', null, 'two-third-post-featured') . '
                    <header class="content">
                        <h1 class="post-title"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h1>
                        ' . $starrating . '
                    </header>
                    <div class="post-excerpt">
                        <p>' . get_the_excerpt() . '</p>
                        <a href="' . get_permalink(get_the_ID()) . '" class="read-more">' . __('Continue reading &rarr;','jmagz-plugin') . '</a>
                    </div>
                </article>';
            } else if ($index === 2 || $index === 3) {
                $secondline .=
                    '<article class="latest-post-feed">
                    ' . apply_filters('jeg_featured_figure_lazy', null, 'half-post-featured') . '
                    <header class="content">
                        <h1 class="post-title"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h1>
                        ' . $starrating . '
                    </header>
                </article>';
            }

            $index++;

        }
    }
    wp_reset_postdata();

    return
        '<div class="cat-latest-post ' . $atts['el_class'] . '">
            <div class="section-heading-wrapper">
                <h3 class="section-heading">' . $atts['first_title'] . ' <strong>' . $atts['second_title'] . '</strong>
                </h3>
            </div>
            <div class="row clearfix">
                <div class="col-md-7 column">' . $firstline . '</div>
                <div class="col-md-5 column">' . $secondline . '</div>
            </div>
        </div>';

}


function vc_theme_jeg_review_block_tower ($atts) {
	global $jeg_row_size;
	$atts = shortcode_atts(
        array(
            'first_title' => '',
            'second_title' => '',
            'size' => '',
            'more_url' => '',
            'filter_review' => '',
            'filter_review_category' => '',
            'filter_review_brand' => '',
            'filter_review_offset' => '',
            'unique_review_content' => '',
            'el_class' => '',
        ),
        $atts
    );

    global $jreviewarray;
    if($atts['unique_review_content'] !== 'yes') {
        $jreviewarray = array();
    }

    $firstline = '';
    $secondline = '';
    $index = 1;
	$imagesizename = jeg_get_image_size_text($jeg_row_size);

    $statement = jeg_build_review_statement($atts['filter_review'], $atts['filter_review_category'], $atts['filter_review_brand'], $atts['size'], $atts['filter_review_offset'], $jreviewarray);
    $query = new WP_Query($statement);
    if ( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
            array_push($jreviewarray, get_the_ID());

            // rating
            $mean = get_post_meta(get_the_ID(),'rating_mean');
            $starrating = apply_filters('jeg_build_rating', null, $mean);;

            $timeformat = "<time class='post-date' datetime='" . get_the_time("Y-m-d H:i:s") . "'>" . human_time_diff( get_the_time('U'), current_time('timestamp') ) . __(' ago', 'jmagz-plugin') . "</time>";

            if($index === 1){
                $firstline .=
                    '<article class="post-big">
                        ' . apply_filters('jeg_featured_figure_lazy', null, $imagesizename) . '
                        <header class="content">
                            <h1 class="post-title"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h1>
                            ' . $starrating . '
                        </header>
                        <div class="post-excerpt">
                            <p>' . get_the_excerpt() . '</p>
                        </div>
                    </article>';
            } else {
                $secondline .=
                    '<li class="post-feed-item content clearfix">
                        <h1 class="post-title">
                            <a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a>
                            <span class="post-meta">' . $timeformat . '</span>
                        </h1>
                    </li>';
            }
            $index++;
        }
    }
    wp_reset_postdata();

    return
        '<div class="post-columns ' . $atts['el_class'] . '">
            <div class="section-heading-wrapper">
                <h3 class="section-heading">' . $atts['first_title'] .' <strong>' . $atts['second_title'] .'</strong></h3>
            </div>
            ' . $firstline . '
            <ul class="post-feed clearfix">
                ' . $secondline . '
            </ul>
            <p><a href="' . $atts['more_url'] . '" class="more-post">' . __('View More','jmagz-plugin') . '</a></p>
        </div>';

}




function vc_theme_jeg_review_slider ($atts) {
    $atts = shortcode_atts(
        array(
            'first_title' => '',
            'second_title' => '',
            'size' => '',
            'width' => '',
            'filter_review' => '',
            'filter_review_category' => '',
            'filter_review_brand' => '',
            'filter_review_offset' => '',
            'unique_review_content' => '',
            'el_class' => '',
        ),
        $atts
    );

    global $jreviewarray;
    if($atts['unique_review_content'] !== 'yes') {
        $jreviewarray = array();
    }

    $article = '';

	if($atts['width'] === '2') $imagesizename = 'two-third-post-featured';
	if($atts['width'] === '3') $imagesizename = 'half-post-featured';
	if($atts['width'] === '4') $imagesizename = 'one-third-post-featured';

    $statement = jeg_build_review_statement($atts['filter_review'], $atts['filter_review_category'], $atts['filter_review_brand'], $atts['size'], $atts['filter_review_offset'], $jreviewarray);
    $query = new WP_Query($statement);
    if ( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
            array_push($jreviewarray, get_the_ID());

            // rating
            $mean = get_post_meta(get_the_ID(),'rating_mean');
            $starrating = apply_filters('jeg_build_rating', null, $mean);;

            $article .=
                '<article class="latest-post-feed">
                   ' . apply_filters('jeg_featured_figure', null, $imagesizename) . '
                    <header class="content">
                        <h1 class="post-title"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h1>
                        ' . $starrating . '
                    </header>
                </article>';

        }
    }
    wp_reset_postdata();

    return
        '<div class="latest-post ' . $atts['el_class'] . '">
            <div class="section-heading-wrapper">
                <h3 class="section-heading">' . $atts['first_title'] .' <strong>' . $atts['second_title'] .'</strong></h3>
            </div>

            <div class="carousel-post" data-width="' . $atts['width'] . '">
                ' . $article . '
            </div>
        </div>';

}


function vc_theme_jeg_review_block ($atts) {
    $atts = shortcode_atts(
        array(
            'first_title' => '',
            'second_title' => '',
            'size' => '',
            'width' => '',
            'filter_review' => '',
            'filter_review_category' => '',
            'filter_review_brand' => '',
            'filter_review_offset' => '',
            'unique_review_content' => '',
            'el_class' => '',
        ),
        $atts
    );

    global $jreviewarray;
    if($atts['unique_review_content'] !== 'yes') {
        $jreviewarray = array();
    }

    $article = '';
    $index = 1;

	if($atts['width'] === '2') $imagesizename = 'two-third-post-featured';
	if($atts['width'] === '3') $imagesizename = 'half-post-featured';
	if($atts['width'] === '4') $imagesizename = 'one-third-post-featured';

    $statement = jeg_build_review_statement($atts['filter_review'], $atts['filter_review_category'], $atts['filter_review_brand'], $atts['size'], $atts['filter_review_offset'], $jreviewarray);
    $query = new WP_Query($statement);
    if ( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
            array_push($jreviewarray, get_the_ID());

            // rating
            $mean = get_post_meta(get_the_ID(),'rating_mean');
            $starrating = apply_filters('jeg_build_rating', null, $mean);;
            $width = 12 / $atts['width'];

            $article .= (( $index - 1 ) % $atts['width'] == 0) ? "<div class='clearfix'>" : "";
            $article .=
                '<div class="col-md-' . $width . ' column">
                    <article class="post-list">
                        ' . apply_filters('jeg_featured_figure_lazy', null, $imagesizename) . '
                        <header class="content">
                            <h1 class="post-title"><a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h1>
                            ' . $starrating . '
                        </header>
                    </article>
                </div>';
            $article .= ($index % $atts['width'] === 0) ? "</div>" : "";
            $index++;
        }
    }
    wp_reset_postdata();

    $article .= (( $index - 1 ) % $atts['width'] !== 0) ? "</div>" : "";

    return
        '<div class="post-columns ' . $atts['el_class'] . '">
            <div class="col-md-12 column section-heading-wrapper">
                <h3 class="section-heading">' . $atts['first_title'] .' <strong>' . $atts['second_title'] .'</strong></h3>
            </div>'
        . $article .
        '</div>';

}