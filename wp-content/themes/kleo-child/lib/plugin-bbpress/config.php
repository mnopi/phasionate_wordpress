<?php

/* 
 * bbPress specific configurations
 * @package WordPress
 * @subpackage Phasionate
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */


//register our own css file
if(!is_admin()){ add_action('bbp_enqueue_scripts', 'kleo_bbpress_register_style',15); }


function kleo_bbpress_register_style()
{
	global $bbp;

	wp_dequeue_style( 'bbp-default-bbpress' );
	wp_dequeue_style( 'bbp-default' );
	wp_enqueue_style( 'kleo-bbpress', THEME_URI.'/bbpress/css/bbpress.css');

}


function kleo_bbp_no_breadcrumb ($param) {
    return true;
}
add_filter ('bbp_no_breadcrumb', 'kleo_bbp_no_breadcrumb');


//Change page layout to match theme options settings
add_filter('kleo_page_layout', 'kleo_bbpress_change_layout');

function kleo_bbpress_change_layout($layout) {
	if (is_bbpress()) {
		$bbpress_template = sq_option('bbpress_sidebar', 'default');
		if ( $bbpress_template != 'default' ) {
			$layout = $bbpress_template;
		}
	}
	
	return $layout;
}



/*
 * Search in a single forum page
 */
function my_bbp_filter_search_results( $r ){

    //Get the submitted forum ID (from the hidden field added in step 2)
    $forum_id = sanitize_title_for_query( $_GET['bbp_search_forum_id'] );

    //If the forum ID exits, filter the query
    if( $forum_id && is_numeric( $forum_id ) ){

        $r['meta_query'] = array(
            array(
                'key' => '_bbp_forum_id',
                'value' => $forum_id,
                'compare' => '=',
            )
        );

    }

    return $r;
}
add_filter( 'bbp_after_has_search_results_parse_args' , 'my_bbp_filter_search_results' );


function my_bbp_search_form(){
    ?>
    <div class="bbp-search-form">

        <?php bbp_get_template_part( 'form', 'search' ); ?>

    </div>
<?php
}
add_action( 'bbp_template_before_single_forum', 'my_bbp_search_form' );