<?php if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access directly.

if ( ! function_exists( 'spwps_validate_email' ) ) {
	/**
	 *
	 * Email validate
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function spwps_validate_email( $value ) {

		if ( ! filter_var( $value, FILTER_VALIDATE_EMAIL ) ) {
			return esc_html__( 'Please enter a valid email address.', 'woo-product-slider' );
		}

	}
}


if ( ! function_exists( 'spwps_validate_numeric' ) ) {
	/**
	 *
	 * Numeric validate
	 *
	 * @since 1.0.0
	 * @version 1.0.0
	 */
	function spwps_validate_numeric( $value ) {

		if ( ! is_numeric( $value ) ) {
			return esc_html__( 'Please enter a valid number.', 'woo-product-slider' );
		}

	}
}

/**
 *
 * Required validate
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'spwps_validate_required' ) ) {
	function spwps_validate_required( $value ) {

		if ( empty( $value ) ) {
			return esc_html__( 'This field is required.', 'woo-product-slider' );
		}

	}
}

/**
 *
 * URL validate
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'spwps_validate_url' ) ) {
	function spwps_validate_url( $value ) {

		if ( ! filter_var( $value, FILTER_VALIDATE_URL ) ) {
			return esc_html__( 'Please enter a valid URL.', 'woo-product-slider' );
		}

	}
}

/**
 *
 * Email validate for Customizer
 *
 * @since 1.0.0
 * @version 1.0.0
 */
if ( ! function_exists( 'spwps_customize_validate_email' ) ) {
	function spwps_customize_validate_email( $validity, $value, $wp_customize ) {

		if ( ! sanitize_email( $value ) ) {
			$validity->add( 'required', esc_html__( 'Please enter a valid email address.', 'woo-product-slider' ) );
		}

		return $validity;

	}
}
