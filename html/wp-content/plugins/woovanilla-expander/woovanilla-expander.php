<?php
/**
 * Plugin Name: WooVanilla Expander
 * Version: 1.0
 * Author: ArtBot
 * Description: Extend WooCommerce
 **/

if ( ! class_exists( 'WooVanilla_Expander' ) ) :
	/**
	 * Undocumented class
	 */
	class WooVanilla_Expander {

		/**
		 * Undocumented variable
		 *
		 * @var [type]
		 */
		protected static $_instance = null;

		/**
		 * Undocumented function
		 */
		public function __construct() {
			$this->update_hooks();
		}

		/**
		 * Undocumented function
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Undocumented function
		 */
		public function update_hooks() {
			remove_action( 'init', array( 'WC_Shortcodes', 'init' ) );
			add_action( 'init', array( 'WooVanilla_Expander\WVE_Shortcodes', 'init' ) );
		}

		/**
		 * Undocumented function
		 *
		 * @param [type] $class_name the comment param.
		 */
		private static function autoloader( $class_name ) {
			if ( strpos( $class_name, 'WooVanilla_Expander' ) === 0 ) {
				require plugin_dir_path( __DIR__ ) .
				str_replace(
					'woovanilla-expander',
					'woovanilla-expander/includes',
					str_replace(
						'\\',
						'/',
						str_replace(
							'_',
							'-',
							strtolower(
								substr_replace(
									$class_name,
									'/class-',
									strrpos( $class_name, '\\' ),
									1
								)
							)
						)
					) . '.php'
				);
			}
		}

		/**
		 * Undocumented function
		 *
		 * @throws Exception
		 */
		public static function init() {
			if ( ! class_exists( 'WooCommerce' ) ) {
				// throw new Exception( 'Please, activate WooCommerce!', 1 );
				return;
			}

			spl_autoload_register( array( 'WooVanilla_Expander', 'autoloader' ) );

			self::instance();
		}
	}

	WooVanilla_Expander::init();


endif;
