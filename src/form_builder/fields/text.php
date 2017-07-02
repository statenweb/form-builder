<?php

namespace StatenWeb\Form_Builder\Fields;

class Text extends Field {


	public function __construct( Array $field_settings = [] ) {

		$this->required_fields = [];

		$this->defaults = array_merge( [

			'default'        => '',
			'required'       => false,
			'placeholder'    => null,
			'tooltip'        => false,
			'label'          => null,
			'label_location' => 'before',
		], $this->defaults );


		parent::__construct( $field_settings );
	}

	protected function generate() {


		$template = '<p class="{{CSS_PREFIX}}__form__element-wrap {{CSS_PREFIX}}__form__element-wrap-{{SLUG}}">{{LABEL_BEFORE}}<input class="{{CSS_PREFIX}}__form__input-text {{CSS_PREFIX}}__form__input-text-{{SLUG}}" type="{{TYPE}}" name="{{CSS_PREFIX}}-{{SLUG}}" placeholder="{{PLACEHOLDER}}" value="" {{REQUIRED_DATA_ATTRIBUTE}} {{ID}}>{{LABEL_AFTER}}</p>';

		$id = '';
		if ( $this->field_settings['id'] ) {
			$id = 'id="' . esc_attr( $this->field_settings['id'] ) . '"';
		}


		$label_element = $required_data_attribute = $required_element = $tooltip_element = '';
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
			'{{TYPE}}',
			'{{PLACEHOLDER}}',
			'{{LABEL_BEFORE}}',
			'{{LABEL_AFTER}}',
			'{{CSS_PREFIX}}',
			'{{ID}}',
		];
		$replace_with_array = [
			esc_attr( $this->field_settings['slug'] ),
			$required_data_attribute,
			$required_element,
			$tooltip_element,
			$this->field_settings['type'],
			$this->field_settings['placeholder'],
			$label_before,
			$label_after,
			$this->field_settings['prefix'],
			$id,


		];


		$this->generated_element = str_replace( $replace_array,
			$replace_with_array,
			$template );

		return true;


	}

}