<?php

function jeg_vc_additional_element() {
    if (class_exists('WPBakeryVisualComposerAbstract')) {
        require_once JEG_PLUGIN_DIR . 'vc/additional-element.php';
    }
}


add_action( 'init' ,  'jeg_vc_additional_element' , 98 );