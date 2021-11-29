<?php

/**
 * Post Model and ACF Group
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Mira_Snackbar
 * @subpackage Mira_Snackbar/includes
 */

/**
 * Post Model and ACF Group
 *.
 *
 * @since      1.0.0
 * @package    Mira_Snackbar
 * @subpackage Mira_Snackbar/includes
 * @author     Your Name <email@example.com>
 */
class Mira_Snackbar_Acf_Model
{

	function __construct()
	{
	}

	public function register_acf_groups()
	{
		if (function_exists('acf_add_local_field_group')) :

			acf_add_local_field_group(array(
				'key' => 'group_619e73d57dbf8',
				'title' => 'Configuration',
				'fields' => array(
					array(
						'key' => 'field_619e748e4f64b',
						'label' => 'Layout type',
						'name' => 'layout_type',
						'type' => 'select',
						'instructions' => 'How an element is positioned in a document.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'static' => 'Static',
							'fixed' => 'Fixed',
							'sticky' => 'Sticky',
						),
						'default_value' => 'fixed',
						'allow_null' => 0,
						'multiple' => 0,
						'ui' => 0,
						'return_format' => 'value',
						'ajax' => 0,
						'placeholder' => '',
					),
					array(
						'key' => 'field_619e77fe4f64d',
						'label' => 'Vertical location',
						'name' => 'vertical_location',
						'type' => 'button_group',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'top' => 'Top',
							'bot' => 'Bottom',
						),
						'allow_null' => 0,
						'default_value' => '',
						'layout' => 'horizontal',
						'return_format' => 'value',
					),
					array(
						'key' => 'field_619e78294f64e',
						'label' => 'Horizontal location',
						'name' => 'horizontal_location',
						'type' => 'button_group',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'field_619e748e4f64b',
									'operator' => '==',
									'value' => 'fixed',
								),
							),
						),
						'wrapper' => array(
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'left' => 'Left',
							'right' => 'Right',
							'fullwidth' => 'Full width',
						),
						'allow_null' => 0,
						'default_value' => '',
						'layout' => 'horizontal',
						'return_format' => 'value',
					),
					array(
						'key' => 'field_619e7ab376cac',
						'label' => 'Sticky snackbar',
						'name' => 'sticky_snackbar',
						'type' => 'true_false',
						'instructions' => 'The snackbar will be shown before all other snackbars.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '100',
							'class' => '',
							'id' => '',
						),
						'message' => '',
						'default_value' => 0,
						'ui' => 0,
						'ui_on_text' => '',
						'ui_off_text' => '',
					),
					array(
						'key' => 'field_619e805376cad',
						'label' => 'Priority',
						'name' => 'priority',
						'type' => 'number',
						'instructions' => 'Used to indicate the order in which snack bars are displayed. Smaller numbers correspond to earlier showings.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '100',
							'class' => '',
							'id' => '',
						),
						'default_value' => 10,
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'min' => 0,
						'max' => '',
						'step' => '',
					),
					array(
						'key' => 'field_619e840366d7b',
						'label' => 'Show extra text',
						'name' => 'show_extra_text',
						'type' => 'true_false',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'message' => '',
						'default_value' => 0,
						'ui' => 0,
						'ui_on_text' => '',
						'ui_off_text' => '',
					),
					array(
						'key' => 'field_619e84a066d7c',
						'label' => 'Extra text',
						'name' => 'extra_text',
						'type' => 'wysiwyg',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'field_619e840366d7b',
									'operator' => '==',
									'value' => '1',
								),
							),
						),
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'tabs' => 'all',
						'toolbar' => 'full',
						'media_upload' => 1,
						'delay' => 0,
					),
					array(
						'key' => 'field_61a4fb514c4f8',
						'label' => 'Background color',
						'name' => 'background_color',
						'type' => 'color_picker',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
					),
					array(
						'key' => 'field_61a4fb6f4c4f9',
						'label' => 'Text color',
						'name' => 'text_color',
						'type' => 'color_picker',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '50',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'mira_snackbar',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
			));

		endif;
	}
}
