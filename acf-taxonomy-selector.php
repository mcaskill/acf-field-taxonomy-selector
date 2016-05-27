<?php

/**
 * Plugin Name: Advanced Custom Fields: Taxonomy Selector
 * Plugin URI: https://github.com/mcaskill/acf-field-taxonomy-selector
 * Description: Provides a taxonomy selector field type for Advanced Custom Fields
 * Version: 0.1.0
 * Author: Chauncey McAskill
 * Author URI: https://mcaskill.ca
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

/** Exit if accessed directly */
if ( ! defined('ABSPATH') ) exit;

if ( ! class_exists('acf_field_taxonomy_selector_plugin') ) :

	/**
	 * ACF Field Type Loader Class
	 */
	class acf_field_taxonomy_selector_plugin
	{
		/**
		 * Return a new ACF Field Type Loader
		 */
		public function __construct()
		{
			$this->settings = [
				'version' => '1.0.0',
				'url'     => plugin_dir_url( __FILE__ ),
				'path'    => plugin_dir_path( __FILE__ )
			];

			/*
			$domain = 'acf-taxonomy-selector';
			$mofile = trailingslashit(dirname(__FILE__)) . 'lang/' . $domain . '-' . get_locale() . '.mo';
			load_textdomain( $domain, $mofile );
			*/

			/** For version 5+ */
			add_action( 'acf/include_field_types', [ $this, 'include_field_types' ] );

			/** For version 4 */
			add_action( 'acf/register_fields', [ $this, 'include_field_types' ] );
		}

		/*
		 * Include the field type class
		 *
		 * @param	integer  $version  Major ACF version. Defaults to 4.
		 * @return  void
		 */
		public function include_field_types( $version = 4 )
		{
			$name = basename( __FILE__, '.php' );
			include_once "fields/{$name}-v{$version}.php";
		}
	}

	new acf_field_taxonomy_selector_plugin();

endif;
