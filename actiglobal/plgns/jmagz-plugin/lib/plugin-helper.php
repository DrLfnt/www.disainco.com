<?php

function jeg_get_image_size_text($width) {
	if($width >= 9) return 'post-featured';
	if($width >= 6) return 'two-third-post-featured';
	if($width >= 4) return 'half-post-featured';
	if($width >= 1) return 'one-third-post-featured';
}

function jeg_size_column($width, $front = true) {
	if ( preg_match( '/^(\d{1,2})\/12$/', $width, $match ) ) {
		$w = $match[1];
	} else {
		switch ( $width ) {
			case "1/6" :
				$w = '2';
				break;
			case "1/4" :
				$w = '3';
				break;
			case "1/3" :
				$w = '4';
				break;
			case "1/2" :
				$w = '6';
				break;
			case "2/3" :
				$w = '8';
				break;
			case "3/4" :
				$w = '9';
				break;
			case "5/6" :
				$w = '10';
				break;
			case "1/1" :
				$w = '12';
				break;
			default :
				$w = $width;
		}
	}

	return $w;
}

function jeg_translateColumnWidthToSpan( $width, $front = true ) {
    if ( preg_match( '/^(\d{1,2})\/12$/', $width, $match ) ) {
        $w = 'col-md-'.$match[1];
    } else {
        $w = 'col-md-';
        switch ( $width ) {
            case "1/6" :
                $w .= '2';
                break;
            case "1/4" :
                $w .= '3';
                break;
            case "1/3" :
                $w .= '4';
                break;
            case "1/2" :
                $w .= '6';
                break;
            case "2/3" :
                $w .= '8';
                break;
            case "3/4" :
                $w .= '9';
                break;
            case "5/6" :
                $w .= '10';
                break;
            case "1/1" :
                $w .= '12';
                break;
            default :
                $w = $width;
        }
    }
    $custom = $front ? get_custom_column_class( $w ) : false;
    return $custom ? $custom : $w;
}

function jeg_get_all_category_vc(){
    $result = array();

    $termlist = get_categories(array('hide_empty' => 0 ));
    foreach($termlist as $term){
        $result[$term->name] = $term->term_id;
    }

    return $result;
}

function jeg_get_all_tag_vc(){
    $result = array();

    $termlist = get_tags();
    foreach($termlist as $term){
        $result[$term->name] = $term->term_id;
    }

    return $result;
}

function jeg_get_all_review_category_vc(){
    $result = array();

    $termlist = get_terms('review-category');
    foreach($termlist as $term){
        $result[$term->name] = $term->term_id;
    }

    return $result;
}

function jeg_get_all_review_brand_vc(){
    $result = array();

    $termlist = get_terms('review-brand');
    foreach($termlist as $term){
        $result[$term->name] = $term->term_id;
    }

    return $result;
}


function jeg_build_post_statement($filtertype, $category, $tag, $number, $range, $offset = 0, $uniquecontent = array(), $postformat = null)
{
    if($filtertype !== 'popular')
    {
        $statement = array(
            'post_type'				=> "post",
            'orderby'				=> "date",
            'order'					=> "DESC",
            'posts_per_page'		=> $number
        );

        if($filtertype === 'category') {
            if(!empty($category)) {
                $catstr = array();
                $catarray = explode(',', $category);
                foreach($catarray as $cat) {
                    $result = get_the_category_by_ID($cat);
                    if($result) $catstr = $cat;
                }

                if(!empty($catstr)) {
                    $statement['category__in'] = explode(',', $category);
                }
            }
        } else if($filtertype === 'tag') {
            $statement['tag__in'] = explode(',', $tag);
        }

        if($postformat) {
            $statement['tax_query'][] = array(
                'taxonomy' => 'post_format',
                'terms' => $postformat,
                'field' => 'slug'
            );
        }

        if(($filtertype === 'category' || $postformat === 'brand') && $postformat) {
            $statement['tax_query']['relation'] = "AND";
        }

        if($offset !== 0) {
            $statement['offset'] = $offset;
        }

        if(!empty($uniquecontent)) {
            $statement['post__not_in'] = $uniquecontent;
        }

    } else {
        $results = jeg_get_popular_post(array(
            'limit' => $number,
            'order_by' => 'views',
            'post_type' => 'post',
            'freshness' => false,
            'cat' => $category,
            'range' => $range
        ));

        $result_id = array();
        foreach($results as $result) $result_id[] = $result->id;

        $statement = array(
            'post__in' => $result_id,
            'post_type'	=> "post",
            'posts_per_page' => $number,
            'orderby' => "date",
            'order'	=> "DESC",
        );
    }
    return $statement;
}

