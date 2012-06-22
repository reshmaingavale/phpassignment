<?php
/*
Plugin Name: Flexible Recent Posts
Plugin URI: http://steelrat.info/
Description: Displays recent posts using flexible template system.
Version: 0.3
Author: SteelRat
Author URI: http://steelrat.info/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
add_action( 'widgets_init', 'frp_widgets_init' );

add_action( 'admin_print_styles-widgets.php', 'frp_admin_print_styles_widgets' );
add_action( 'admin_print_scripts-widgets.php', 'frp_admin_print_scripts_widgets' );

add_shortcode( 'frp_title', 'frp_title' );
add_shortcode( 'frp_thumbnail', 'frp_thumbnail' );
add_shortcode( 'frp_excerpt', 'frp_excerpt' );
add_shortcode( 'frp_date', 'frp_date' );
add_shortcode( 'frp_link', 'frp_link' );
add_shortcode( 'frp_author', 'frp_author' );

add_filter( 'plugin_row_meta', 'frp_plugin_row_meta', 10, 2 );

$frp_options = array(
	'faq_page'             => 'http://wordpress.org/extend/plugins/flexible-recent-posts/faq/',
	'feature_request_page' => 'http://frp.idea.informer.com/',
	'flattr_page'          => 'https://flattr.com/thing/646464',
);

function frp_plugin_row_meta( $plugin_meta, $plugin_file ) {
	global $frp_options;

	if ( strpos( $plugin_file, basename( __FILE__ ) ) ) {
		$plugin_meta[] = '<a href="' . $frp_options['feature_request_page'] . '" title="' . __( 'Visit feature request page', 'frp' ) . '">' . __( 'Feature request', 'frp' ) . '</a>';
		$plugin_meta[] = '<a href="' . $frp_options['faq_page'] . '" title="' . __( 'Visit FAQ page', 'frp' ) . '">' . __( 'FAQ', 'frp' ) . '</a>';
	}

	return $plugin_meta;
}

function frp_admin_print_scripts_widgets() {
	global $frp_options;

	wp_enqueue_script( 'rangyinputs', plugins_url( '', __FILE__ ) . '/scripts/textinputs_jquery.js', array( 'jquery' ) );
	wp_enqueue_script( 'frp', plugins_url( '', __FILE__ ) . '/scripts/frp.js', array( 'jquery', 'rangyinputs' ) );

	$options = array(
		'shortcodes' => array(
			'title'       => '[frp_title]',
			'thumbnail'   => '[frp_thumbnail size="32x32"]',
			'excerpt'     => '[frp_excerpt]',
			'date'        => '[frp_date format="d.m.Y"]',
			'link'        => '[frp_link]',
			'author'      => '[frp_author]',
		),
		'flattrLink' => $frp_options['flattr_page'],
		'confirmReplace' => __( "Do you want to replace current template with theme's one?", 'frp' )
	);

	wp_localize_script( 'frp', 'frpOptions', $options );
}

function frp_admin_print_styles_widgets() {
	// Load native stylesheet for editor buttons.
	wp_print_styles( 'editor-buttons' );

	wp_enqueue_style( 'frp', plugins_url( '', __FILE__ ) . '/css/frp-admin.css' );
}

function frp_widgets_init() {
	load_plugin_textdomain( 'frp', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

	require_once( 'class-recent-posts-widget.php' );

	register_widget( 'RecentPostsWidget' );
}

function frp_title() {
	return get_the_title();
}

function frp_excerpt() {
	global $pages, $page;

	// Replacing current pages with our widget's page to make filter work properly.
	$temp_pages = $pages;
	$temp_page = $page;
	$page = 1;
	$pages[0] = $GLOBALS['post']->post_content;

	$excerpt = get_the_excerpt();

	// Restore current pages.
	$page = $temp_page;
	$pages = $temp_pages;

	return $excerpt;
}

function frp_date( $atts ) {
	$atts = shortcode_atts( array(
		'format'     => '',
		'time_since' => '0'
	), $atts );

	return ( $atts['time_since'] ) ? frp_time_ago( get_the_time( 'U' ) ) : get_the_date( $atts['format'] );
}

function frp_thumbnail( $atts ) {
	$atts = shortcode_atts( array(
		'size' => '32x32',
	), $atts );

	if ( preg_match( '/^(\d+)x(\d+)$/', $atts['size'], $size ) == 1 ) {
		// Remove first element from array. It's matched line. Leave only two sizes.
		array_splice( $size, 0, 1 );
		$atts['size'] = $size;
	}

	return get_the_post_thumbnail( null, $atts['size'] );
}

function frp_link() {
	return get_permalink();
}

function frp_author( $atts ) {
	$atts = shortcode_atts( array(
		'link' => '1',
	), $atts );

	return ( $atts['link'] ) ? get_the_author_link() : get_the_author();
}

function frp_time_ago( $time ) {
	$current_time = current_time( 'timestamp' );
	$value = $current_time - $time;

	$units = array( 'second', 'minute', 'hour' );
	$max = array( 60, 60, 24 );

	foreach ( $units as $id => $unit ) {
		if ( $value < $max[$id] ) {
			$format = apply_filters( 'frp_time_ago_format', _n( '%d ' . $unit . ' ago', '%d ' . $unit . 's ago', $value, 'frp' ), $value, $unit . 's' );

			return sprintf( $format, $value );
		}

		$value = floor( $value / $max[$id] );
	}

	$ago = apply_filters( 'frp_day_month_ago', date( 'j M', $time ), $time );

	$year = date( 'y', $time );

	if ( $year != date( 'y', $current_time ) ) {
		$ago .= ' ' . $year;
	}

	return $ago;
}