<?php
/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */


/* visual composer integration */
function jeg_vc_update(){
    if(function_exists('vc_set_as_theme')) {
        vc_set_as_theme();
    }

    if (class_exists('WPBakeryVisualComposerAbstract')) {
        require_once JMAGZ_PLUGIN_DIR . '/lib/vc/view.php';
        require_once JMAGZ_PLUGIN_DIR . '/lib/vc/element-class.php';
        vc_set_default_editor_post_types(array('cat_builder', 'page'));
    }
}
add_action( 'after_setup_theme' ,  'jeg_vc_update' , 99 );

function jeg_vc_screen() {
    $screen = get_current_screen();
    if($screen->post_type === 'cat_builder' && is_admin()) {
        require_once JMAGZ_PLUGIN_DIR . '/lib/vc/element-page-builder.php';
    }
    if($screen->post_type === 'page' && is_admin()) {
        require_once JMAGZ_PLUGIN_DIR . '/lib/vc/element-page.php';
    }
}

add_action('current_screen', 'jeg_vc_screen');

function jeg_remove_menu_vc() {
    remove_submenu_page('options-general.php','vc_settings');
}

add_action('admin_menu', 'jeg_remove_menu_vc', 99);