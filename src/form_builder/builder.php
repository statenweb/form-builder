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
			'method'     => 'POST',
			'novalidate' => false,
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


		$before_template = '<form method="{{METHOD}}" class="{{CSS_PREFIX}}__form {{CSS_PREFIX}}__form-{{SLUG}} {{CLASS}}" {{NOVALIDATE}}>';
		$after_template  = '</form>';
		$novalidate = '';
		if ( $this->settings['novalidate'] ) {
			$novalidate = 'novalidate="novalidate"';
		}

		$before = str_replace( [ '{{CSS_PREFIX}}', '{{SLUG}}', '{{METHOD}}', '{{CLASS}}', '{{NOVALIDATE}}' ],
			[
				esc_attr( $this->slug ),
				esc_attr( $this->slug ),
				esc_attr( $this->settings['method'] ),
				esc_attr( $this->settings['class'] ),
				esc_attr( $novalidate ),
			], $before_template );
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