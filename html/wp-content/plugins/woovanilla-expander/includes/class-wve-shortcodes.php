<?php
/**
 * Descr
 *
 * @package WooVanilla
 */

namespace WooVanilla_Expander;

use WooVanilla_Expander\Shortcodes\WVE_Shortcode_Products_Slider;

/**
 * Undocumented class
 */
class WVE_Shortcodes extends \WC_Shortcodes {

	/**
	 * Init shortcodes.
	 */
	public static function init() {
		$shortcodes = array(
			'products_slider'            => __CLASS__ . '::products_slider',

			'products'                   => get_parent_class() . '::products',
			'product'                    => get_parent_class() . '::product',
			'product_page'               => get_parent_class() . '::product_page',
			'product_category'           => get_parent_class() . '::product_category',
			'product_categories'         => get_parent_class() . '::product_categories',
			'add_to_cart'                => get_parent_class() . '::product_add_to_cart',
			'add_to_cart_url'            => get_parent_class() . '::product_add_to_cart_url',
			'recent_products'            => get_parent_class() . '::recent_products',
			'sale_products'              => get_parent_class() . '::sale_products',
			'best_selling_products'      => get_parent_class() . '::best_selling_products',
			'top_rated_products'         => get_parent_class() . '::top_rated_products',
			'featured_products'          => get_parent_class() . '::featured_products',
			'product_attribute'          => get_parent_class() . '::product_attribute',
			'related_products'           => get_parent_class() . '::related_products',
			'shop_messages'              => get_parent_class() . '::shop_messages',
			'woocommerce_order_tracking' => get_parent_class() . '::order_tracking',
			'woocommerce_cart'           => get_parent_class() . '::cart',
			'woocommerce_checkout'       => get_parent_class() . '::checkout',
			'woocommerce_my_account'     => get_parent_class() . '::my_account',
		);

		foreach ( $shortcodes as $shortcode => $function ) {
			add_shortcode( apply_filters( "{$shortcode}_shortcode_tag", $shortcode ), $function );
		}

		// Alias for pre 2.1 compatibility.
		add_shortcode( 'woocommerce_messages', get_parent_class() . '::shop_messages' );
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $atts the comment param.
	 *    $atts = [
	 *      'wv_shortcode_type'     => (string) Тип шорткода.
	 * 		]
	 */
	public static function products_slider( $atts ) {
		$atts = (array) $atts;
		$type = 'products-slider';

		if ( isset( $atts['wv_shortcode_type'] ) ) {
			$type = $atts['wv_shortcode_type'];
		}

		$shortcode = new WVE_Shortcode_Products_Slider( $atts, $type );

		return $shortcode->get_content();
	}

		/**
		 * List multiple products shortcode.
		 *
		 * @param array $atts Attributes.
		 * @return string
		 */
	public static function products( $atts ) {
		$atts = (array) $atts;
		$type = 'products';

		if ( isset( $atts['wv_shortcode_type'] ) ) {
			$type = $atts['wv_shortcode_type'];
		}

		$shortcode = new WVE_Shortcode_Products( $atts, $type );

		return $shortcode->get_content();
	}
}
