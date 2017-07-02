<?php

namespace StatenWeb\Form_Builder\Fields;

class Button extends Field {


	public function __construct( Array $field_settings = [] ) {

		$this->required_fields = [];

		$this->defaults = array_merge( [

			'tooltip'        => false,
			'label'          => null,
			'label_location' => 'before',
			'type'           => 'button',
			'text'           => '',


		], $this->defaults );


		parent::__construct( $field_settings );
	}

	protected function generate() {


		$template = '<p class="{{CSS_PREFIX}}__form__element-wrap {{CSS_PREFIX}}__form__element-wrap-{{SLUG}}">{{LABEL_BEFORE}}<input class="{{CSS_PREFIX}}__form__input-text {{CSS_PREFIX}}__form__input-text-{{SLUG}}" type="{{TYPE}}" name="{{CSS_PREFIX}}-{{SLUG}}" value="{{BUTTON_TEXT}}"  {{ID}}>{{LABEL_AFTER}}</p>';

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
			$label_element = str_replace( [ '{{SLUG}}', '{{LABEL}}', '{{TOOLTIP}}', ],
				[
					esc_attr( $this->field_settings['slug'] ),
					esc_html( $this->field_settings['label'] ),
					$tooltip_element,
				],
				'<label class="{{CSS_PREFIX}}__form__input-label {{CSS_PREFIX}}__form__input-label-{{SLUG}}">{{LABEL}}{{TOOLTIP}}</label>' );
		}

		$label_after  = $label_element;
		$label_before = '';

		if ( 'before' === $this->field_settings['label_location'] ) {
			$label_before = $label_element;
			$label_after  = '';
		}


		$replace_array      = [
			'{{SLUG}}',
			'{{TOOLTIP_ELEMENT}}',
			'{{TYPE}}',
			'{{PLACEHOLDER}}',
			'{{LABEL_BEFORE}}',
			'{{LABEL_AFTER}}',
			'{{CSS_PREFIX}}',
			'{{ID}}',
			'{{BUTTON_TEXT}}',
		];
		$replace_with_array = [
			esc_attr( $this->field_settings['slug'] ),
			$tooltip_element,
			$this->field_settings['type'],
			$this->field_settings['placeholder'],
			$label_before,
			$label_after,
			$this->field_settings['prefix'],
			$id,
			esc_attr( $this->field_settings['text'] ),


		];


		$this->generated_element = str_replace( $replace_array,
			$replace_with_array,
			$template );

		return true;


	}

}