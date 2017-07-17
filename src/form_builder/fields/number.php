<?php

namespace StatenWeb\Form_Builder\Fields;

class Number extends Text {


	public function __construct( Array $field_settings = [] ) {

		$this->required_fields = [];

		$this->defaults = [

			'type'     => 'number',
		];

		parent::__construct( $field_settings );
	}



}