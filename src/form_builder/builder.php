<?php

namespace StatenWeb\Form_Builder;


use StatenWeb\Form_Builder\Fields\Field;

class Builder {

	protected $fields;
	protected $settings;
	protected $slug;

	public function __construct( $slug, array $fields, array $settings = [] ) {

		$this->slug     = $slug;
		$this->fields   = $fields;
		$defaults       = [
			'method' => 'POST'
		];
		$this->settings = array_merge( $defaults, $settings );
		$this->check_fields();

	}

	protected function check_fields() {

		foreach ( (array) $this->fields as $field ) {
			if ( ! is_a( $field, Field::class ) ) {
				throw new \Exception( sprintf( '%s is not a proper field', gettype( $field ) ) );
			}
		}

	}

	public function set_prefix( $prefix ) {
		$this->slug = $prefix;
	}

	public function output() {


		$before_template = '<form method="{{METHOD}}" class="{{CSS_PREFIX}}__form {{CSS_PREFIX}}__form-{{SLUG}} {{CLASS}}">';
		$after_template  = '</form>';

		$before = str_replace( [ '{{CSS_PREFIX}}', '{{SLUG}}', '{{METHOD}}', '{{CLASS}}' ],
			[ $this->slug, $this->slug, $this->settings['method'], $this->settings['class'] ], $before_template );
		$after  = $after_template;

		echo $before;
		foreach ( $this->fields as $field ) {
			if ( $this->slug ) {
				$field->set_prefix( $this->slug );
			}
			$field->output();
		}

		echo $after;


	}


}