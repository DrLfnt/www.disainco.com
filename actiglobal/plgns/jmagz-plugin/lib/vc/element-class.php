<?php

/**
 * vc_row
 */
vc_remove_param('vc_row', 'css');
vc_remove_param('vc_row', 'font_color');
vc_remove_param('vc_row', 'full_width');

vc_remove_param('vc_column', 'css');
vc_remove_param('vc_column', 'width');
vc_remove_param('vc_column', 'offset');

vc_remove_param('vc_column_text', 'css');
vc_remove_param('vc_column_text', 'css_animation');

/**
 * additional element
 */

$adsize = array(
    'Auto'              => 'auto',
    'Hide'              => 'hide',
    '120 x 90'          => '120x90',
    '120 x 240'         => '120x240',
    '120 x 600'         => '120x600',
    '125 x 125'         => '125x125',
    '160 x 90'          => '160x90',
    '160 x 600'         => '160x600',
    '180 x 90'          => '180x90',
    '180 x 150'         => '180x150',
    '200 x 90'          => '200x90',
    '200 x 200'         => '200x200',
    '234 x 60'          => '234x60',
    '250 x 250'         => '250x250',
    '320 x 100'         => '320x100',
    '300 x 250'         => '300x250',
    '300 x 600'         => '300x600',
    '320 x 50'          => '320x50',
    '336 x 280'         => '336x280',
    '468 x 15'          => '468x15',
    '468 x 60'          => '468x60',
    '728 x 15'          => '728x15',
    '728 x 90'          => '728x90',
    '970 x 90'          => '970x90',
    '240 x 400'         => '240x400',
    '250 x 360'         => '250x360',
    '580 x 400'         => '580x400',
    '750 x 100'         => '750x100',
    '750 x 200'         => '750x200',
    '750 x 300'         => '750x300',
    '980 x 120'         => '980x120',
    '930 x 180'         => '930x180',
);



$extraclas = array(
    'type'          => 'textfield',
    'heading'       => 'Extra class name',
    'param_name'    => 'el_class',
    'description'   => 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.'
);

/** Post Content Category & Tag */
$postcategory = jeg_get_all_category_vc();
$posttag = jeg_get_all_tag_vc();

$filtercontent = array(
    'type'          => 'dropdown',
    'heading'       => 'Filter Content',
    'param_name'    => 'filter_content',
    'description'   => 'Filter your content using appropriate selection',
    'std'           => '',
    'value'         => array(
        'Latest News'   => 'latest',
        'Category'      => 'category',
        'Tag'           => 'tag',
        'Popular'       => 'popular'
    )
);
$filtercategory = array(
    'type'          => 'checkblock',
    'heading'       => 'Filter Category',
    'param_name'    => 'filter_category',
    'std'           => '',
    'value'         => $postcategory,
    'description'   => "Show only post within this category to show, leave empty to show all",
    'dependency'    => Array('element' => "filter_content", 'value' => array('category', 'popular'))
);
$filtertag = array(
    'type'          => 'checkblock',
    'heading'       => 'Filter Tag',
    'param_name'    => 'filter_tag',
    'value'         => $posttag,
    'description'   => "Show only post within this tag to show",
    'dependency'    => Array('element' => "filter_content", 'value' => array('tag'))
);
$filteroffset = array(
    'type'          => 'slider',
    'min'           => 0,
    'max'           => 15,
    'step'          => 1,
    'std'           => 0,
    'heading'       => "Query offset",
    'description'   => "show your post begin at number of offset",
    'param_name'    => "filter_offset",
    'dependency'    => Array('element' => "filter_content", 'value' => array('latest','category', 'tag'))
);
$filterunique = array(
    'type'          => 'checkbox',
    'heading'       => 'Include into unique content group',
    'description'   => "check this option, and this block will include into unique content group. it won't duplicate content across the group.",
    'param_name'    => 'unique_content',
    'value'         => array( "Unique Content Group" => 'yes' ),
);
$popularrange = array(
    'type'          => 'dropdown',
    'heading'       => 'Popular Range',
    'param_name'    => 'popular_range',
    'std'           => 'weekly',
    'value'         => array(
        'Daily'         => 'daily',
        'Weekly'        => 'weekly',
        'Monthly'       => 'monthly'
    ),
    'description'   => "Popular post range",
    'dependency'    => Array('element' => "filter_content", 'value' => array('popular'))
);


/** Review Category & Brand */
$reviewcategory = jeg_get_all_review_category_vc();
$reviewbrand = jeg_get_all_review_brand_vc();

