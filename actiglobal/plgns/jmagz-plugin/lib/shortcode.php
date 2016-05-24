<?php
/*
 * @author jegbagus
 */

function jeg_load_shortcode() {
    /** General shortcode */
    if( defined('JEG_PLUGIN_VERSION') ) {
        new VP_ShortcodeGenerator(array(
            'name'                  => 'generalshortcode',
            'template'              => require_once JMAGZ_PLUGIN_DIR . '/lib/general-shortcode.php',
            'modal_title'           =>  'General Shortocde',
            'button_title'          =>  'General Shortocde',
            'types'                 => array( 'post', 'page', 'review' ),
            'included_pages'        => array( '' ),
            'main_image'            => JMAGZ_PLUGIN_URL . '/assets/img/jshortcode.png',
            'sprite_image'          => JMAGZ_PLUGIN_URL . '/assets/img/jshortcode.png',
        ));
    }
}

add_action('after_setup_theme'	, 'jeg_load_shortcode');