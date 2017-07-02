<?php

namespace StatenWeb\Form_Builder\Fields;

class Select extends Field {


	public function __construct( Array $field_settings = [] ) {

		$this->required_fields = [];

		$this->defaults = array_merge( $this->defaults, [

			'default'        => '',
			'required'       => false,
			'tooltip'        => false,
			'label'          => null,
			'label_location' => 'before',
			'options'        => []
		] );


		parent::__construct( $field_settings );
	}

	protected function generate() {


		$template        = '<p class="{{CSS_PREFIX}}__form__element-wrap {{CSS_PREFIX}}__form__element-wrap-{{SLUG}}">{{LABEL_BEFORE}}<select class="{{CSS_PREFIX}}__form__input-text {{CSS_PREFIX}}__form__input-text-{{SLUG}}" name="{{CSS_PREFIX}}-{{SLUG}}" {{REQUIRED_DATA_ATTRIBUTE}} {{ID}}>{{OPTIONS}}</select>{{LABEL_AFTER}}</p>';
		$option_template = '<option class="{{CSS_PREFIX}}__form__input-text {{CSS_PREFIX}}__form__input-text-{{KEY}}" value="{{VALUE}}" {{DEFAULT_DATA_ATTRIBUTE}}>{{LABEL}}</option>';

		$id = '';
		if ( $this->field_settings['id'] ) {
			$id = 'id="' . esc_attr( $this->field_settings['id'] ) . '"';
		}

		$label_element = $required_data_attribute = $required_element = $tooltip_element = '';

		$options = '';
		foreach ( $this->field_settings['options'] as $option ) {

			$default_data_attribute = '';
			if ( $option['value'] === $this->field_settings['default'] ) {
				$default_data_attribute = ' selected="selected" ';
			}

			$key = array_key_exists( 'key', $option ) ? $option['key'] : $option['value'];

			$options .= str_replace( [ '{{VALUE}}', '{{LABEL}}', '{{DEFAULT_DATA_ATTRIBUTE}}', '{{KEY}}' ],
				[ $option['value'], $option['label'], $default_data_attribute, $key ], $option_template );
		}

		if ( $this->field_settings['required'] ) {
			$required_data_attribute = 'required="required" aria-required="true"';
			$required_element        = '<span class="{{CSS_PREFIX}}__form__required">*</span>';
		}
		if ( $this->field_settings['tooltip'] ) {
			$tooltip_element = str_replace( '{{TOOLTIP}}', esc_attr( $this->field_settings['tooltip'] ),
				'<span class="{{CSS_PREFIX}}__form__tooltip" data-tooltip="{{TOOLTIP}}" data-hasqtip=""></span>' );
		}
		if ( $this->field_settings['label'] ) {
			$label_element = str_replace( [ '{{SLUG}}', '{{LABEL}}', '{{TOOLTIP}}', '{{REQUIRED_ELEMENT}}', ],
				[
					esc_attr( $this->field_settings['slug'] ),
					esc_html( $this->field_settings['label'] ),
					$tooltip_element,
					$required_element
				],
				'<label class="{{CSS_PREFIX}}__form__input-label {{CSS_PREFIX}}__form__input-label-{{SLUG}}">{{LABEL}}{{REQUIRED_ELEMENT}}{{TOOLTIP}}</label>' );
		}

		$label_after  = $label_element;
		$label_before = '';

		if ( 'before' === $this->field_settings['label_location'] ) {
			$label_before = $label_element;
			$label_after  = '';
		}


		$replace_array      = [
			'{{SLUG}}',
			'{{REQUIRED_DATA_ATTRIBUTE}}',
			'{{REQUIRED_ELEMENT}}',
			'{{TOOLTIP_ELEMENT}}',

			'{{LABEL_BEFORE}}',
			'{{LABEL_AFTER}}',
			'{{OPTIONS}}',
			'{{CSS_PREFIX}}',
			'{{ID}}',
		];
		$replace_with_array = [
			esc_attr( $this->field_settings['slug'] ),
			$required_data_attribute,
			$required_element,
			$tooltip_element,
			$label_before,
			$label_after,
			$options,
			$this->field_settings['prefix'],
			$id,


		];


		$this->generated_element = str_replace( $replace_array,
			$replace_with_array,
			$template );

		return true;


	}

}