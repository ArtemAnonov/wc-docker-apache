<?php

namespace WooVanilla;

use WooVanilla\Shortcodes\WC_Shortcode_Products_WV;

class WC_Shortcodes_WV extends \WC_Shortcodes
{
  /**
   * Init shortcodes.
   */
  public static function init()
  {
    $shortcodes = array(
      'products'                   => __CLASS__ . '::products',

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

    foreach ($shortcodes as $shortcode => $function) {
      add_shortcode(apply_filters("{$shortcode}_shortcode_tag", $shortcode), $function);
    }

    // Alias for pre 2.1 compatibility.
    add_shortcode('woocommerce_messages', get_parent_class() . '::shop_messages');
  }
  // public static function products($atts)
  // {
  //   $atts = (array) $atts;
  //   $type = 'products';

  //   // Allow list product based on specific cases.
  //   if (isset($atts['on_sale']) && wc_string_to_bool($atts['on_sale'])) {
  //     $type = 'sale_products';
  //   } elseif (isset($atts['best_selling']) && wc_string_to_bool($atts['best_selling'])) {
  //     $type = 'best_selling_products';
  //   } elseif (isset($atts['top_rated']) && wc_string_to_bool($atts['top_rated'])) {
  //     $type = 'top_rated_products';
  //   }

  //   $shortcode = new WC_Shortcode_Products_WV($atts, $type);

  //   return $shortcode->get_content();
  // }
}
