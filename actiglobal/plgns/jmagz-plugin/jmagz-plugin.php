<?php
/*
	Plugin Name: Jmagz Plugin
	Plugin URI: http://jegtheme.com/
	Description: Mandatory Plugin for Jmagz Themes
	Version: 1.0.4
	Author: Jegtheme
	Author URI: http://jegtheme.com
	License: GPL2
*/

defined( 'JMAGZ_PLUGIN_VERSION' ) 	    or define( 'JMAGZ_PLUGIN_VERSION', '1.0.5' );
defined( 'JMAGZ_PLUGIN_URL' ) 		    or define( 'JMAGZ_PLUGIN_URL', plugins_url('jmagz-plugin'));
defined( 'JMAGZ_PLUGIN_FILE' ) 		    or define( 'JMAGZ_PLUGIN_FILE',  __FILE__ );
defined( 'JMAGZ_PLUGIN_DIR' ) 		    or define( 'JMAGZ_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

$jpostarray = array();
$jreviewarray = array();

function jeg_jmagz_plugin_load() {
    if( defined('JEG_PLUGIN_VERSION') ) {
        require_once JMAGZ_PLUGIN_DIR . '/lib/plugin-helper.php';
        require_once JMAGZ_PLUGIN_DIR . '/lib/post-type.php';
        require_once JMAGZ_PLUGIN_DIR . '/lib/shortcode.php';
        require_once JMAGZ_PLUGIN_DIR . '/lib/build-shortcode.php';
        require_once JMAGZ_PLUGIN_DIR . '/lib/filter-shortcode.php';
        require_once JMAGZ_PLUGIN_DIR . '/lib/vc-integration.php';
        require_once JMAGZ_PLUGIN_DIR . '/lib/additional-widget.php';
        require_once JMAGZ_PLUGIN_DIR . '/lib/additional-filter.php';
    }
}

add_action('plugins_loaded', 'jeg_jmagz_plugin_load');

function jmagz_load_textdomain()
{
    $domain = 'jmagz-plugin';
    $jeg_lang_dir = dirname( plugin_basename( JMAGZ_PLUGIN_FILE ) ) . '/lang/';

    // Traditional WordPress plugin locale filter
    $locale        = apply_filters( 'plugin_locale',  get_locale(), $domain );
    $mofile        = sprintf( '%1$s-%2$s.mo', $domain, $locale );

    // Setup paths to current locale file
    $mofile_local  = $jeg_lang_dir . $mofile;
    $mofile_global = WP_LANG_DIR . '/' . $domain . '/' . $mofile;


    if ( file_exists( $mofile_global ) ) {
        load_textdomain( $domain, $mofile_global );
    } elseif ( file_exists( $mofile_local ) ) {
        load_textdomain( $domain, $mofile_local );
    } else {
        load_plugin_textdomain( $domain, false, $jeg_lang_dir );
    }
}
add_action('init', 'jmagz_load_textdomain');