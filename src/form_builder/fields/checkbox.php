<?php

namespace StatenWeb\Form_Builder\Fields;

class Checkbox extends Field {


	public function __construct( Array $field_settings = [] ) {

		$this->required_fields = [];

		$this->defaults = array_merge( $this->defaults, [

			'default'        => '',
			'placeholder'    => null,
			'tooltip'        => false,
			'label'          => null,
			'type'           => 'checkbox',
			'label_location' => 'before',
		] );


		parent::__construct( $field_settings );
	}

	protected function generate() {


		$template = '<p class="{{CSS_PREFIX}}__form__element-wrap {{CSS_PREFIX}}__form__element-wrap-{{SLUG}} {{OUTER_CLASS}}">{{LABEL_BEFORE}}<input class="{{CSS_PREFIX}}__form__input-checkbox {{CSS_PREFIX}}__form__input-checkbox-{{SLUG}} {{CLASS}}" type="{{TYPE}}" name="{{CSS_PREFIX}}-{{SLUG}}" placeholder="{{PLACEHOLDER}}" value="" {{ID}}>{{LABEL_AFTER}}</p>';

		$id = '';
		if ( $this->field_settings['id'] ) {
			$id = 'id="' . esc_attr( $this->field_settings['id'] ) . '"';
		}

		$label_element = $tooltip_element = '';
		if ( $this->field_settings['tooltip'] ) {
			$tooltip_element = str_replace( '{{TOOLTIP}}', esc_attr( $this->field_settings['tooltip'] ),
				'<span class="{{CSS_PREFIX}}__form__tooltip" data-tooltip="{{TOOLTIP}}" data-hasqtip=""></span>' );
		}
		if ( $this->field_settings['label'] ) {
			$label_element = str_replace( [ '{{SLUG}}', '{{LABEL}}', '{{TOOLTIP}}', '{{LABEL_CLASS}}' ],
				[
					esc_attr( $this->field_settings['slug'] ),
					esc_html( $this->field_settings['label'] ),
					$tooltip_element,
					esc_attr( $this->field_settings['label_class'] ),

				],
				'<label class="{{CSS_PREFIX}}__form__input-label {{CSS_PREFIX}}__form__input-label-{{SLUG}} {{LABEL_CLASS}}">{{LABEL}}{{TOOLTIP}}</label>' );
		}

		$label_after  = $label_element;
		$label_before = '';

		if ( 'before' === $this->field_settings['label_location'] ) {
			$label_before = $label_element;
			$label_after  = '';
		}

		$replace_array      = [
			'{{SLUG}}',
			'{{LABEL_BEFORE}}',
			'{{LABEL_AFTER}}',
			'{{TOOLTIP_ELEMENT}}',
			'{{TYPE}}',
			'{{PLACEHOLDER}}',
			'{{LABEL}}',
			'{{CSS_PREFIX}}',
			'{{ID}}',
			'{{OUTER_CLASS}}',
			'{{CLASS}}',
		];
		$replace_with_array = [
			esc_attr( $this->field_settings['slug'] ),
			$label_before,
			$label_after,
			$tooltip_element,
			esc_attr( $this->field_settings['type'] ),
			esc_attr( $this->field_settings['placeholder'] ),
			$label_element,
			esc_attr( $this->field_settings['prefix'] ),
			$id,
			esc_attr( $this->field_settings['outer_class'] ),
			esc_attr( $this->field_settings['class'] ),


		];


		$this->generated_element = str_replace( $replace_array,
			$replace_with_array,
			$template );

		return true;


	}

}