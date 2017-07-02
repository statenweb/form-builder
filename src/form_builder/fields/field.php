<?php

namespace StatenWeb\Form_Builder\Fields;

abstract class Field {

	protected $name = '';
	protected $field_settings = [];
	protected $required_fields_all = [ 'slug' ];
	protected $required_fields = [];
	protected $fields_all;
	protected $defaults = [];
	protected $fields = [];
	protected $generated_element;
	protected $generated;
	protected $prefix = '';

	public function __construct( Array $field_settings ) {

		$this->fields_all      = [
			[
				'name'   => 'slug',
				'filter' => function ( $slug ) {
					return sanitize_title( $slug );
				}
			]
		];
		$this->field_settings  = $field_settings;
		$this->required_fields = array_merge( $this->required_fields, $this->required_fields_all );
		$this->fields          = array_merge( $this->fields_all, $this->fields );


	}

	abstract protected function generate();

	public function output() {
		$this->maybe_generate();
		echo $this->generated_element;
	}

	public function validate_fields() {

		foreach ( $this->required_fields as $required_field ) {

			if ( ! array_key_exists( $required_field, $this->field_settings ) ) {
				throw new \Exception( sprintf( 'Missing required field %s within %s', $required_field,
					get_class( $this ) ) );
			}
		}



	}

	private function maybe_generate() {
		if ( ! $this->generated ) {
			$this->defaults       = array_merge( [ 'type' => 'text', 'prefix' => $this->prefix, 'id' => null ],
				$this->defaults );
			$this->field_settings = array_merge( $this->defaults, $this->field_settings );
			$this->validate_fields();
			$this->generate();
			$this->generated = true;
		}
	}

	public function set_prefix( $prefix ) {
		$this->prefix = $prefix;
	}


}