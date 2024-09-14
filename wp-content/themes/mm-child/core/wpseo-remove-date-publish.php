<?php

add_filter(
	'wpseo_frontend_presenter_classes',
	function ( $filter ) {

		if (($key = array_search('Yoast\WP\SEO\Presenters\Open_Graph\Article_Modified_Time_Presenter', $filter)) !== false) {
			unset($filter[$key]);
		}

		return $filter;
	}
);

add_filter(
	'wpseo_frontend_presenter_classes',
	function ( $filter ) {

		if (($key = array_search('Yoast\WP\SEO\Presenters\Open_Graph\Article_Published_Time_Presenter', $filter)) !== false) {
			unset($filter[$key]);
		}

		return $filter;
	}
);

add_filter( 'wpseo_schema_article', 'mm_yoast_modify_schema_graph_pieces' );
add_filter( 'wpseo_schema_webpage', 'mm_yoast_modify_schema_graph_pieces' );
if (!function_exists('mm_yoast_modify_schema_graph_pieces')) {
	function mm_yoast_modify_schema_graph_pieces( $data ) {
		unset($data['datePublished']);
		unset($data['dateModified']);
		return $data;
	}
}
?>