$filterreview = array(
    'type'          => 'dropdown',
    'heading'       => 'Filter Review',
    'param_name'    => 'filter_review',
    'description'   => 'Filter your review content using appropriate selection',
    'std'           => '',
    'value'         => array(
        'Latest Review'     => 'latest',
        'Category'          => 'category',
        'Brand'             => 'brand'
    )
);
$filterreviewcategory = array(
    'type'          => 'checkblock',
    'heading'       => 'Filter Review Category',
    'param_name'    => 'filter_review_category',
    'value'         => $reviewcategory,
    'description'   => "Show only review within this category to show",
    'dependency'    => Array('element' => "filter_review", 'value' => array('category'))
);
$filterreviewbrand = array(
    'type'          => 'checkblock',
    'heading'       => 'Filter Brand',
    'param_name'    => 'filter_review_brand',
    'value'         => $reviewbrand,
    'description'   => "Show only review within this brand to show",
    'dependency'    => Array('element' => "filter_review", 'value' => array('brand'))
);
$filterreviewoffset = array(
    'type'          => 'slider',
    'min'           => 0,
    'max'           => 15,
    'step'          => 1,
    'std'           => 0,
    'heading'       => "Query offset",
    'description'   => "show your post begin at number of offset",
    'param_name'    => "filter_review_offset",
    'dependency'    => Array('element' => "filter_review", 'value' => array('latest','category', 'tag'))
);
$filterreviewunique = array(
    'type'          => 'checkbox',
    'heading'       => 'Include into unique content group',
    'description'   => "check this option, and this block will include into unique content group. it won't duplicate content across the group.",
    'param_name'    => 'unique_review_content',
    'value'         => array( "Unique Content Group" => 'yes' ),
);


vc_add_param('vc_row', array(
    'type'          => 'checkbox',
    'heading'       => 'Hide Border Bottom',
    'param_name'    => 'hide_border_bottom',
    'value'         => array( "Hide Border Bottom" => 'yes' ),
));

vc_add_param('vc_row', array(
    'type'          => 'checkbox',
    'heading'       => 'Use dark section',
    'param_name'    => 'dark_section',
    'value'         => array( "Enable Dark Section" => 'yes' ),
));

vc_add_param('vc_row', array(
    'type'          => 'checkbox',
    'heading'       => 'No Bottom Padding',
    'param_name'    => 'no_bottom_padding',
    'value'         => array( "No Bottom Padding" => 'yes' ),
));



/**
 * jeg top slider
 */
class WPBakeryShortCode_Jeg_Top_Slider  extends WPBakeryShortCode {}
vc_map(array(
    "name"                      => 'JMagz Top Slider',
    "base"                      => 'jeg_top_slider',
    "category"                  => 'JMagz Slider',
    "icon"                      => 'jeg_top_slider_icon',
    "allowed_container_element" => '',
    "params" => array(
        array(
            'type'          => 'slider',
            'min'           => 2,
            'max'           => 15,
            'step'          => 1,
            'std'           => 6,
            'heading'       => "Number of Slider",
            'param_name'    => "size",
        ),
        $filtercontent,
        $filtercategory,
        $filtertag,
        $popularrange,
        $filteroffset,
        $filterunique,
        $extraclas
    ),
));


/**
 * jeg no thumb top slider
 */
class WPBakeryShortCode_Jeg_No_Thumb_Top_Slider  extends WPBakeryShortCode {}
vc_map(array(
    "name"                      => 'JMagz Top Slider 2',
    "base"                      => 'jeg_no_thumb_top_slider',
    "category"                  => 'JMagz Slider',
    "icon"                      => 'jeg_no_thumb_top_slider_icon',
    "allowed_container_element" => '',
    "params" => array(
        array(
            'type'          => 'slider',
            'min'           => 2,
            'max'           => 15,
            'step'          => 1,
            'std'           => 6,
            'heading'       => "Number of Slider",
            'param_name'    => "size",
        ),
        $filtercontent,
        $filtercategory,
        $filtertag,
        $popularrange,
        $filteroffset,
        $filterunique,
        $extraclas
    ),
));


/**
 * news block 1
 */
