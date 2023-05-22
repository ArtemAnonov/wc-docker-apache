<?php
/**
 * Shordcode for loop products
 *
 * @package WooVanillaExpander
 */

namespace WooVanilla_Expander\Shortcodes;

/**
 * Undocumented class
 */
class WVE_Shortcode_Products extends \WC_Shortcode_Products {

	/**
	 * Undocumented function
	 *
	 * @param [type] $query_args the comment param.
	 */
	protected function set_wv_novetly_products_query_args( &$query_args ) {
		$query_args['order'] = 'desc';
	}
}
