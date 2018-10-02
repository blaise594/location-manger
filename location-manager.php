<?php
/**
 * Plugin Name: Location Manager
 * Plugin URI: http://danielrogers.info
 * Description: Location manager plugin
 * Author: Daniel Rogers
 * Author URI: http://danielrogers.info
 * Version: 1.0
*/
add_action( 'init', 'location_post_type' );

function location_post_type() {
	$labels = array(
		'name'               => _x( 'Locations', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Location', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Locations', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Location', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'location', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Location', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Location', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Location', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Location', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Locations', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Locations', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Locations:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No locations found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No locations found in Trash.', 'your-plugin-textdomain' )
	);

	$args = array(
        'labels'             => $labels,
        'menu_icon'          => 'dashicons-admin-site',
        'description'        => __( 'List of locations.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
        'query_var'          => true,
        //Defines the rules for the URL
		'rewrite'            => array( 'slug' => 'location' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
        'menu_position'      => null,
        //Added support for custom fields
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
	);

	register_post_type( 'location', $args );
}

add_filter('the_content', 'prepend_location_data' );
function prepend_location_data( $content ){
    if( is_singular('location')){
        //Assigns custom field of City to a variable 
        $city=get_post_meta(get_the_ID(), 'City', true);
        //Assigns custom field of State to a variable
        $state=get_post_meta(get_the_ID(), 'State', true);
        //Variable that controls the html output that is displayed
        $html=
        '
        <div class="location-meta">
            Address: '.$city.', '.$state.'
        </div>
        ';


        return $content . $html;
    }
    return $content;
}