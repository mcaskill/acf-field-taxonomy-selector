<?php

/** Exit if accessed directly */
if ( ! defined('ABSPATH') ) exit;

if ( ! class_exists('acf_field_taxonomy_selector') ) :

	/**
	 * Taxonomy Selector Field Class for ACF 4
	 *
	 * All the logic for this field type
	 *
	 * @package McAskill\ACF\Fields
	 */
	class acf_field_taxonomy_selector extends acf_field
	{
		/**
		 * Store information such as directory / path.
		 *
		 * @var array
		 */
		protected $settings;

		/**
		 * Return a new ACF Field Type
		 *
		 * This method will setup the field type data.
		 *
		 * @param  array  $settings  Plugin information.
		 */
		function __construct( array $settings )
		{
			$this->name     = 'taxonomy_selector';
			$this->label    = __('Taxonomy Selector');
			$this->category = __('Relational', 'acf');
			$this->defaults = [
				'field_type'    => 'checkbox',
				'layout'        => 'vertical',
				'optgroup'      => false,
				'multiple'      => 0,
				'allow_null'    => 0,
				'return_format' => 'id',
			];

			parent::__construct();

			$this->settings = $settings;
		}

		/**
		 * Create the field's settings.
		 *
		 * @type    action
		 *
		 * @param   array  $field  The field being edited.
		 * @return  void
		 */
		function create_options( $field )
		{
			$field = array_merge( $this->defaults, $field );

			// Key is needed in the field names to correctly save the data
			$key = $field['name'];

			include '../views/field-settings-v4.php';
		}

		/**
		 * Create the HTML interface for your field
		 *
		 * @type    action
		 *
		 * @param   array  $field  The field being rendered.
		 * @return  void
		 */
		function create_field( $field )
		{
			$field = array_merge( $this->defaults, $field );

			$args = [
				'public' => true
			];

			/**
			 * Filters the arguments for retrieving a list of registered taxonomy objects.
			 *
			 * @param array  $args   Array of arguments to match against the taxonomy objects.
			 * @param array  $field  An array holding all the field's data.
			 */
			$args = apply_filters( 'acf/fields/taxonomy_selector/args', $args, $field );
			$args = apply_filters( "acf/fields/taxonomy_selector/args/name={$field['_name']}", $args, $field );
			$args = apply_filters( "acf/fields/taxonomy_selector/args/key={$field['key']}", $args, $field );

			$excluded = [ 'post_format', 'nav_menu', 'link_category' ];

			/**
			 * Filters the list taxonomies to exclude.
			 *
			 * @param string[]  $excluded   Array of taxonomy names.
			 * @param array     $field      An array holding all the field's data.
			 */
			$excluded = apply_filters( 'acf/fields/taxonomy_selector/excluded_taxonomies', $excluded, $field );
			$excluded = apply_filters( "acf/fields/taxonomy_selector/excluded_taxonomies/name={$field['_name']}", $excluded, $field );
			$excluded = apply_filters( "acf/fields/taxonomy_selector/excluded_taxonomies/key={$field['key']}", $excluded, $field );

			$taxonomies = get_taxonomies( $args, 'objects' );

			foreach ( $taxonomies as $taxonomy ) {
				if ( in_array( $taxonomy->name, $excluded ) ) {
					continue;
				}

				$field['choices'][ $taxonomy->name ] = $taxonomy->labels->name;
			}

			switch ( $field['field_type'] ) {
				case 'select':
				case 'multi_select':

					$field['type']     = 'select';
					$field['multiple'] = intval( 'multi_select' === $field['field_type'] );

					break;

				case 'radio':
				case 'checkbox':

					$field['type']     = $field['field_type'];
					$field['multiple'] = intval( 'checkbox' === $field['field_type'] );

					break;
			}

			do_action( 'acf/create_field', $field );
		}

		/**
		 * Update value
		 *
		 * This filter is appied to the $value before it is updated in the DB.
		 *
		 * @type    filter
		 *
		 * @param   string[]  $value    The value which will be saved in the database.
		 * @param   integer   $post_id  The $post_id of which the value will be saved.
		 * @param   array     $field    The field array holding all the field options.
		 *
		 * @return	$value - the modified value.
		 */
		public function update_value( $value, $post_id, $field )
		{
			if ( is_array($value) ) {
				$value = array_filter($value);
			}

			return $value;
		}

		/**
		 * Format the value for the API
		 *
		 * This filter is appied to the $value after it is loaded from the DB and
		 * before it is passed back to the API functions such as the_field().
		 *
		 * @type    filter
		 *
		 * @param   string[]  $value    The value which was loaded from the database.
		 * @param   integer   $post_id  The $post_id from which the value was loaded.
		 * @param   array     $field    The field array holding all the field options.
		 *
		 * @return  array[]   The modified value.
		 */
		public function format_value_for_api( $value, $post_id, $field )
		{
			if ( empty($value) ) {
				return $value;
			}

			$value = acf_force_type_array( $value );

			if ( $field['return_format'] == 'object' ) {
				foreach ( $value as &$val ) {
					$tax = get_taxonomy( $val );

					$val = ( $tax ? $tax : null );
				}
			}

			$value = array_filter( $value );

			if ( in_array( $field['field_type'], [ 'select', 'radio' ] ) ) {
				$value = array_shift( $value );
			}

			return $value;
		}
	}

	new acf_field_taxonomy_selector( $this->settings );

endif;