function jeg_build_review_statement($filtertype, $category, $brand, $number, $offset = 0, $uniquecontent = array(), $postformat = null) {
    $statement = array(
        'post_type'				=> "review",
        'orderby'				=> "date",
        'order'					=> "DESC",
        'posts_per_page'		=> $number
    );

    if($filtertype === 'category') {
        $statement['tax_query'][] = array(
            'taxonomy' => 'review-category',
            'terms' => explode(',', $category),
            'field' => 'id',
        );
    } else if($filtertype === 'brand') {
        $statement['tax_query'][] = array(
            'taxonomy' => 'review-brand',
            'terms' => explode(',', $brand),
            'field' => 'id',
        );
    }

    if($postformat) {
        $statement['tax_query'][] = array(
            'taxonomy' => 'post_format',
            'terms' => $postformat,
            'field' => 'slug'
        );
    }

    if(($filtertype === 'category' || $postformat === 'brand') && $postformat) {
        $statement['tax_query']['relation'] = "AND";
    }

    if($offset !== 0) {
        $statement['offset'] = $offset;
    }

    if(!empty($uniquecontent)) {
        $statement['post__not_in'] = $uniquecontent;
    }

    return $statement;
}


function jeg_merge_array_r( array &$array1, array &$array2 ) {
    $merged = $array1;
    foreach ( $array2 as $key => &$value ) {
        if ( is_array( $value ) && isset ( $merged[$key] ) && is_array( $merged[$key] ) ) {
            $merged[$key] = $this->__merge_array_r( $merged[$key], $value );
        } else {
            $merged[$key] = $value;
        }
    }
    return $merged;

}
function jeg_sorter($a, $b) {
    if ($a > 0 && $b > 0) {
        return $a - $b;
    } else {
        return $b - $a;
    }
}


