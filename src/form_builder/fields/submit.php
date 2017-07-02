<?php

namespace StatenWeb\Form_Builder\Fields;

class Submit extends Button {


	public function __construct( Array $field_settings = [] ) {

		$this->required_fields = [];

		$this->defaults = [

			'type' => 'submit',
		];

		parent::__construct( $field_settings );
	}


}