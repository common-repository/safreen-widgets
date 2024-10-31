<?php
/**
 * Plugin Name: Safreen widgets
 * Description: Adds support for a number of content types in your Wordpress installation.
 * Version: 1.6
 * Author: Imon Themes
 * Author URI: http://www.imonthemes.com
 * License: GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: safreen-widgets
 * Domain Path: translation
 */

 define( 'SAFREEN_WIDGTE_PATH',  plugin_dir_path( __FILE__ ) );

// load plugin text domain
function safreen_init() {
	load_plugin_textdomain( 'safreen-widgets', false, dirname( plugin_basename( __FILE__ ) ) . '/translation' );
}
add_action('plugins_loaded', 'safreen_init');


function safreen_css_and_js() {
wp_register_style( 'safree_custom_css', plugin_dir_url( __FILE__ ) . 'safreen_widgets_custom_css.css' );
wp_enqueue_style( 'safree_custom_css' );

wp_register_script( 'safreen_custom_script', plugin_dir_url( __FILE__ ) . 'safreen_widget.js' );
wp_enqueue_script( 'safreen_custom_script' );
}
add_action( 'admin_enqueue_scripts','safreen_css_and_js');




function safreen_import_files() {

 return array(
	 array(
		 'import_file_name'             => 'Demo1',
		 'categories'                   => array( 'Free' ),
		 'local_import_file'            => trailingslashit( SAFREEN_WIDGTE_PATH ) . 'demo/demo.xml',
		 'local_import_widget_file'     => trailingslashit( SAFREEN_WIDGTE_PATH ) . 'demo/demo.wie',
		 'local_import_customizer_file' => trailingslashit( SAFREEN_WIDGTE_PATH ) . 'demo/demo.dat',
		 'import_preview_image_url'     => 'http://safreen.imonthemes.com/wp-content/uploads/2017/04/demo11-1.jpg',
		 'preview_url'                  => 'http://safreen.imonthemes.com/demo1/',
	 ),
	 array(
		 'import_file_name'             => 'Demo 2',
		 'categories'                   => array( 'Free'),
		 'local_import_file'            => trailingslashit( SAFREEN_WIDGTE_PATH ) . 'demo/demo.xml',
		 'local_import_widget_file'     => trailingslashit( SAFREEN_WIDGTE_PATH) . 'demo/demo.wie',
		 'local_import_customizer_file' => trailingslashit( SAFREEN_WIDGTE_PATH) . 'demo/demo.dat',
		 'import_preview_image_url'     => 'http://safreen.imonthemes.com/wp-content/uploads/2017/04/demo11-1.jpg',
		 'preview_url'                  => 'http://safreen.imonthemes.com/demo1/ ',
	 ),

 );
}
add_filter( 'pt-ocdi/import_files', 'safreen_import_files' );


add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );

if ( ! function_exists( 'safreen_after_import' ) ) :
function safreen_after_import( ) {

			 //Set Menu
			 $top_menu = get_term_by('name', 'imonthemes', 'nav_menu');
			 set_theme_mod( 'nav_menu_locations' , array(
						 'primary' => $top_menu->term_id,
						)
			 );
			 //Set Front page
	 $page = get_page_by_title( 'Home');
	 if ( isset( $page->ID ) ) {
		update_option( 'page_on_front', $page->ID );
		update_option( 'show_on_front', 'page' );
	 }

}
add_action( 'pt-ocdi/after_import', 'safreen_after_import' );
endif;



/*****************************************/
/******          WIDGETS     *************/
/*****************************************/

add_action('widgets_init', 'safreen_register_widgets');

function safreen_register_widgets() {

	register_widget('safreen_aboutus');
	register_widget('safreen_ourteam');
	register_widget('safreen_ourclient');

	$safreen_sidebars = array ( 'sidebar-aboutus' => 'sidebar-aboutus','sidebar-ourteam' => 'sidebar-ourteam','sidebar-ourclient' => 'sidebar-ourclient');

	/* Register sidebars */
	foreach ( $safreen_sidebars as $safreen_sidebar ):


			if( $safreen_sidebar == 'sidebar-aboutus' ):

			$safreen_name = __('About Us', 'safreen-widgets');

			elseif( $safreen_sidebar == 'sidebar-ourteam' ):

			$safreen_name = __('Our Team', 'safreen-widgets');

			elseif( $safreen_sidebar == 'sidebar-ourclient' ):

			$safreen_name = __('Our Client', 'safreen-widgets');
            endif;

    endforeach;}

// include widget file

include 'aboutus.php';
include 'ourteam.php';
include 'ourclient.php';
