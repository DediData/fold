<?php
/**
 * Add controls for arbitrary heading, description, line
 *
 * @package     Customizer_Library
 */

namespace Fold;

/**
 * Extends the WP_Customize_Control class for customizing content.
 */
final class Customizer_Library_Content extends \WP_Customize_Control {

	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overridden without having to rewrite the wrapper.
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	public function render_content() {
		switch ( $this->type ) {
			case 'content':
				echo '<span class="customize-control-title">' . wp_kses_post( $this->label ) . '</span>';
				if ( isset( $this->input_attrs['content'] ) && is_string( $this->input_attrs['content'] ) ) {
					echo wp_kses_post( $this->input_attrs['content'] );
				}
				echo '<span class="description customize-control-description">' . wp_kses_post( $this->description ) . '</span>';
				if ( isset( $this->input_attrs['divider'] ) ) {
					echo '<hr>';
				}
				break;
			case 'divider':
				echo '<hr>';
				break;
			default:
				// No Default value
				break;
		}//end switch
	}
}