class WPBakeryShortCode_Jeg_News_Block_V1  extends WPBakeryShortCode {}
vc_map(array(
    "name"                      => 'JMagz News - Block 5 News',
    "base"                      => 'jeg_news_block_v1',
    "category"                  => 'JMagz News',
    "icon"                      => 'jeg_news_block_v1_icon',
    "allowed_container_element" => '',
    "params" => array(
        array(
            'type'          => 'textfield',
            'heading'       => 'Title',
            'param_name'    => 'first_title',
            'description'   => 'black colored title',
            'holder'        => 'span',
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Second Title',
            'param_name'    => 'second_title',
            'description'   => 'orange colored title',
            'holder'        => 'span',
        ),
        $filtercontent,
        $filtercategory,
        $filtertag,
        $popularrange,
        $filteroffset,
        $filterunique,
        $extraclas
    ),
));

/**
 * news block 2
 */
class WPBakeryShortCode_Jeg_News_Block_V2  extends WPBakeryShortCode {}
vc_map(array(
    "name"                      => 'JMagz News - Block 3 News',
    "base"                      => 'jeg_news_block_v2',
    "category"                  => 'JMagz News',
    "icon"                      => 'jeg_news_block_v2_icon',
    "allowed_container_element" => '',
    "params" => array(
        array(
            'type'          => 'textfield',
            'heading'       => 'Title',
            'param_name'    => 'first_title',
            'description'   => 'black colored title',
            'holder'        => 'span',
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Second Title',
            'param_name'    => 'second_title',
            'description'   => 'orange colored title',
            'holder'        => 'span',
        ),
        $filtercontent,
        $filtercategory,
        $filtertag,
        $popularrange,
        $filteroffset,
        $filterunique,
        $extraclas
    ),
));

class WPBakeryShortCode_Jeg_News_Block_Tower  extends WPBakeryShortCode {}
vc_map(array(
    "name"                      => 'JMagz News - Block Tower',
    "base"                      => 'jeg_mews_block_tower',
    "category"                  => 'JMagz News',
    "icon"                      => 'jeg_mews_block_tower_icon',
    "allowed_container_element" => 'vc_row',
    "params" => array(
        array(
            'type'          => 'slider',
            'min'           => 2,
            'max'           => 10,
            'step'          => 1,
            'std'           => 5,
            'heading'       => "Number of News",
            'param_name'    => "size",
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Title',
            'param_name'    => 'first_title',
            'description'   => 'black colored title',
            'holder'        => 'span',
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Second Title',
            'param_name'    => 'second_title',
            'description'   => 'orange colored title',
            'holder'        => 'span',
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'View More URL',
            'param_name'    => 'more_url',
            'description'   => 'view more url'
        ),
        $filtercontent,
        $filtercategory,
        $filtertag,
        $popularrange,
        $filteroffset,
        $filterunique,
        $extraclas
    ),
));



class WPBakeryShortCode_Jeg_News_Slider  extends WPBakeryShortCode {}
vc_map(array(
    "name"                      => 'JMagz News - Slider',
    "base"                      => 'jeg_mews_slider',
    "category"                  => 'JMagz News',
    "icon"                      => 'jeg_mews_slider_icon',
    "allowed_container_element" => 'vc_row',
    "params" => array(
        array(
            'type'          => 'slider',
            'min'           => 2,
            'max'           => 10,
            'step'          => 1,
            'std'           => 7,
            'heading'       => "Number of News",
            'param_name'    => "size",
        ),
        array(
            'type'          => 'slider',
            'min'           => 2,
            'max'           => 4,
            'step'          => 1,
            'std'           => 3,
            'heading'       => "News block width",
            'param_name'    => "width",
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Title',
            'param_name'    => 'first_title',
            'description'   => 'black colored title',
            'holder'        => 'span',
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Second Title',
            'param_name'    => 'second_title',
            'description'   => 'orange colored title',
            'holder'        => 'span',
        ),
        $filtercontent,
        $filtercategory,
        $filtertag,
        $popularrange,
        $filteroffset,
        $filterunique,
        $extraclas
    ),
));


class WPBakeryShortCode_Jeg_News_Slider_2  extends WPBakeryShortCode {}
vc_map(array(
    "name"                      => 'JMagz News - Slider 2',
    "base"                      => 'jeg_mews_slider_2',
    "category"                  => 'JMagz News',
    "icon"                      => 'jeg_mews_slider_2_icon',
    "allowed_container_element" => 'vc_row',
    "params" => array(
        array(
            'type'          => 'slider',
            'min'           => 2,
            'max'           => 10,
            'step'          => 1,
            'std'           => 7,
            'heading'       => "Number of News",
            'param_name'    => "size",
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Title',
            'param_name'    => 'first_title',
            'description'   => 'black colored title',
            'holder'        => 'span',
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Second Title',
            'param_name'    => 'second_title',
            'description'   => 'orange colored title',
            'holder'        => 'span',
        ),
        $filtercontent,
        $filtercategory,
        $filtertag,
        $popularrange,
        $filteroffset,
        $filterunique,
        $extraclas
    ),
));



