<?php
class RecentPostsWidget extends WP_Widget
{
	var $themes_url;

	var $themes_dir;

	var $themes;

	function __construct() {
		parent::__construct(
			'flexible-recent-posts-widget',
			__( 'Flexible Recent Posts', 'frp' ),
			array( 'description' => __( 'Displays recent posts using flexible template system', 'frp' ) ),
			array( 'width'  => 400,
				   'height' => 350 )
		);

		$this->themes_url = plugin_dir_url( __FILE__ ) . 'themes/';
		$this->themes_dir = plugin_dir_path( __FILE__ ) . 'themes/';
		$this->themes = $this->get_themes();

		if ( is_active_widget( false, false, $this->id_base ) ) {
			add_action( 'wp_head', array( &$this, 'enqueue_styles' ) );
		}
	}

	function parse_instance_args( $instance ) {
		$instance = wp_parse_args( (array)$instance,
			array(
				'title'                     => '',
				'number'                    => 2,
				'all_posts_link_title'      => false,
				'all_posts_link_footer'     => true,
				'all_posts_title'           => __( 'All news', 'frp' ) . ' &gt;&gt;',
				'all_posts_link'            => '',
				'template'                  => '',
				'theme'				=> 'default',
				'all_categories'            => true,
				'categories'                => array()
			)
		);

		if ( empty( $instance['template'] ) ) {
			$default_theme = $this->get_theme( 'default' );

			if ( !empty( $default_theme ) ) {
				$instance['template'] = $default_theme['template'];
			}
		}

		return $instance;
	}

	function enqueue_styles() {
		wp_enqueue_style( 'frp-frontend', plugins_url( 'css/frp-front.css', __FILE__ ) );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$instance = $this->parse_instance_args( $instance );

		// If all categories checkbox is set, then we set categories list to empty and we will get all posts.
		if ( $instance['all_categories'] ) {
			$instance['categories'] = array();
		}

		$instance['categories'] = apply_filters( 'frp_categories', $instance['categories'] );
		$instance['all_posts_title'] = htmlspecialchars( $instance['all_posts_title'] );

		if ( !empty( $instance['categories'] ) || $instance['all_categories'] ) {
			$posts = get_posts(
				array(
					'numberposts' => $instance['number'],
					'category'    => implode( ',', $instance['categories'] ),
				)
			);

			if ( !empty( $posts ) ) {
				$category_link = ( empty( $instance['all_posts_link'] ) ) ? get_category_link( end( $instance['categories'] ) ) : $instance['all_posts_link'];

				// Save current global post variable to restore it after displaying widget.
				$tmp_post = $GLOBALS['post'];

				require( 'templates/recent-posts-widget.php' );

				$GLOBALS['post'] = $tmp_post;
			}
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = $new_instance['number'];
		$instance['template'] = $new_instance['template'];
		$instance['categories'] = $_POST['post_category'];
		$instance['all_categories'] = isset( $new_instance['all_categories'] ) ? true : false;
		$instance['all_posts_link_title'] = isset( $new_instance['all_posts_link_title'] ) ? true : false;
		$instance['all_posts_link_footer'] = isset( $new_instance['all_posts_link_footer'] ) ? true : false;
		$instance['all_posts_title'] = strip_tags( $new_instance['all_posts_title'] );
		$instance['all_posts_link'] = '';


		if ( !empty( $new_instance['all_posts_link'] ) ) {
			$instance['all_posts_link'] = strip_tags( $new_instance['all_posts_link'] );
		}

		return $instance;
	}

	function form( $instance ) {
		$plugin_dir = plugin_dir_url( __FILE__ );

		$instance = $this->parse_instance_args( $instance );

		$title = strip_tags( $instance['title'] );
		$template = esc_textarea( $instance['template'] );
		$theme_name = $instance['theme'];

		ob_start();
		wp_terms_checklist( 0, array( 'selected_cats' => $instance['categories'] ) );
		$categories = ob_get_contents();
		ob_end_clean();

		if ( $instance['all_categories'] ) {
			$categories = str_replace( 'type="checkbox"', 'type="checkbox" disabled="disabled"', $categories );
		}

		require( 'templates/recent-posts-form.php' );
	}

	function get_themes() {
		$templates = array();
		$themes_dir = glob( $this->themes_dir . '*', GLOB_ONLYDIR );

		foreach ( $themes_dir as $path ) {
			$theme_name = basename( $path );
			$theme = $this->get_theme( $theme_name );

			if ( !empty( $theme ) ) {
				$templates[$theme_name] = $theme;
			}
		}

		return $templates;
	}

	function get_theme( $theme_name ) {
		$theme = array();

		$path = $this->themes_dir . $theme_name;
		$json_file = $path . '/' . $theme_name . '.json';
		$template_file = $path . '/template.php';

		if ( is_file( $json_file ) && is_file( $template_file ) ) {
			$theme_info = json_decode( file_get_contents( $json_file ), true );
			$template = file_get_contents( $template_file );

			if ( !is_null( $theme_info ) && $template != false && !empty( $theme_info['name'] ) && !empty( $theme_info['description'] ) ) {
				$theme = array(
					'readable_name' => $theme_info['name'],
					'description'   => $theme_info['description'],
					'template'      => $template,
					'theme_url'     => $this->themes_url . $theme_name . '/'
				);

				if ( is_file( $path . '/frp-' . $theme_name . '.css' ) ) {
					$theme['css'] = true;
				}

				if ( is_file( $path . '/screenshot-preview.png' ) ) {
					$theme['preview'] = true;

					if ( is_file( $path . '/screenshot.png' ) ) {
						$theme['screenshot'] = true;
					}
				}
			}
		}

		return $theme;
	}
}

?>