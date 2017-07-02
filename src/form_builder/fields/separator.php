<?php

namespace StatenWeb\Form_Builder\Fields;

class Separator extends Field {


	public function __construct( Array $field_settings = [] ) {

		$this->required_fields = [];

		$this->defaults = array_merge( [


		], $this->defaults );


		parent::__construct( $field_settings );
	}

	protected function generate() {

		$this->generated_element = '<hr>';

		return true;


	}

}