class WPBakeryShortCode_Jeg_News_Block  extends WPBakeryShortCode {}
vc_map(array(
    "name"                      => 'JMagz News - Square Block',
    "base"                      => 'jeg_mews_block',
    "category"                  => 'JMagz News',
    "icon"                      => 'jeg_mews_block_icon',
    "allowed_container_element" => 'vc_row',
    "params" => array(
        array(
            'type'          => 'slider',
            'min'           => 2,
            'max'           => 15,
            'step'          => 1,
            'std'           => 6,
            'heading'       => "Number of News",
            'param_name'    => "size",
        ),
        array(
            'type'          => 'slider',
            'min'           => 2,
            'max'           => 4,
            'step'          => 1,
            'std'           => 3,
            'heading'       => "News block width",
            'param_name'    => "width",
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Title',
            'param_name'    => 'first_title',
            'description'   => 'black colored title',
            'holder'        => 'span',
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Second Title',
            'param_name'    => 'second_title',
            'description'   => 'orange colored title',
            'holder'        => 'span',
        ),
        $filtercontent,
        $filtercategory,
        $filtertag,
        $popularrange,
        $filteroffset,
        $filterunique,
        $extraclas
    ),
));



class WPBakeryShortCode_Jeg_News_Video  extends WPBakeryShortCode {}
vc_map(array(
    "name"                      => 'JMagz News - Video List',
    "base"                      => 'jeg_news_video_block',
    "category"                  => 'JMagz News',
    "icon"                      => 'jeg_news_video_block_icon',
    "allowed_container_element" => 'vc_row',
    "params" => array(
        array(
            'type'          => 'slider',
            'min'           => 2,
            'max'           => 15,
            'step'          => 1,
            'std'           => 7,
            'heading'       => "Number of Video",
            'param_name'    => "size",
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Title',
            'param_name'    => 'first_title',
            'description'   => 'black colored title',
            'holder'        => 'span',
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Second Title',
            'param_name'    => 'second_title',
            'description'   => 'orange colored title',
            'holder'        => 'span',
        ),
        $filtercontent,
        $filtercategory,
        $filtertag,
        $popularrange,
        $filteroffset,
        $filterunique,
        $extraclas
    ),
));



/**
 * news block 1
 */
class WPBakeryShortCode_Jeg_Review_Block_V1  extends WPBakeryShortCode {}
vc_map(array(
    "name"                      => 'JMagz Review - Block 5 Review',
    "base"                      => 'jeg_review_block_v1',
    "category"                  => 'JMagz Review',
    "icon"                      => 'jeg_review_block_v1_icon',
    "allowed_container_element" => '',
    "params" => array(
        array(
            'type'          => 'textfield',
            'heading'       => 'Title',
            'param_name'    => 'first_title',
            'description'   => 'black colored title',
            'holder'        => 'span',
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Second Title',
            'param_name'    => 'second_title',
            'description'   => 'orange colored title',
            'holder'        => 'span',
        ),
        $filterreview,
        $filterreviewcategory,
        $filterreviewbrand,
        $filterreviewoffset,
        $filterreviewunique,
        $extraclas
    ),
));


/**
 * news block 2
 */
class WPBakeryShortCode_Jeg_Review_Block_V2  extends WPBakeryShortCode {}
vc_map(array(
    "name"                      => 'JMagz Review - Block 3 Review',
    "base"                      => 'jeg_review_block_v2',
    "category"                  => 'JMagz Review',
    "icon"                      => 'jeg_review_block_v2_icon',
    "allowed_container_element" => '',
    "params" => array(
        array(
            'type'          => 'textfield',
            'heading'       => 'Title',
            'param_name'    => 'first_title',
            'description'   => 'black colored title',
            'holder'        => 'span',
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Second Title',
            'param_name'    => 'second_title',
            'description'   => 'orange colored title',
            'holder'        => 'span',
        ),
        $filterreview,
        $filterreviewcategory,
        $filterreviewbrand,
        $filterreviewoffset,
        $filterreviewunique,
        $extraclas
    ),
));


