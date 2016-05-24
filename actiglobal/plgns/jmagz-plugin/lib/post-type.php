<?php

/**
 * @author Jegtheme
 */


/**
 * Review Post Type
 */
function jeg_post_type_review()
{
    $args =
        array(
            'labels' 	=>
                array(
                    'name' 				=> 'Review',
                    'singular_name' 	=> 'Review Item',
                    'add_new'			=> 'Add Review',
                    'add_new_item' 		=> 'Add Review',
                    'edit_item' 		=> 'Edit Review Entry',
                    'new_item' 			=> 'New Review Entry',
                    'view_item' 		=> 'View Review',
                    'search_items' 		=> 'Search Review Items',
                    'not_found' 		=> 'No Review items found',
                    'not_found_in_trash'=> 'No Review items found in Trash',
                    'parent_item_colon' => ''
                ),
            'description'			=> 'Review Post type',
            'public' 				=> true,
            'show_ui' 				=> true,
            'menu_icon'				=> JMAGZ_PLUGIN_URL . '/assets/img/review.png',
            'menu_position'			=> 6,
            'capability_type' 		=> 'post',
            'hierarchical' 			=> false,
            'supports' 				=> array('title' , 'editor', 'comments', 'page-attributes', 'post-formats', 'thumbnail'),
            'taxonomies' 			=> array('review-category', 'review-brand'),
        );

    register_post_type( 'review', $args);
}

add_action('after_setup_theme', 'jeg_post_type_review');

function jeg_review_taxonomy()
{
    /** register review category **/
    register_taxonomy('review-category', array('review'),
        array(
            'hierarchical' 		=> true,
            'label' 			=> 'Product Categories',
            'singular_label' 	=> 'Product Category',
            'rewrite' 			=> true,
            'query_var' 		=> true
        )
    );

    /** register review brand **/
    register_taxonomy('review-brand', array('review'),
        array(
            'hierarchical' 		=> true,
            'label' 			=> 'Product Brand',
            'singular_label' 	=> 'Product Brand',
            'rewrite' 			=> true,
            'query_var' 		=> true
        )
    );
}

add_action('after_setup_theme', 'jeg_review_taxonomy');

/**
 *  Category Builder Post Type
 */


function jeg_post_type_page_builder()
{
    $args =
        array(
            'labels' 	=>
                array(
                    'name' 				=> 'Cat Builder',
                    'singular_name' 	=> 'Cat Builder',
                    'add_new'			=> 'New Cat Builder',
                    'add_new_item' 		=> 'New Cat Builder',
                    'edit_item' 		=> 'Edit Cat Builder Entry',
                    'new_item' 			=> 'New Cat Builder Entry',
                    'view_item' 		=> 'View Cat Builder',
                    'search_items' 		=> 'Search Cat Builder Items',
                    'not_found' 		=> 'No Cat Builder items found',
                    'not_found_in_trash'=> 'No Cat Builder items found in Trash',
                    'parent_item_colon' => ''
                ),
            'description'			=> 'Category Builder Post type',
            'public' 				=> false,
            'show_ui' 				=> true,
            'menu_icon'				=> JMAGZ_PLUGIN_URL . '/assets/img/builder.png',
            'menu_position'			=> 6,
            'capability_type' 		=> 'post',
            'hierarchical' 			=> true,
            'supports' 				=> array('title', 'editor')
        );

    register_post_type( 'cat_builder', $args);
}

add_action('after_setup_theme', 'jeg_post_type_page_builder');

