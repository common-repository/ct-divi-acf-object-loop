<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CTAOL_CtDiviUtils {

	public function __construct() {
		add_filter( 'et_builder_load_actions', array( $this, 'add_our_ajax_action' ) );
		add_action( 'wp_ajax_ctaol_get_acf_post_object_data', array( $this, 'ajax_get_acf_post_object_data' ) );
	}

	public function ajax_get_acf_post_object_data() {
		if ( isset( $_POST['nonce'] ) && isset( $_POST['props'] ) && isset( $_POST['vb'] ) && wp_verify_nonce( sanitize_text_field( $_POST['nonce'] ), 'ctaol_get_acf_post_object_data' ) ) {
			$props         = sanitize_text_field( $_POST['props'] );
			$vb            = sanitize_text_field( $_POST['vb'] );
			$props         = json_decode( wp_kses_stripslashes( $props ), true );
			$props['ctvb'] = json_decode( wp_kses_stripslashes( $vb ), true );
			$posts_data    = self::get_acf_post_object_data( $props );
			wp_send_json( $posts_data );
		} else {
			wp_send_json( [ 'error' => 'Fail nonce verification' ] );
		}
	}

	static function get_acf_post_object_data( $props ) {
		$posts_data = array( 'error' => false, 'data' => [], 'extra' => [] );
		if ( class_exists( 'ACF' ) && ! empty( $props['acf_obj'] ) ) {
			$layouts_pt    = [ 'et_header_layout', 'et_body_layout', 'et_footer_layout', 'et_pb_layout' ];
			$is_singular   = is_singular();
			$is_template   = false;
			$is_vb_request = false;
			$run_query     = false;
			if ( isset( $props['ctvb']['type'] ) && isset( $props['ctvb']['id'] ) ) {
				$the_ID        = intval( $props['ctvb']['id'] );
				$is_template   = in_array( $props['ctvb']['type'], $layouts_pt );
				$is_singular   = ! $is_template;
				$is_vb_request = true;
			} else {
				$the_ID = $props['the_ID'];
			}
			$acf_post_object = get_field( $props['acf_obj'], $the_ID, false );
			$query_args      = array(
				'post_type'      => 'any',
				'post_status'    => 'any',
				'order'          => $props['order'],
				'orderby'        => $props['order_by'],
				'posts_per_page' => $props['number'] ?? 8,
			);
			if ( $is_singular && ! empty( $acf_post_object ) ) {
				if ( ! is_array( $acf_post_object ) ) {
					$acf_post_object = array( $acf_post_object );
				}
				$query_args['post__in'] = $acf_post_object;
				$run_query              = true;
			} else if ( $is_template ) {
				$posts_data['extra']['template'] = true;
				$run_query                       = true;
			}
			if ( $run_query ) {
				$query = new WP_Query( $query_args );
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						$post_data = array(
							'id'        => get_the_ID(),
							'post_type' => get_post_type(),
							'title'     => get_the_title(),
							'img_html'  => get_the_post_thumbnail(),
							'permalink' => get_the_permalink(),
							'classes'   => get_post_class(),
							'excerpt'   => get_the_excerpt(),
							'terms'     => ''
						);
						if ( $props['show_terms'] === 'on' || $is_vb_request ) {
							$post_terms = wp_get_post_terms( get_the_ID(), get_post_taxonomies() );
							foreach ( $post_terms as $post_term ) {
								$post_data['terms'] .= sprintf( '<span class="ctaol-post-term ctaol-post-term-%1$s">%1$s</span>', $post_term->name );
							}
						}
						if ( $post_data['post_type'] === 'attachment' ) {
							$post_data['img_html'] = wp_get_attachment_image( $post_data['id'], 'post-thumbnail' );
						}
						$post_data            = apply_filters( 'ctaol_get_post_data', $post_data, $props );
						$posts_data['data'][] = $post_data;
					}
				}
				wp_reset_postdata();
			}
		}

		return $posts_data;
	}

	public function add_our_ajax_action( $actions ) {
		return array_merge( $actions, array( 'ctaol_get_acf_post_object_data' ) );
	}
}

new CTAOL_CtDiviUtils;