class WPBakeryShortCode_Jeg_Review_Block_Tower  extends WPBakeryShortCode {}
vc_map(array(
    "name"                      => 'JMagz Review - Block Tower',
    "base"                      => 'jeg_review_block_tower',
    "category"                  => 'JMagz Review',
    "icon"                      => 'jeg_review_block_tower_icon',
    "allowed_container_element" => 'vc_row',
    "params" => array(
        array(
            'type'          => 'slider',
            'min'           => 2,
            'max'           => 10,
            'step'          => 1,
            'std'           => 5,
            'heading'       => "Number of Review",
            'param_name'    => "size",
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Title',
            'param_name'    => 'first_title',
            'description'   => 'black colored title',
            'holder'        => 'span',
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Second Title',
            'param_name'    => 'second_title',
            'description'   => 'orange colored title',
            'holder'        => 'span',
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'View More URL',
            'param_name'    => 'more_url',
            'description'   => 'view more url'
        ),
        $filterreview,
        $filterreviewcategory,
        $filterreviewbrand,
        $filterreviewoffset,
        $filterreviewunique,
        $extraclas
    ),
));


class WPBakeryShortCode_Jeg_Review_Slider  extends WPBakeryShortCode {}
vc_map(array(
    "name"                      => 'JMagz Review - Slider',
    "base"                      => 'jeg_review_slider',
    "category"                  => 'JMagz Review',
    "icon"                      => 'jeg_review_slider_icon',
    "allowed_container_element" => 'vc_row',
    "params" => array(
        array(
            'type'          => 'slider',
            'min'           => 2,
            'max'           => 10,
            'step'          => 1,
            'std'           => 7,
            'heading'       => "Number of Review",
            'param_name'    => "size",
        ),
        array(
            'type'          => 'slider',
            'min'           => 2,
            'max'           => 4,
            'step'          => 1,
            'std'           => 3,
            'heading'       => "Review block width",
            'param_name'    => "width",
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Title',
            'param_name'    => 'first_title',
            'description'   => 'black colored title',
            'holder'        => 'span',
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Second Title',
            'param_name'    => 'second_title',
            'description'   => 'orange colored title',
            'holder'        => 'span',
        ),
        $filterreview,
        $filterreviewcategory,
        $filterreviewbrand,
        $filterreviewoffset,
        $filterreviewunique,
        $extraclas
    ),
));

class WPBakeryShortCode_Jeg_Review_Block  extends WPBakeryShortCode {}
vc_map(array(
    "name"                      => 'JMagz Review - Square Block',
    "base"                      => 'jeg_review_block',
    "category"                  => 'JMagz Review',
    "icon"                      => 'jeg_review_block_icon',
    "allowed_container_element" => 'vc_row',
    "params" => array(
        array(
            'type'          => 'slider',
            'min'           => 2,
            'max'           => 15,
            'step'          => 1,
            'std'           => 6,
            'heading'       => "Number of News",
            'param_name'    => "size",
        ),
        array(
            'type'          => 'slider',
            'min'           => 2,
            'max'           => 4,
            'step'          => 1,
            'std'           => 3,
            'heading'       => "News block width",
            'param_name'    => "width",
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Title',
            'param_name'    => 'first_title',
            'description'   => 'black colored title',
            'holder'        => 'span',
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Second Title',
            'param_name'    => 'second_title',
            'description'   => 'orange colored title',
            'holder'        => 'span',
        ),
        $filterreview,
        $filterreviewcategory,
        $filterreviewbrand,
        $filterreviewoffset,
        $filterreviewunique,
        $extraclas
    ),
));

class WPBakeryShortCode_Jeg_Review_Video  extends WPBakeryShortCode {}
vc_map(array(
    "name"                      => 'JMagz Review - Video List',
    "base"                      => 'jeg_review_video_block',
    "category"                  => 'JMagz Review',
    "icon"                      => 'jeg_review_video_block_icon',
    "allowed_container_element" => 'vc_row',
    "params" => array(
        array(
            'type'          => 'slider',
            'min'           => 2,
            'max'           => 15,
            'step'          => 1,
            'std'           => 7,
            'heading'       => "Number of Video",
            'param_name'    => "size",
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Title',
            'param_name'    => 'first_title',
            'description'   => 'black colored title',
            'holder'        => 'span',
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Second Title',
            'param_name'    => 'second_title',
            'description'   => 'orange colored title',
            'holder'        => 'span',
        ),
        $filterreview,
        $filterreviewcategory,
        $filterreviewbrand,
        $filterreviewoffset,
        $filterreviewunique,
        $extraclas
    ),
));


