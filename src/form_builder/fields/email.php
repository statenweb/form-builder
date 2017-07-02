<?php

namespace StatenWeb\Form_Builder\Fields;

class Email extends Text {


	public function __construct( Array $field_settings = [] ) {

		$this->required_fields = [];

		$this->defaults = [

			'type'     => 'email',
		];

		parent::__construct( $field_settings );
	}



}