function jeg_get_popular_post($instance) {

    // default array defined
    $defaults = array(
        'title' => '',
        'limit' => 10,
        'range' => 'daily',
        'freshness' => false,
        'order_by' => 'views',
        'post_type' => 'post,page',
        'pid' => '',
        'author' => '',
        'cat' => '',
        'shorten_title' => array(
            'active' => false,
            'length' => 25,
            'words'	=> false
        ),
        'post-excerpt' => array(
            'active' => false,
            'length' => 55,
            'keep_format' => false,
            'words' => false
        ),
        'thumbnail' => array(
            'active' => false,
            'build' => 'manual',
            'width' => 15,
            'height' => 15,
            'crop' => true
        ),
        'rating' => false,
        'stats_tag' => array(
            'comment_count' => false,
            'views' => true,
            'author' => false,
            'date' => array(
                'active' => false,
                'format' => 'F j, Y'
            ),
            'category' => false
        ),
    );

    global $wpdb;

    $instance = jeg_merge_array_r(
        $defaults,
        $instance
    );

    $prefix = $wpdb->prefix . "popularposts";
    $fields = "p.ID AS 'id', p.post_title AS 'title', p.post_date AS 'date', p.post_author AS 'uid'";
    $from = "";
    $where = "WHERE 1 = 1";
    $orderby = "";
    $groupby = "";
    $limit = "LIMIT {$instance['limit']}";

    $now = current_time('mysql');

    // * post types - based on code seen at https://github.com/williamsba/WordPress-Popular-Posts-with-Custom-Post-Type-Support
    $types = explode(",", $instance['post_type']);
    $sql_post_types = "";
    $join_cats = true;

    // if we're getting just pages, why join the categories table?
    if ( 'page' == strtolower($instance['post_type']) ) {

        $join_cats = false;
        $where .= " AND p.post_type = '{$instance['post_type']}'";

    }
    // we're listing other custom type(s)
    else {

        if ( count($types) > 1 ) {

            foreach ( $types as $post_type ) {
                $sql_post_types .= "'{$post_type}',";
            }

            $sql_post_types = rtrim( $sql_post_types, ",");
            $where .= " AND p.post_type IN({$sql_post_types})";

        } else {
            $where .= " AND p.post_type = '{$instance['post_type']}'";
        }

    }

    // * posts exclusion
    if ( !empty($instance['pid']) ) {

        $ath = explode(",", $instance['pid']);

        $where .= ( count($ath) > 1 )
            ? " AND p.ID NOT IN({$instance['pid']})"
            : " AND p.ID <> '{$instance['pid']}'";

    }

    // * categories
    if ( !empty($instance['cat']) && $join_cats ) {

        $cat_ids = explode(",", $instance['cat']);
        $in = array();
        $out = array();
        $not_in = "";

        usort($cat_ids, 'jeg_sorter');

        for ($i=0; $i < count($cat_ids); $i++) {
            if ($cat_ids[$i] >= 0) $in[] = $cat_ids[$i];
            if ($cat_ids[$i] < 0) $out[] = $cat_ids[$i];
        }

        $in_cats = implode(",", $in);
        $out_cats = implode(",", $out);
        $out_cats = preg_replace( '|[^0-9,]|', '', $out_cats );

        if ($in_cats != "" && $out_cats == "") { // get posts from from given cats only
            $where .= " AND p.ID IN (
						SELECT object_id
						FROM {$wpdb->term_relationships} AS r
							 JOIN {$wpdb->term_taxonomy} AS x ON x.term_taxonomy_id = r.term_taxonomy_id
							 JOIN {$wpdb->terms} AS t ON t.term_id = x.term_id
						WHERE x.taxonomy = 'category' AND t.term_id IN({$in_cats})
						)";
        } else if ($in_cats == "" && $out_cats != "") { // exclude posts from given cats only
            $where .= " AND p.ID NOT IN (
						SELECT object_id
						FROM {$wpdb->term_relationships} AS r
							 JOIN {$wpdb->term_taxonomy} AS x ON x.term_taxonomy_id = r.term_taxonomy_id
							 JOIN {$wpdb->terms} AS t ON t.term_id = x.term_id
						WHERE x.taxonomy = 'category' AND t.term_id IN({$out_cats})
						)";
        } else { // mixed, and possibly a heavy load on the DB
            $where .= " AND p.ID IN (
						SELECT object_id
						FROM {$wpdb->term_relationships} AS r
							 JOIN {$wpdb->term_taxonomy} AS x ON x.term_taxonomy_id = r.term_taxonomy_id
							 JOIN {$wpdb->terms} AS t ON t.term_id = x.term_id
						WHERE x.taxonomy = 'category' AND t.term_id IN({$in_cats})
						) AND p.ID NOT IN (
						SELECT object_id
						FROM {$wpdb->term_relationships} AS r
							 JOIN {$wpdb->term_taxonomy} AS x ON x.term_taxonomy_id = r.term_taxonomy_id
							 JOIN {$wpdb->terms} AS t ON t.term_id = x.term_id
						WHERE x.taxonomy = 'category' AND t.term_id IN({$out_cats})
						)";
        }

    }

    { // CUSTOM RANGE

        $interval = "";

        switch( $instance['range'] ){
            case "daily":
                $interval = "1 DAY";
                break;

            case "weekly":
                $interval = "1 WEEK";
                break;

            case "monthly":
                $interval = "1 MONTH";
                break;

            default:
                $interval = "1 DAY";
                break;
        }

        // order by views
        {
            $from = "( SELECT postid, IFNULL(SUM(pageviews), 0) AS pageviews FROM {$prefix}summary WHERE last_viewed > DATE_SUB('{$now}', INTERVAL {$interval}) GROUP BY postid ORDER BY pageviews DESC) v LEFT JOIN {$wpdb->posts} p ON v.postid = p.ID";
            $where .= " AND p.post_password = '' AND p.post_status = 'publish'";

            // ordered by views
            if ( "views" == $instance['order_by'] ) {
                $fields .= ", v.pageviews AS 'pageviews'";
            }
        }

        $orderby = '  ORDER BY v.pageviews DESC ';
        $query = "SELECT {$fields} FROM {$from} {$where} {$groupby} {$orderby} {$limit};";
    }

    $result = $wpdb->get_results($query);
    return $result;
}