class WPBakeryShortCode_Jeg_Post_Button  extends WPBakeryShortCode {}
vc_map(array(
    "name"                      => 'JMagz Post Button',
    "base"                      => 'jeg_post_button',
    "category"                  => 'JMagz News',
    "icon"                      => 'jeg_post_button_icon',
    "allowed_container_element" => 'vc_row',
    "params" => array(
        array(
            'type'          => 'textfield',
            'heading'       => 'Title',
            'param_name'    => 'title',
            'description'   => 'Button Title',
            'holder'        => 'span',
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'URL',
            'param_name'    => 'url',
            'description'   => 'link of button URL',
        ),
        array(
            'type'          => 'fontawesome',
            'heading'       => 'Icon',
            'param_name'    => 'icon',
        ),
        $extraclas
    ),
));



class WPBakeryShortCode_Jeg_Ads_Block  extends WPBakeryShortCode {}
vc_map(array(
    "name"                      => 'JMagz Ads Block',
    "base"                      => 'jeg_ads_block',
    "category"                  => 'JMagz News',
    "icon"                      => 'jeg_ads_block_icon',
    "allowed_container_element" => 'vc_row',
    "params" => array(
        array(
            'type'          => 'dropdown',
            'heading'       => 'Ads Type',
            'param_name'    => 'ads_type',
            'description'   => 'Filter your content using appropriate selection',
            'std'           => '',
            'value'         => array(
                'Image Ads'     => 'imagepromotion',
                'Script Code'   => 'code',
                'Google Ads'    => 'googleads',
            ),
        ),
        array(
            'type'          => 'attach_image',
            'heading'       => 'Ads Image',
            'param_name'    => 'ads_image',
            'description'   => 'upload your ads image',
            'dependency'    => Array('element' => "ads_type", 'value' => array('imagepromotion'))
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Ads Image Link',
            'param_name'    => 'ads_image_link',
            'description'   => 'link of your image ads',
            'dependency'    => Array('element' => "ads_type", 'value' => array('imagepromotion'))
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Image Alternate Text',
            'param_name'    => 'ads_image_alt',
            'description'   => 'alternate of your ads image',
            'dependency'    => Array('element' => "ads_type", 'value' => array('imagepromotion'))
        ),
        array(
            'type'          => 'checkbox',
            'heading'       => 'Ads image open new tab',
            'param_name'    => 'ads_image_new_tab',
            'value'         => array( "Open in new tab" => 'yes' ),
            'dependency'    => Array('element' => "ads_type", 'value' => array('imagepromotion'))
        ),
        array(
            'type'          => 'textarea',
            'heading'       => 'Ads Code',
            'param_name'    => 'ads_code',
            'description'   => 'put your full ad script right here',
            'dependency'    => Array('element' => "ads_type", 'value' => array('code'))
        ),
        // google
        array(
            'type'          => 'textfield',
            'heading'       => 'Publisher ID',
            'param_name'    => 'google_publisher_id',
            'description'   => 'data-ad-client / google_ad_client content',
            'dependency'    => Array('element' => "ads_type", 'value' => array('googleads'))
        ),
        array(
            'type'          => 'textfield',
            'heading'       => 'Ads Slot ID',
            'param_name'    => 'google_slot_id',
            'description'   => 'data-ad-slot / google_ad_slot content',
            'dependency'    => Array('element' => "ads_type", 'value' => array('googleads'))
        ),
        array(
            'type'          => 'dropdown',
            'heading'       => 'Desktop Ads Size',
            'param_name'    => 'google_desktop',
            'description'   => 'Choose ad size to show on desktop',
            'dependency'    => Array('element' => "ads_type", 'value' => array('googleads')),
            'std'           => 'auto',
            'value'         => $adsize
        ),
        array(
            'type'          => 'dropdown',
            'heading'       => 'Tab Ads Size',
            'param_name'    => 'google_tab',
            'description'   => 'Choose ad size to show on tab',
            'dependency'    => Array('element' => "ads_type", 'value' => array('googleads')),
            'std'           => 'auto',
            'value'         => $adsize
        ),
        array(
            'type'          => 'dropdown',
            'heading'       => 'Phone Ads Size',
            'param_name'    => 'google_phone',
            'description'   => 'Choose ad size to show on phone',
            'dependency'    => Array('element' => "ads_type", 'value' => array('googleads')),
            'std'           => 'auto',
            'value'         => $adsize
        ),
    ),
));