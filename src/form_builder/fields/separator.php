<?php

namespace StatenWeb\Form_Builder\Fields;

class Separator extends Field {


	public function __construct( Array $field_settings = [] ) {

		$this->required_fields = [];

		$this->unrequired_fields = [ 'slug' ];

		$this->defaults = array_merge( [


		], $this->defaults );


		parent::__construct( $field_settings );
	}

	protected function generate() {

		$template = '<hr class="{{CLASS}}">';

		$this->generated_element = str_replace( $template, [ '{{CLASS}}' ],
			[ esc_attr( $this->field_settings['slug'] ) ] );

		return true;


	}

}