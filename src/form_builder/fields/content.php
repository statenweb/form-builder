<?php

namespace StatenWeb\Form_Builder\Fields;

class Content extends Field {


	public function __construct( Array $field_settings = [] ) {

		$this->unrequired_fields = [ 'slug' ];

		$this->do_not_require_slug();
		$this->defaults = array_merge( [

			'default'   => '',
			'outer_tag' => 'div',
			'inner_tag' => 'h2',
		], $this->defaults );


		parent::__construct( $field_settings );
	}

	protected function generate() {

		$inner          = '';
		$inner_template = '<{{INNER_TAG}}>{{CONTENT}}</{{INNER_TAG}}>';

		if ( $this->field_settings['content'] ) {
			$inner = str_replace( [
				'{{INNER_TAG}}',
				'{{CONTENT}}',
			], [
				esc_attr( $this->field_settings['inner_tag'] ),
				wp_kses_post( $this->field_settings['content'] ),
			], $inner_template );
		}

		$template = '<{{OUTER_TAG}} class="{{CSS_PREFIX}}__element-wrap {{CSS_PREFIX}}__element-wrap-{{SLUG}} {{CLASS}}">{{INNER}}</{{OUTER_TAG}}>';


		$replace_array      = [
			'{{SLUG}}',
			'{{CSS_PREFIX}}',
			'{{OUTER_TAG}}',
			'{{INNER}}',
			'{{CLASS}}',
		];
		$replace_with_array = [
			esc_attr( $this->field_settings['slug'] ),
			esc_attr( $this->field_settings['prefix'] ),
			esc_attr( $this->field_settings['outer_tag'] ),
			$inner,
			esc_attr( $this->field_settings['class'] ),
		];


		$this->generated_element = str_replace( $replace_array,
			$replace_with_array,
			$template );

		return true;


	}

}