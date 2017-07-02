<?php

namespace StatenWeb\Form_Builder\Fields;

class Password extends Text {


	public function __construct( Array $field_settings = [] ) {

		$this->required_fields = [];

		$this->defaults = [

			'type'     => 'password',
		];

		parent::__construct( $field_settings );
	}



}