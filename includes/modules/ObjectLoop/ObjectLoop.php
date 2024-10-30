<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'CTAOL_ObjectLoop' ) ) {
	class CTAOL_ObjectLoop extends ET_Builder_Module {

		public $slug = 'ctaol_object_loop';
		public $vb_support = 'on';
		public $icon = "W";

		protected $module_credits = array(
			'module_uri' => 'https://divicoding.com',
			'author'     => 'Divi Coding',
			'author_uri' => 'https://divicoding.com',
		);

		public function init() {
			$this->name             = __( 'ACF Object Loop', 'ct-divi-acf-object-loop' );
			$this->folder_name      = 'divi_coding';
			$this->main_css_element = '%%order_class%%';
			$this->help_videos      = array(
				array(
					'id'   => 'CtSiD8B4ynw',
					'name' => __( 'An introduction to the Divi ACF Object Loop module', 'ct-divi-acf-object-loop' ),
				),
			);
		}

		public function get_settings_modal_toggles() {
			return array(
				'general'  => array(
					'toggles' => array(
						'main_content' => array(
							'title' => __( 'Content', 'ct-divi-acf-object-loop' ),
						),
					),
				),
				'advanced' => array(
					'toggles' => array(
						'layout' => array(
							'title' => __( 'Layout', 'ct-divi-acf-object-loop' ),
						),
					),
				),
			);
		}

		public function get_advanced_fields_config() {
			return array(
				// Content tab
				'background'   => array(
					'use_background_image'   => false,
					'use_background_video'   => false,
					'use_background_pattern' => false,
					'use_background_mask'    => false
				),
				'link_options' => false,
				// Design tab
				'text'         => false,
				'fonts'        => array(
					'title'   => array(
						'label'        => __( 'Title', 'ct-divi-acf-object-loop' ),
						'css'          => array( 'main' => "$this->main_css_element .ctaol-post-title" ),
						'header_level' => array( 'default' => 'h3' ),
						'font_size'    => array( 'default' => '18px' ),
						'line_height'  => array( 'default' => '1.2em' )
					),
					'terms'   => array(
						'label'           => __( 'Terms', 'ct-divi-acf-object-loop' ),
						'hide_text_align' => true,
						'css'             => array(
							'main' => "$this->main_css_element .ctaol-post-term",
						),
						'font_size'       => array( 'default' => '14px' ),
						'line_height'     => array( 'default' => '1.7em' )
					),
					'excerpt' => array(
						'label'       => __( 'Excerpt', 'ct-divi-acf-object-loop' ),
						'css'         => array( 'main' => "$this->main_css_element .ctaol-post-excerpt" ),
						'font_size'   => array( 'default' => '14px' ),
						'line_height' => array( 'default' => '1.7em' )
					),
					'link'    => array(
						'label'       => __( 'Link', 'ct-divi-acf-object-loop' ),
						'css'         => array( 'main' => "$this->main_css_element .ctaol-post-link" ),
						'font_size'   => array( 'default' => '14px' ),
						'line_height' => array( 'default' => '1.7em' )
					),
				),
				'borders'      => array(
					'default' => array(
						'css'          => array(
							'main' => array(
								'border_radii'        => "$this->main_css_element .ctaol-post",
								'border_styles'       => "$this->main_css_element .ctaol-post",
								'border_styles_hover' => "$this->main_css_element .ctaol-post:hover",
							),
						),
						'defaults'     => array(
							'border_radii'  => 'on||||',
							'border_styles' => array(
								'width' => '1px',
								'color' => '#d8d8d8',
								'style' => 'solid',
							),
						),
						'label_prefix' => __( 'Posts', 'ct-divi-acf-object-loop' ),
					),
				),
				'box_shadow'   => array(
					'default' => array(
						'css' => array(
							'main' => "$this->main_css_element .ctaol-post",
						),
					),
				),
				'filters'      => false,
			);
		}

		public function get_fields() {
			return array(
				'acf_obj'      => array(
					'label'       => __( 'ACF Object Field Name', 'ct-divi-acf-object-loop' ),
					'description' => __( 'Enter the ACF Post Object field name.', 'ct-divi-acf-object-loop' ),
					'type'        => 'text',
					'toggle_slug' => 'main_content',
				),
				'number'       => array(
					'label'       => __( 'Post Number', 'ct-divi-acf-object-loop' ),
					'description' => __( 'Max number of posts to show.', 'ct-divi-acf-object-loop' ),
					'type'        => 'text',
					'default'     => 8,
					'toggle_slug' => 'main_content',
				),
				'order'        => array(
					'label'       => __( 'Order', 'ct-divi-acf-object-loop' ),
					'type'        => 'select',
					'options'     => array(
						'DESC' => __( 'Descending', 'ct-divi-acf-object-loop' ),
						'ASC'  => __( 'Ascending', 'ct-divi-acf-object-loop' ),
					),
					'default'     => 'DESC',
					'toggle_slug' => 'main_content',
				),
				'order_by'     => array(
					'label'       => __( 'Order By', 'ct-divi-acf-object-loop' ),
					'type'        => 'select',
					'options'     => array(
						'post__in' => __( 'Maintain selection order', 'ct-divi-acf-object-loop' ),
						'title'    => __( 'Title', 'ct-divi-acf-object-loop' ),
						'name'     => __( 'Slug', 'ct-divi-acf-object-loop' ),
						'date'     => __( 'Date', 'ct-divi-acf-object-loop' ),
						'rand'     => __( 'Random', 'ct-divi-acf-object-loop' ),
					),
					'default'     => 'post__in',
					'toggle_slug' => 'main_content',
				),
				'show_image'   => array(
					'label'       => __( 'Show Feature Image', 'ct-divi-acf-object-loop' ),
					'type'        => 'yes_no_button',
					'options'     => array(
						'on'  => __( 'On', 'ct-divi-acf-object-loop' ),
						'off' => __( 'Off', 'ct-divi-acf-object-loop' ),
					),
					'default'     => 'on',
					'toggle_slug' => 'main_content',
				),
				'show_title'   => array(
					'label'       => __( 'Show Title', 'ct-divi-acf-object-loop' ),
					'type'        => 'yes_no_button',
					'options'     => array(
						'on'  => __( 'On', 'ct-divi-acf-object-loop' ),
						'off' => __( 'Off', 'ct-divi-acf-object-loop' ),
					),
					'default'     => 'on',
					'toggle_slug' => 'main_content',
				),
				'show_terms'   => array(
					'label'       => __( 'Show Post Terms', 'ct-divi-acf-object-loop' ),
					'type'        => 'yes_no_button',
					'options'     => array(
						'on'  => __( 'On', 'ct-divi-acf-object-loop' ),
						'off' => __( 'Off', 'ct-divi-acf-object-loop' ),
					),
					'default'     => 'off',
					'toggle_slug' => 'main_content',
				),
				'show_excerpt' => array(
					'label'       => __( 'Show Excerpt', 'ct-divi-acf-object-loop' ),
					'type'        => 'yes_no_button',
					'options'     => array(
						'on'  => __( 'On', 'ct-divi-acf-object-loop' ),
						'off' => __( 'Off', 'ct-divi-acf-object-loop' ),
					),
					'default'     => 'on',
					'toggle_slug' => 'main_content',
				),
				'show_link'    => array(
					'label'       => __( 'Show Link', 'ct-divi-acf-object-loop' ),
					'type'        => 'yes_no_button',
					'options'     => array(
						'on'  => __( 'On', 'ct-divi-acf-object-loop' ),
						'off' => __( 'Off', 'ct-divi-acf-object-loop' ),
					),
					'default'     => 'on',
					'toggle_slug' => 'main_content',
				),
				'link_txt'     => array(
					'label'       => __( 'Link Text', 'ct-divi-acf-object-loop' ),
					'default'     => __( 'Learn More', 'ct-divi-acf-object-loop' ),
					'type'        => 'text',
					'show_if'     => array( 'show_link' => 'on' ),
					'toggle_slug' => 'main_content',
				),
				'click_action' => array(
					'label'       => __( 'Click Action', 'ct-divi-acf-object-loop' ),
					'description' => __( 'Select an action for when the user click on the post item card.', 'ct-divi-acf-object-loop' ),
					'type'        => 'select',
					'options'     => array(
						'none' => __( 'None', 'ct-divi-acf-object-loop' ),
						'link' => __( 'Open post link', 'ct-divi-acf-object-loop' ),
					),
					'default'     => 'none',
					'toggle_slug' => 'main_content',
				),
				'link_target'  => array(
					'label'       => __( 'Link Target', 'ct-divi-acf-object-loop' ),
					'description' => __( 'Select an action for when the user click on the post item card.', 'ct-divi-acf-object-loop' ),
					'type'        => 'select',
					'options'     => array(
						'_self'  => __( 'Open in the same window', 'ct-divi-acf-object-loop' ),
						'_blank' => __( 'Open in a new window', 'ct-divi-acf-object-loop' ),
					),
					'default'     => '_self',
					'toggle_slug' => 'main_content',
				),
				// Layout
				'columns'      => array(
					'label'          => __( 'Columns', 'ct-divi-acf-object-loop' ),
					'description'    => __( 'Adjust the number of columns.', 'ct-divi-acf-object-loop' ),
					'type'           => 'range',
					'default'        => 4,
					'default_unit'   => '',
					'range_settings' => array(
						'min'  => 1,
						'max'  => 20,
						'step' => 1,
					),
					'mobile_options' => true,
					'validate_unit'  => true,
					'toggle_slug'    => 'layout',
					'tab_slug'       => 'advanced'
				),
				'gaps'         => array(
					'label'          => __( 'Gap', 'ct-divi-acf-object-loop' ),
					'description'    => __( 'Adjust the space between columns and above items.', 'ct-divi-acf-object-loop' ),
					'type'           => 'range',
					'default'        => '20px',
					'default_unit'   => 'px',
					'range_settings' => array(
						'min'  => 1,
						'max'  => 300,
						'step' => 1,
					),
					'mobile_options' => true,
					'validate_unit'  => true,
					'toggle_slug'    => 'layout',
					'tab_slug'       => 'advanced'
				),
			);
		}

		public function before_render() {
			wp_enqueue_script( 'ct-divi-acf-object-loop-frontend-bundle' );
			wp_enqueue_style( 'ct-divi-acf-object-loop-styles' );
		}

		public function render( $attrs, $content, $render_slug ) {
			$html_output           = '';
			$this->props['the_ID'] = get_queried_object_id();
			$posts_data            = CTAOL_CtDiviUtils::get_acf_post_object_data( $this->props );
			if ( ! $posts_data['error'] && ! empty( $posts_data['data'] ) ) {
				$posts_html = '';
				foreach ( $posts_data['data'] as $post ) {
					$image   = $this->props['show_image'] === 'on' && ! empty( $post['img_html'] ) ? sprintf( '<figure class="ctaol-post-figure">%1$s</figure>', $post['img_html'] ) : '';
					$title   = $this->props['show_title'] === 'on' ? sprintf( '<%2$s class="ctaol-post-title">%1$s</%2$s>', $post['title'], $this->props['title_level'] ) : '';
					$terms   = $this->props['show_terms'] === 'on' ? sprintf( '<div class="ctaol-post-terms">%1$s</div>', $post['terms'] ) : '';
					$excerpt = $this->props['show_excerpt'] === 'on' && ! empty( $post['excerpt'] ) ? sprintf( '<div class="ctaol-post-excerpt">%1$s</div>', $post['excerpt'] ) : '';
					$link    = $this->props['show_link'] === 'on' ? sprintf( '<a class="ctaol-post-link" href="%1$s" target="%3$s">%2$s</a>', $post['permalink'], $this->props['link_txt'], $this->props['link_target'] ) : '';

					$content = [
						'image'   => $image,
						'title'   => $title,
						'terms'   => $terms,
						'excerpt' => $excerpt,
						'link'    => $link
					];

					$item_html = apply_filters( 'ctaol_item_html', implode( '', $content ), $this->props, $content, $post );

					$posts_html .= sprintf( '<article class="ctaol-post %3$s" data-url="%2$s">%1$s</article>', $item_html, $post['permalink'], implode( ' ', $post['classes'] ) );
				}
				$html_output = sprintf( '<div class="ctaol-main-container" data-action="%2$s" data-target="%3$s"><div class="ctaol-posts-grid">%1$s</div></div>', $posts_html, $this->props['click_action'], $this->props['link_target'] );
			}

			$this->responsive_css( $render_slug );

			return $html_output;
		}

		public function responsive_css( $render_slug ) {
			$gaps_responsive_active    = et_pb_get_responsive_status( $this->props['gaps_last_edited'] );
			$gaps_desktop_css          = $this->props['gaps'];
			$gaps_values               = array(
				'desktop' => $gaps_desktop_css,
				'tablet'  => $gaps_responsive_active ? $this->props['gaps_tablet'] : $gaps_desktop_css,
				'phone'   => $gaps_responsive_active ? $this->props['gaps_phone'] : $gaps_desktop_css
			);
			$columns_responsive_active = et_pb_get_responsive_status( $this->props['columns_last_edited'] );
			$columns_desktop_css       = str_repeat( '1fr ', intval( $this->props['columns'] ) );
			$columns_values            = array(
				'desktop' => $columns_desktop_css,
				'tablet'  => $columns_responsive_active ? str_repeat( '1fr ', intval( $this->props['columns_tablet'] ) ) : $columns_desktop_css,
				'phone'   => $columns_responsive_active ? str_repeat( '1fr ', intval( $this->props['columns_phone'] ) ) : $columns_desktop_css
			);
			et_pb_responsive_options()->generate_responsive_css( $columns_values, '%%order_class%% .ctaol-posts-grid', 'grid-template-columns', $render_slug, '', '' );
			et_pb_responsive_options()->generate_responsive_css( $gaps_values, '%%order_class%% .ctaol-posts-grid', 'grid-gap', $render_slug, '', '' );
		}
	}

	new CTAOL_ObjectLoop;
}