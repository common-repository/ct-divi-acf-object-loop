<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CTAOL_CtDiviAcfObjectLoop extends DiviExtension {

	public $gettext_domain = 'ct-divi-acf-object-loop';
	public $name = 'ct-divi-acf-object-loop';
	public $version = CTAOL_VERSION;

	public function __construct( $name = 'ct-divi-acf-object-loop', $args = array() ) {
		$this->plugin_dir       = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url   = plugin_dir_url( $this->plugin_dir );
		$this->_builder_js_data = array(
			'nonce' => array(
				'query_data' => wp_create_nonce( 'ctaol_get_acf_post_object_data' )
			)
		);
		parent::__construct( $name, $args );
	}

	protected function _enqueue_bundles() {
		$bundle_url = "{$this->plugin_dir_url}scripts/frontend-bundle.min.js";
		if ( et_core_is_fb_enabled() ) {
			wp_enqueue_script( "{$this->name}-frontend-bundle", $bundle_url, $this->_bundle_dependencies['frontend'], $this->version, true );
			$bundle_url = "{$this->plugin_dir_url}scripts/builder-bundle.min.js";
			wp_enqueue_script( "{$this->name}-builder-bundle", $bundle_url, $this->_bundle_dependencies['builder'], $this->version, true );
		} else {
			wp_register_script( "{$this->name}-frontend-bundle", $bundle_url, $this->_bundle_dependencies['frontend'], $this->version, true );
			wp_dequeue_style( "{$this->name}-styles" );
		}
	}
}

new CTAOL_CtDiviAcfObjectLoop;