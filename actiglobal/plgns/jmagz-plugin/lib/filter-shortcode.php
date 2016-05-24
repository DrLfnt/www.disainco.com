<?php

/************************
 * Clean up shortcode
 ***********************/
function the_content_filter($content) {
    $block = join("|",
        array(
            "relatedpost", "row", "column", "intro", "spacing", "singleicon", "iconlistwrapper", "iconlist",
            "googlemap", "alert", "button", "accordion", "accordion-element",
            "tab-heading-wrapper", "tab-heading", "tab-content-wrapper", "tab-content"
        ));

    $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
    $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);

    return $rep;
}

add_filter("the_content", "the_content_filter");

function custom_oembed_filter($html, $url, $attr, $post_ID) {
    $geturl = parse_url($url);

    if ( strstr($geturl['host'], 'youtube.com') || strstr($geturl['host'], 'vimeo.com') )
        return '<div class="video-container">'.$html.'</div>';

    return $html;
}

add_filter( 'embed_oembed_html', 'custom_oembed_filter', 10, 4 ) ;