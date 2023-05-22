<?php
/**
 * Empty Cart Button for WooCommerce - General Section Settings
 *
 * @version 1.2.4
 * @since   1.0.0
 * @author  ProWCPlugins
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'ProWC_Empty_Cart_Button_Settings_General' ) ) :

class ProWC_Empty_Cart_Button_Settings_General extends ProWC_Empty_Cart_Button_Settings_Section {

	/**
	 * Constructor.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function __construct() {
		$this->id   = '';
		$this->desc = __( 'General', ECB_TEXTDOMAIN );
		parent::__construct();
	}

	/**
	 * get_checkout_position_options.
	 *
	 * @version 1.2.4
	 * @since   1.2.0
	 */
	function get_checkout_position_options() {
		return array(
			'disable'                                            => __( 'Do not add', ECB_TEXTDOMAIN ),
			'woocommerce_before_checkout_form'                   => __( 'Before checkout form', ECB_TEXTDOMAIN ),          // form-checkout.php
			'woocommerce_checkout_before_customer_details'       => __( 'Before customer details', ECB_TEXTDOMAIN ),       // form-checkout.php
			'woocommerce_checkout_billing'                       => __( 'Billing', ECB_TEXTDOMAIN ),                       // form-checkout.php
			'woocommerce_checkout_shipping'                      => __( 'Shipping', ECB_TEXTDOMAIN ),                      // form-checkout.php
			'woocommerce_checkout_after_customer_details'        => __( 'After customer details', ECB_TEXTDOMAIN ),        // form-checkout.php
			'woocommerce_checkout_before_order_review_heading'   => __( 'Before order review heading', ECB_TEXTDOMAIN ),   // form-checkout.php
			'woocommerce_checkout_before_order_review'           => __( 'Before order review', ECB_TEXTDOMAIN ),           // form-checkout.php
			'woocommerce_checkout_order_review'                  => __( 'Order review', ECB_TEXTDOMAIN ),                  // form-checkout.php
			'woocommerce_checkout_after_order_review'            => __( 'After order review', ECB_TEXTDOMAIN ),            // form-checkout.php
			'woocommerce_after_checkout_form'                    => __( 'After checkout form', ECB_TEXTDOMAIN ),           // form-checkout.php
		);
	}

	/**
	 * get_cart_position_options.
	 *
	 * @version 1.2.4
	 * @since   1.2.0
	 * @todo    [dev] `woocommerce_cart_coupon`, `woocommerce_cart_actions` are inside `<form>` tag
	 */
	function get_cart_position_options() {
		return array(
			'disable'                                      => __( 'Do not add', ECB_TEXTDOMAIN ),
			'woocommerce_before_cart'                      => __( 'Before cart', ECB_TEXTDOMAIN ),                         // cart.php
			'woocommerce_before_cart_table'                => __( 'Before cart table', ECB_TEXTDOMAIN ),                   // cart.php
			'woocommerce_before_cart_contents'             => __( 'Before cart contents', ECB_TEXTDOMAIN ),                // cart.php
			'woocommerce_cart_contents'                    => __( 'Inside cart contents', ECB_TEXTDOMAIN ),                // cart.php
			'woocommerce_cart_coupon'                      => __( 'After "Apply coupon" button', ECB_TEXTDOMAIN ),         // cart.php
			'woocommerce_cart_actions'                     => __( 'After "Update cart" button', ECB_TEXTDOMAIN ),          // cart.php
			'woocommerce_after_cart_contents'              => __( 'After cart contents', ECB_TEXTDOMAIN ),                 // cart.php
			'woocommerce_after_cart_table'                 => __( 'After cart table', ECB_TEXTDOMAIN ),                    // cart.php
			'woocommerce_before_cart_collaterals'          => __( 'Before cart collaterals', ECB_TEXTDOMAIN ),             // cart.php
			'woocommerce_cart_collaterals'                 => __( 'Inside cart collaterals', ECB_TEXTDOMAIN ),             // cart.php
			'woocommerce_before_cart_totals'               => __( 'Before cart totals', ECB_TEXTDOMAIN ),                  // cart-totals.php
			'woocommerce_cart_totals_before_shipping'      => __( 'Before cart totals shipping', ECB_TEXTDOMAIN ),         // cart-totals.php
			'woocommerce_cart_totals_after_shipping'       => __( 'After cart totals shipping', ECB_TEXTDOMAIN ),          // cart-totals.php
			'woocommerce_cart_totals_before_order_total'   => __( 'Before cart totals order total', ECB_TEXTDOMAIN ),      // cart-totals.php
			'woocommerce_cart_totals_after_order_total'    => __( 'After cart totals order total', ECB_TEXTDOMAIN ),       // cart-totals.php
			'woocommerce_proceed_to_checkout'              => __( 'After "Proceed to checkout" button', ECB_TEXTDOMAIN ),  // cart-totals.php
			'woocommerce_after_cart_totals'                => __( 'After cart totals', ECB_TEXTDOMAIN ),                   // cart-totals.php
			'woocommerce_after_cart'                       => __( 'After cart', ECB_TEXTDOMAIN ),                          // cart.php
		);
	}

	/**
	 * get_settings.
	 *
	 * @version 1.2.4
	 * @since   1.0.0
	 * @todo    [dev] (maybe) rename `%button_form%` to `%button%`
	 * @todo    [feature] widget
	 * @todo    [feature] mini-cart
	 * @todo    [feature] multiple positions (e.g. on cart page)
	 * @todo    [feature] maybe add different "Label Options", "Confirmation Options" and "Redirect Options" for a) Cart, b) Checkout and c) Shortcode
	 */
	function get_settings() {
		$settings = array(
			array(
				'title'    => __( 'Empty Cart Button Options', ECB_TEXTDOMAIN ),
				'type'     => 'title',
				'id'       => 'prowc_empty_cart_button_options',
			),
			array(
				'title'    => __( 'Empty Cart Button', ECB_TEXTDOMAIN ),
				'desc'     => '<strong>' . __( 'Enable plugin', ECB_TEXTDOMAIN ) . '</strong>',
				'desc_tip' => '<a href="https://prowcplugins.com/downloads/empty-cart-button-for-woocommerce/?utm_source=empty-cart-button-for-woocommerce&utm_medium=referral&utm_campaign=settings" target="_blank">' .
					__( 'Empty Cart Button for WooCommerce', ECB_TEXTDOMAIN ) . '</a>',
				'id'       => 'prowc_empty_cart_button_enabled',
				'default'  => 'yes',
				'type'     => 'checkbox',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'prowc_empty_cart_button_options',
			),
			array(
				'title'    => __( 'Position Options', ECB_TEXTDOMAIN ),
				'desc'     => sprintf(
					__( 'Alternatively you can also use %s shortcode or %s PHP code to add "empty cart" button anywhere on your site.', ECB_TEXTDOMAIN ),
					'<code>[prowc_empty_cart_button]</code>',
					'<code>do_shortcode( \'[prowc_empty_cart_button]\' );</code>'
				),
				'type'     => 'title',
				'id'       => 'prowc_empty_cart_button_position_options',
			),
			array(
				'title'    => __( 'Cart: Button position', ECB_TEXTDOMAIN ),
				'desc_tip' => sprintf( __( 'Possible positions are: %s.', ECB_TEXTDOMAIN ), implode( '; ', $this->get_cart_position_options() ) ),
				'id'       => 'prowc_empty_cart_position',
				'default'  => 'woocommerce_after_cart',
				'type'     => 'select',
				'options'  => $this->get_cart_position_options(),
				'desc'     => apply_filters( 'prowc_empty_cart_button', sprintf( '<br>' . 'Get <a target="_blank" href="%s">%s</a> plugin to change button position on cart page.',
					'https://prowcplugins.com/downloads/empty-cart-button-for-woocommerce/?utm_source=empty-cart-button-for-woocommerce&utm_medium=referral&utm_campaign=settings', 'Empty Cart Button for WooCommerce Pro' ), 'settings' ),
				'custom_attributes' => apply_filters( 'prowc_empty_cart_button', array( 'disabled' => 'disabled' ), 'settings' ),
			),
			array(
				'title'    => __( 'Cart: Button position priority', ECB_TEXTDOMAIN ),
				'desc_tip' => __( 'Change this if you want to move the button inside the Position selected above.', ECB_TEXTDOMAIN ),
				'id'       => 'prowc_empty_cart_position_priority',
				'default'  => 10,
				'type'     => 'number',
			),
			array(
				'title'    => __( 'Checkout: Button position', ECB_TEXTDOMAIN ),
				'desc_tip' => sprintf( __( 'Possible positions are: %s.', ECB_TEXTDOMAIN ), implode( '; ', $this->get_checkout_position_options() ) ),
				'id'       => 'prowc_empty_cart_checkout_position',
				'default'  => 'disable',
				'type'     => 'select',
				'options'  => $this->get_checkout_position_options(),
			),
			array(
				'title'    => __( 'Checkout: Button position priority', ECB_TEXTDOMAIN ),
				'desc_tip' => __( 'Change this if you want to move the button inside the Position selected above.', ECB_TEXTDOMAIN ),
				'id'       => 'prowc_empty_cart_checkout_position_priority',
				'default'  => 10,
				'type'     => 'number',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'prowc_empty_cart_button_position_options',
			),
			array(
				'title'    => __( 'Style Options', ECB_TEXTDOMAIN ),
				'desc'     => sprintf(
					__( 'Alternatively, if using %s shortcode, you can style the button with %s attributes, e.g.: %s', ECB_TEXTDOMAIN ),
					'<code>[prowc_empty_cart_button]</code>',
					'<code>html_template</code>, <code>html_style</code>, <code>html_class</code>',
					'<br><code>' . esc_html( '[prowc_empty_cart_button html_template="<div style=\'float:right;\'>%button_form%</div>" html_style="" html_class="button"]' ) . '</code>'
				),
				'type'     => 'title',
				'id'       => 'prowc_empty_cart_button_style_options',
			),
			array(
				'title'    => __( 'Cart: HTML template', ECB_TEXTDOMAIN ),
				'desc_tip' => sprintf( __( 'HTML template for wrapping the button. Replaced value: %s', ECB_TEXTDOMAIN ), '%button_form%' ),
				'id'       => 'prowc_empty_cart_template',
				'default'  => '<div style="float:right;">%button_form%</div>',
				'type'     => 'textarea',
				'css'      => 'width:100%;',
			),
			array(
				'title'    => __( 'Cart: Button HTML class', ECB_TEXTDOMAIN ),
				'id'       => 'prowc_empty_cart_button_class',
				'default'  => 'button',
				'type'     => 'text',
				'css'      => 'width:100%;',
			),
			array(
				'title'    => __( 'Cart: Button HTML style', ECB_TEXTDOMAIN ),
				'id'       => 'prowc_empty_cart_button_style',
				'default'  => '',
				'type'     => 'text',
				'css'      => 'width:100%;',
			),
			array(
				'title'    => __( 'Checkout: HTML template', ECB_TEXTDOMAIN ),
				'desc_tip' => sprintf( __( 'HTML template for wrapping the button. Replaced value: %s', ECB_TEXTDOMAIN ), '%button_form%' ),
				'id'       => 'prowc_empty_cart_template_checkout',
				'default'  => '<div style="float:right;">%button_form%</div>',
				'type'     => 'textarea',
				'css'      => 'width:100%;',
			),
			array(
				'title'    => __( 'Checkout: Button HTML class', ECB_TEXTDOMAIN ),
				'id'       => 'prowc_empty_cart_button_class_checkout',
				'default'  => 'button',
				'type'     => 'text',
				'css'      => 'width:100%;',
			),
			array(
				'title'    => __( 'Checkout: Button HTML style', ECB_TEXTDOMAIN ),
				'id'       => 'prowc_empty_cart_button_style_checkout',
				'default'  => '',
				'type'     => 'text',
				'css'      => 'width:100%;',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'prowc_empty_cart_button_style_options',
			),
			array(
				'title'    => __( 'Label Options', ECB_TEXTDOMAIN ),
				'type'     => 'title',
				'id'       => 'prowc_empty_cart_button_label_options',
			),
			array(
				'title'    => __( 'Button label', ECB_TEXTDOMAIN ),
				'id'       => 'prowc_empty_cart_text',
				'default'  => 'Empty cart',
				'type'     => 'text',
				'desc'     => apply_filters( 'prowc_empty_cart_button', sprintf( '<br>' . 'Get <a target="_blank" href="%s">%s</a> plugin to change button label.',
					'https://prowcplugins.com/downloads/empty-cart-button-for-woocommerce/?utm_source=empty-cart-button-for-woocommerce&utm_medium=referral&utm_campaign=settings', 'Empty Cart Button for WooCommerce Pro' ), 'settings' ),
				'custom_attributes' => apply_filters( 'prowc_empty_cart_button', array( 'readonly' => 'readonly' ), 'settings' ),
				'css'      => 'width:100%;',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'prowc_empty_cart_button_label_options',
			),
			array(
				'title'    => __( 'Confirmation Options', ECB_TEXTDOMAIN ),
				'desc'     => __( 'In this section you can select if you want user to confirm after empty cart button was pressed.', ECB_TEXTDOMAIN ),
				'type'     => 'title',
				'id'       => 'prowc_empty_cart_button_confirmation_options',
			),
			array(
				'title'    => __( 'Confirmation', ECB_TEXTDOMAIN ),
				'id'       => 'prowc_empty_cart_confirmation',
				'default'  => 'no_confirmation',
				'type'     => 'select',
				'options'  => array(
					'no_confirmation'                => __( 'No confirmation', ECB_TEXTDOMAIN ),
					'confirm_with_pop_up_box'        => __( 'Confirm by pop up box', ECB_TEXTDOMAIN ),
					'confirm_with_pop_up_box_jquery' => __( 'Confirm by pop up box (jQuery)', ECB_TEXTDOMAIN ),
				),
			),
			array(
				'title'    => __( 'Confirmation text', ECB_TEXTDOMAIN ),
				'desc_tip' => __( 'Ignored if confirmation is not enabled.', ECB_TEXTDOMAIN ),
				'id'       => 'prowc_empty_cart_confirmation_text',
				'default'  => __( 'Are you sure?', ECB_TEXTDOMAIN ),
				'type'     => 'text',
				'css'      => 'width:100%;',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'prowc_empty_cart_button_confirmation_options',
			),
			array(
				'title'    => __( 'Redirect Options', ECB_TEXTDOMAIN ),
				'desc'     => __( 'In this section you can select if you want to redirect the user to another page after cart is emptied.', ECB_TEXTDOMAIN ),
				'type'     => 'title',
				'id'       => 'prowc_empty_cart_button_redirect_options',
			),
			array(
				'title'    => __( 'Redirect', ECB_TEXTDOMAIN ),
				'desc'     => __( 'Enable', ECB_TEXTDOMAIN ),
				'id'       => 'prowc_empty_cart_button_redirect_enabled',
				'default'  => 'no',
				'type'     => 'checkbox',
				'desc_tip' => apply_filters( 'prowc_empty_cart_button', sprintf( 'Get <a target="_blank" href="%s">%s</a> plugin to enable redirection.',
					'https://prowcplugins.com/downloads/empty-cart-button-for-woocommerce/?utm_source=empty-cart-button-for-woocommerce&utm_medium=referral&utm_campaign=settings', 'Empty Cart Button for WooCommerce Pro' ), 'settings' ),
				'custom_attributes' => apply_filters( 'prowc_empty_cart_button', array( 'disabled' => 'disabled' ), 'settings' ),
			),
			array(
				'title'    => __( 'Redirect location', ECB_TEXTDOMAIN ),
				'desc_tip' => __( 'Ignored if redirect is not enabled.', ECB_TEXTDOMAIN ),
				'id'       => 'prowc_empty_cart_button_redirect_location',
				'default'  => '',
				'type'     => 'text',
				'css'      => 'width:100%;',
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'prowc_empty_cart_button_redirect_options',
			),
			array(
				'title'    => __( 'Advanced Options', ECB_TEXTDOMAIN ),
				'type'     => 'title',
				'id'       => 'prowc_empty_cart_button_advanced_options',
			),
			array(
				'title'    => __( 'Button type', ECB_TEXTDOMAIN ),
				'id'       => 'prowc_empty_cart_button_tag',
				'default'  => 'a',
				'type'     => 'select',
				'class'    => 'chosen_select',
				'options'  => array(
					'a'    => __( 'Hyperlink (Recommended)', ECB_TEXTDOMAIN ),
					'form' => __( 'Form (Deprecated)', ECB_TEXTDOMAIN ),
				),
			),
			array(
				'type'     => 'sectionend',
				'id'       => 'prowc_empty_cart_button_advanced_options',
			),
		);
		return $settings;
	}

}

endif;

return new ProWC_Empty_Cart_Button_Settings_General();
