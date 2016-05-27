<?php

/**
 * Taxonomy Selector Field Settings for ACF 4
 *
 * @used-by  acf_field_taxonomy_selector::create_options()
 *
 * @global   array  $field  An array holding all the field's data.
 *
 * @package McAskill\ACF\Fields
 */

$classes    = "field_option field_option_{$this->name}";
$field_name = "fields[{$key}][%s]";

?>
<tr class="<?php echo $classes; ?>">
	<td class="label">
		<label><?php _e('Appearance', 'acf'); ?></label>
	</td>
	<td>
		<?php

		do_action( 'acf/create_field', [
			'type'     => 'select',
			'name'     => sprintf( $field_name, 'field_type' ),
			'value'    => $field['field_type'],
			'optgroup' => true,
			'choices'  => [
				__('Multiple Values', 'acf') => [
					'checkbox'     => __('Checkbox', 'acf'),
					'multi_select' => __('Multi Select', 'acf')
				],
				__('Single Value', 'acf') => [
					'radio'  => __('Radio Buttons', 'acf'),
					'select' => __('Select', 'acf')
				]
			]
		] );

		?>
	</td>
</tr>
<tr class="<?php echo $classes; ?>">
	<td class="label">
		<label><?php _e('Allow Null?', 'acf'); ?></label>
	</td>
	<td>
		<?php

		do_action( 'acf/create_field', [
			'type'    => 'radio',
			'name'    => sprintf( $field_name, 'allow_null' ),
			'value'   => $field['allow_null'],
			'layout'  => 'horizontal',
			'choices' => [
				1 => __('Yes', 'acf'),
				0 => __('No', 'acf'),
			],
		] );

		?>
	</td>
</tr>
<tr class="<?php echo $classes; ?>">
	<td class="label">
		<label><?php _e('Return Value', 'acf'); ?></label>
	</td>
	<td>
		<?php

		do_action( 'acf/create_field', [
			'type'    => 'radio',
			'name'    => sprintf( $field_name, 'return_format' ),
			'value'   => $field['return_format'],
			'layout'  => 'horizontal',
			'choices' => [
				'object' => __('Taxonomy Object', 'acf'),
				'id'     => __('Taxonomy Name', 'acf')
			]
		] );

		?>
	</td>
</tr>
