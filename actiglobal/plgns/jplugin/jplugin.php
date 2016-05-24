<?php
/*
	Plugin Name: JPlugin
	Plugin URI: http://jegtheme.com/
	Description: Mandatory Plugin for Jegtheme Theme
	Version: 1.0.4
	Author: Agung Bayu Iswara
	Author URI: http://jegtheme.com
	License: GPL2
*/

defined( 'JEG_PLUGIN_VERSION' ) 	    or define( 'JEG_PLUGIN_VERSION', '1.0.4' );
defined( 'JEG_PLUGIN_URL' ) 		    or define( 'JEG_PLUGIN_URL', plugins_url('jplugin'));
defined( 'JEG_PLUGIN_DIR' ) 		    or define( 'JEG_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

/** load vafpress */
require_once JEG_PLUGIN_DIR . 'framework/bootstrap.php';

/** load jtemplate */
require_once JEG_PLUGIN_DIR . 'lib/jtemplate.php';
require_once JEG_PLUGIN_DIR . 'lib/jeg-metabox.php';

/** extend vc shortcode element */
require_once JEG_PLUGIN_DIR . 'vc/extend.php';