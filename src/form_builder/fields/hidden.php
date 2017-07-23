<?php

namespace StatenWeb\Form_Builder\Fields;

class Hidden extends Field {


	public function __construct( Array $field_settings = [] ) {

		$this->required_fields = [ 'value' ];

		$this->defaults = array_merge( [


		], $this->defaults );


		parent::__construct( $field_settings );
	}

	protected function generate() {


		$template = '<input class="{{CSS_PREFIX}}__form__input-hidden {{CSS_PREFIX}}__form__input-text-{{SLUG}} {{CLASS}}" type="hidden" name="{{CSS_PREFIX}}-{{SLUG}}" value="{{VALUE}}"  {{ID}}>';

		$id = '';
		if ( $this->field_settings['id'] ) {
			$id = 'id="' . esc_attr( $this->field_settings['id'] ) . '"';
		}


		$replace_array      = [
			'{{SLUG}}',
			'{{CSS_PREFIX}}',
			'{{ID}}',
			'{{VALUE}}',
			'{{CLASS}}',
		];
		$replace_with_array = [
			esc_attr( $this->field_settings['slug'] ),
			$this->field_settings['prefix'],
			$id,
			$this->field_settings['value'],
			esc_attr( $this->field_settings['class'] ),
		];


		$this->generated_element = str_replace( $replace_array,
			$replace_with_array,
			$template );

		return true;


	}

}