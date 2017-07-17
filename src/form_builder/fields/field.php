<?php

namespace StatenWeb\Form_Builder\Fields;

abstract class Field {

	protected $name = '';
	protected $field_settings = [];
	protected $required_fields_all = [ 'slug' ];
	protected $required_fields = [];
	protected $defaults = [];
	protected $fields = [];
	protected $generated_element;
	protected $generated;
	protected $prefix = '';
	protected $require_slug = true;
	protected $unrequired_fields = [];

	public function __construct( Array $field_settings ) {


		if ( ! $this->require_slug ) {
			if ( ( $key = array_search( 'slug', $this->required_fields_all ) ) !== false ) {
				unset( $this->required_fields_all[ $key ] );
			}
		}

		$this->field_settings  = $field_settings;
		$this->required_fields = array_merge( $this->required_fields, $this->required_fields_all );


	}

	abstract protected function generate();

	public function output() {
		$this->maybe_generate();
		echo $this->generated_element;
	}

	public function validate_fields() {

		foreach ( $this->required_fields as $required_field ) {
			if ( in_array( $required_field, $this->unrequired_fields ) ) {
				continue;
			}
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

	public function do_not_require_slug() {
		$this->require_slug = false;
	}


}