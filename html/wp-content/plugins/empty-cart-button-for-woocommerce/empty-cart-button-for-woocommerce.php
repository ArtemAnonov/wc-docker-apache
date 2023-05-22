<?php
/*
Plugin Name: Empty Cart Button for WooCommerce
Plugin URI: https://wordpress.org/plugins/empty-cart-button-for-woocommerce/
Description: "Empty cart" button for WooCommerce.
Version: 1.3.7
Author: ProWCPlugins
Author URI: https://prowcplugins.com
Text Domain: empty-cart-button-for-woocommerce
Domain Path: /langs
WC tested up to: 7.5
License: GNU General Public License v3.0
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly
define('ECB_FILE', __FILE__);
define('ECB_DIR', plugin_dir_path(ECB_FILE));
define('ECB_URL', plugins_url('/', ECB_FILE));
define('ECB_TEXTDOMAIN', 'empty-cart-button-for-woocommerce');

if (!class_exists('ProWC_Empty_Cart_Button')) :

	/**
	 * Main ProWC_Empty_Cart_Button Class
	 *
	 * @class   ProWC_Empty_Cart_Button
	 * @version 1.2.2
	 * @since   1.0.0
	 */
	final class ProWC_Empty_Cart_Button {

		/**
		 * Plugin version
		 *
		 * @var   string
		 * @since 1.0.0
		 */
		public $version = '1.3.7';

		/**
		 * @var   ProWC_Empty_Cart_Button The single instance of the class
		 * @since 1.0.0
		 */
		protected static $_instance = null;

		/**
		 * Main ProWC_Empty_Cart_Button Instance
		 *
		 * Ensures only one instance of ProWC_Empty_Cart_Button is loaded or can be loaded
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 * @static
		 * @return  ProWC_Empty_Cart_Button - Main instance
		 */
		public static function instance() {
			if (is_null(self::$_instance)) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * ProWC_Empty_Cart_Button Constructor
		 *
		 * @version 1.2.2
		 * @since   1.0.0
		 * @access  public
		 */
		function __construct() {

			// Set up localization
			load_plugin_textdomain('empty-cart-button-for-woocommerce', false, dirname(plugin_basename(__FILE__)) . '/langs/');

			// Include required files
			$this->includes();

			// Admin
			if (is_admin()) {
				$this->admin();
			}
		}

		/**
		 * Include required core files used in admin and on the frontend
		 *
		 * @version 1.2.2
		 * @since   1.0.0
		 */
		function includes() {
			// Core
			$this->core = require_once('includes/class-prowc-empty-cart-button-core.php');
		}

		/**
		 * Add Admin settings tab
		 *
		 * @version 1.2.2
		 * @since   1.2.2
		 */
		function admin() {
			// Action links
			add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'action_links'));
			// Settings
			add_filter('woocommerce_get_settings_pages', array($this, 'add_woocommerce_settings_tab'));
			require_once('includes/settings/class-prowc-empty-cart-button-settings-section.php');
			$this->settings = array();
			$this->settings['general'] = require_once('includes/settings/class-prowc-empty-cart-button-settings-general.php');
			// Version updated
			if (get_option('prowc_empty_cart_button_version', '') !== $this->version) {
				add_action('admin_init', array($this, 'version_updated'));
			}

			add_action('admin_enqueue_scripts', array($this, 'prowc_empty_cart_button_admin_style'));
			add_action('admin_init',  array($this,'prowc_empty_cart_button_notice_update'));
			add_action('admin_init',  array($this,'prowc_empty_cart_button_plugin_notice_remindlater'));
			add_action('admin_init',  array($this,'prowc_empty_cart_button_plugin_notice_review'));
			add_action('admin_notices', array($this,'prowc_empty_cart_button_admin_upgrade_notice'));
			add_action('admin_notices', array($this,'prowc_empty_cart_button_admin_review_notice'));
			add_action('plugins_loaded', array($this,'prowc_empty_cart_button_check_version'));
			register_activation_hook( __FILE__, array($this,'prowc_empty_cart_button_check_activation_hook'));

			// Admin notice
			if (!class_exists('WooCommerce')) {
				add_action('admin_notices', array( $this, 'ecb_fail_load') );
				return;
			}
		}

		// Database options upgrade
		function prowc_empty_cart_button_check_version() {
			global $version;
			if ( version_compare( $version, '1.3.0', '<' )) {
				global $wpdb;
				$table_options = $wpdb->prefix.'options';
				$old_keys = $wpdb->get_results( "SELECT *  FROM `". $table_options ."` WHERE `option_name` LIKE '%alg_wc_%'");
				if (is_array($old_keys) || is_object($old_keys)){
					foreach($old_keys as $val) {
						$new_key = str_replace("alg_wc_","prowc_", $val->option_name);
						$wpdb->query( $wpdb->prepare( "UPDATE $table_options SET option_name = %s WHERE option_name = %s", $new_key, $val->option_name ) );
					}
				}
			}
		}

		/**
		 * Show action links on the plugin screen
		 *
		 * @version 1.2.1
		 * @since   1.0.0
		 * @param   mixed $links
		 * @return  array
		 */
		function action_links($links) {
			$custom_links = array();
			$custom_links[] = '<a href="' . admin_url('admin.php?page=wc-settings&tab=prowc_empty_cart_button') . '">' . __('Settings', ECB_TEXTDOMAIN) . '</a>';
			if ('empty-cart-button-for-woocommerce.php' === basename(__FILE__)) {
				$custom_links[] = '<a target="_blank" href="https://prowcplugins.com/downloads/empty-cart-button-for-woocommerce/?utm_source=empty-cart-button-for-woocommerce&utm_medium=referral&utm_campaign=settings">' . __('Unlock All', ECB_TEXTDOMAIN) . '</a>';
			}
			return array_merge($custom_links, $links);
		}

		/**
		 * Include Admin Style
		 *
		 * @version 1.2.1
		 * @since   1.0.0
		 */
		function prowc_empty_cart_button_admin_style() {
			wp_enqueue_style('prowc-empty-button-style', ECB_URL . '/includes/css/admin-style.css');
			wp_enqueue_script('prowc-empty-button-script', ECB_URL . '/includes/js/admin-script.js', array ( 'jquery' ), 1.1, true);
			
			//admin rating popup js
			wp_enqueue_script('prowc-empty-button-sweetalert-min', ECB_URL . '/includes/js/sweetalert.min.js', array ( 'jquery' ), 1.1, true);
			
		}

		/**
		 * Add Empty Cart Button settings tab to WooCommerce settings
		 *
		 * @version 1.2.2
		 * @since   1.0.0
		 */
		function add_woocommerce_settings_tab($settings) {
			$settings[] = require_once('includes/settings/class-prowc-settings-empty-cart-button.php');
			return $settings;
		}

		/**
		 * Update Plugin Database version
		 *
		 * @version 1.2.2
		 * @since   1.2.1
		 */
		function version_updated() {
			update_option('prowc_empty_cart_button_version', $this->version);
		}

		function prowc_empty_cart_button_check_activation_hook() {
			$get_activation_time = date('Y-m-d', strtotime('+ 3 days'));
			add_option('prowc_empty_cart_button_activation_time', $get_activation_time ); 
		}

		function prowc_empty_cart_button_notice_update() {
			$remdate = date('Y-m-d', strtotime('+ 7 days'));
			$rDater = get_option('prowc_empty_cart_button_plugin_notice_nopemaybelater');
			if(!get_option('prowc_empty_cart_button_plugin_notice_remindlater')){
				update_option('prowc_empty_cart_button_plugin_notice_remindlater',$remdate);
				update_option('prowc_empty_cart_button_plugin_reviewtrack', 0);
			}
			
			if($rDater && date('Y-m-d') >= $rDater) {
				update_option('prowc_empty_cart_button_plugin_notice_remindlater',$remdate);
			}
		}

		/**
		 * Get the plugin url.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 * @return  string
		 */
		function plugin_url() {
			return untrailingslashit(plugin_dir_url(__FILE__));
		}

		/**
		 * Get the plugin path.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 * @return  string
		 */
		function plugin_path() {
			return untrailingslashit(plugin_dir_path(__FILE__));
		}

		/**
		 * Admin Notice for WooCommerce Install & Active.
		 *
		 * @version 1.2.9
		 * @since   1.2.9
		 * @return  string
		 */
		function prowc_ecb_installed() {

			$file_path = 'woocommerce/woocommerce.php';
			$installed_plugins = get_plugins();

			return isset($installed_plugins[$file_path]);
		}

		/**
		 * Admin Notice for WooCommerce Install & Active.
		 *
		 * @version 1.2.9
		 * @since   1.2.9
		 * @return  string
		 */
		function ecb_fail_load() {
			if(function_exists('WC')){
				return;
			}
		    $screen = get_current_screen();
		    if (isset($screen->parent_file) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id) {
		        return;
		    }

		    $plugin = 'woocommerce/woocommerce.php';
		    if ($this->prowc_ecb_installed()) {
		        if (!current_user_can('activate_plugins')) {
		            return;
		        }
		        $activation_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin);

		        $message = '<p><strong>' . esc_html__('Empty Cart Button for WooCommerce', ECB_TEXTDOMAIN) . '</strong>' . esc_html__(' plugin is not working because you need to activate the WooCoomerce plugin.', ECB_TEXTDOMAIN) . '</p>';
		        $message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $activation_url, __('Activate Woocommerce Now', ECB_TEXTDOMAIN)) . '</p>';
		    } else {
		        if (!current_user_can('install_plugins')) {
		            return;
		        }

		        $install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=Woocommerce'), 'install-plugin_Woocommerce');

		        $message = '<p><strong>' . esc_html__('Empty Cart Button for WooCommerce', ECB_TEXTDOMAIN) . '</strong>' . esc_html__(' plugin is not working because you need to install the WooCoomerce plugin', ECB_TEXTDOMAIN) . '</p>';
		        $message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $install_url, __('Install WooCoomerce Now', ECB_TEXTDOMAIN)) . '</p>';
		    }

		    echo '<div class="error"><p>' . $message . '</p></div>';
		}

		/* Admin Notice for upgrade plan Start */
		function prowc_empty_cart_button_admin_upgrade_notice() {
			$rDate = get_option('prowc_empty_cart_button_plugin_notice_remindlater');
			if (date('Y-m-d') >= $rDate && !get_option('prowc_empty_cart_button_plugin_notice_dismissed')) {
				
				?>
				<div class="notice is-dismissible prowc_empty_cart_button_prowc_notice">
					<div class="prowc_empty_cart_wrap">
						<div class="prowc_empty_cart_gravatar">
							<img alt="" src="<?php echo ECB_URL . '/includes/img/prowc_logo.png' ?>">
						</div>
						<div class="prowc_empty_cart_authorname">
							<div class="notice_texts">
								<a href="<?php echo esc_url('https://prowcplugins.com/downloads/empty-cart-button-for-woocommerce/?utm_source=empty-cart-button-for-woocommerce&utm_medium=referral&utm_campaign=notification'); ?>" target="_blank"><?php esc_html_e('Upgrade Empty Cart Button for WooCommerce', ECB_TEXTDOMAIN); ?> </a> <?php esc_html_e('to get additional features, security, and support. ', ECB_TEXTDOMAIN); ?> <strong><?php esc_html_e('Get 20% OFF', ECB_TEXTDOMAIN); ?></strong><?php esc_html_e(' your upgrade, use coupon code', ECB_TEXTDOMAIN); ?> <strong><?php esc_html_e('WP20', ECB_TEXTDOMAIN); ?></strong>
							</div>
							<div class="prowc_empty_cart_desc">
								<div class="notice_button">
									<a class="prowc_empty_cart_button button-primary" href="<?php echo esc_url('https://prowcplugins.com/downloads/empty-cart-button-for-woocommerce/?utm_source=empty-cart-button-for-woocommerce&utm_medium=referral&utm_campaign=notification'); ?>" target="_blank"><?php echo _e('Buy Now', ECB_TEXTDOMAIN); ?></a>
									<a href="?prowc-wc-ecb-plugin-remindlater"><?php _e('Remind me later', ECB_TEXTDOMAIN); ?></a>
									<a href="?prowc-wc-ecb-plugin-dismissed"><?php _e('Dismiss Notice', ECB_TEXTDOMAIN); ?></a>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<button type="button" class="notice-dismiss">
						<span class="screen-reader-text"></span>
					</button>
				</div>
		<?php }
		}
		function prowc_empty_cart_button_plugin_notice_remindlater() {
			$curDate = date('Y-m-d', strtotime(' + 7 days'));
			$rlDate = date('Y-m-d', strtotime(' + 15 days'));
			if (isset($_GET['prowc-wc-ecb-plugin-remindlater'])) {
				update_option('prowc_empty_cart_button_plugin_notice_remindlater', $curDate);
				update_option('prowc_empty_cart_button_plugin_reviewtrack', 1);
				update_option('prowc_empty_cart_button_plugin_notice_nopemaybelater', $rlDate);
			}
			if (isset($_GET['prowc-wc-ecb-plugin-dismissed'])) {
				update_option('prowc_empty_cart_button_plugin_reviewtrack', 1);
				update_option('prowc_empty_cart_button_plugin_notice_nopemaybelater', $rlDate);
				update_option('prowc_empty_cart_button_plugin_notice_dismissed', 'true');
			}
			if(isset($_GET['prowc-wc-ecb-plugin-remindlater-rating'])){
				update_option('prowc_empty_cart_button_plugin_notice_remindlater_rating', $curDate);
			}
			if (isset($_GET['prowc-wc-ecb-plugin-dismissed-rating'])) {
				update_option('prowc_empty_cart_button_plugin_notice_dismissed_rating', 'true');
			}
		}
		/* Admin Notice for upgrade plan End */

		/* Admin Notice for Plugin Review Start */
		function prowc_empty_cart_button_admin_review_notice() {

			$plugin_data = get_plugin_data( __FILE__ );	
			$plugin_name = $plugin_data['Name'];
			$rDate = get_option('prowc_empty_cart_button_plugin_notice_remindlater_rating');
			$activationDate = get_option('prowc_empty_cart_button_activation_time');

			$rDater = get_option('prowc_empty_cart_button_plugin_notice_nopemaybelater');
			$prowctrack = get_option('prowc_empty_cart_button_plugin_reviewtrack');

			if (date('Y-m-d') >= $activationDate && date('Y-m-d') >= $rDate && !get_option('prowc_empty_cart_button_plugin_notice_dismissed_rating')) {
			?>
				<div class="notice notice-info  is-dismissible">
					<p><?php  printf( __( 'How are you liking the %s?', ECB_TEXTDOMAIN ), esc_html( $plugin_name ) ); ?></p>
					<div class="starts-main-div">
						<div class="stars ecb-star">
							<input type="radio" name="star" class="star-1" id="ecb-star-1" value="1" />
							<label class="star-1" for="ecb-star-1">1</label>
							<input type="radio" name="star" class="star-2" id="ecb-star-2" value="2" />
							<label class="star-2" for="ecb-star-2">2</label>
							<input type="radio" name="star" class="star-3" id="ecb-star-3" value="3" />
							<label class="star-3" for="ecb-star-3">3</label>
							<input type="radio" name="star" class="star-4" id="ecb-star-4" value="4" />
							<label class="star-4" for="ecb-star-4">4</label>
							<input type="radio" name="star" class="star-5" id="ecb-star-5" value="5" />
							<label class="star-5" for="ecb-star-5">5</label>
							<span></span>
						</div>
						<div class="notice_button">
							<a href="?prowc-wc-ecb-plugin-remindlater-rating" class="button-secondary" ><?php _e('Remind me later', ECB_TEXTDOMAIN); ?></a>
							<a href="?prowc-wc-ecb-plugin-dismissed-rating" class="button-secondary" ><?php _e('Dismiss Notice', ECB_TEXTDOMAIN); ?></a>
						</div>
					</div>
				</div>
			<?php
			}
		
			if ($rDater != "")
				if (date('Y-m-d') >= $rDater && $prowctrack && !get_option('prowc_empty_cart_button_plugin_notice_alreadydid')) {
				?>
				<div class="notice is-dismissible prowc_empty_cart_button_prowc_notice">
					<div class="prowc_empty_cart_wrap">
						<div class="prowc_empty_cart_gravatar">
							<img alt="" src="<?php echo ECB_URL . '/includes/img/prowc_logo.png' ?>">
						</div>
						<div class="prowc_empty_cart_authorname">
							<div class="notice_texts">
								<strong><?php esc_html_e('Are you enjoying Empty Cart Button for WooCommerce?', ECB_TEXTDOMAIN); ?></strong>
							</div>
							<div class="prowc_empty_cart_desc">
								<div class="notice_button">
									<button class="prowc_empty_cart_button button-primary prowc_empty_cart_button_yes"><?php echo _e('Yes!', ECB_TEXTDOMAIN); ?></button>
									<a class="prowc_empty_cart_button button action" href="?prowc-wc-ecb-plugin-alreadydid"><?php echo _e('Not Really!', ECB_TEXTDOMAIN); ?></a>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>

					<button type="button" class="notice-dismiss">
						<span class="screen-reader-text"></span>
					</button>
					<div class="prowc_empty_cart_button_prowc_notice_review_yes">
						<div class="notice_texts">
							<?php esc_html_e('That\'s awesome! Could you please do me a BIG favor and give it 5-star rating on WordPress to help us spread the word and boost our motivation?' , ECB_TEXTDOMAIN); ?>
						</div>
						<div class="prowc_empty_cart_desc">
							<div class="notice_button">
								<a class="prowc_empty_cart_button button-primary" href="<?php echo esc_url('https://wordpress.org/support/plugin/empty-cart-button-for-woocommerce/reviews/?filter=5#new-post'); ?>" target="_blank"><?php echo _e('Okay You Deserve It', ECB_TEXTDOMAIN); ?></a>
								<a class="prowc_empty_cart_button button action" href="?prowc-wc-ecb-plugin-nopemaybelater"><?php echo _e('Nope Maybe later', ECB_TEXTDOMAIN); ?></a>
								<a class="prowc_empty_cart_button button action" href="?prowc-wc-ecb-plugin-alreadydid"><?php echo _e('I Already Did', ECB_TEXTDOMAIN); ?></a>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		<?php }

		function prowc_empty_cart_button_plugin_notice_review() {
			$curDate = date('Y-m-d', strtotime(' + 7 Days'));
			if (isset($_GET['prowc-wc-ecb-plugin-nopemaybelater'])) {
				update_option('prowc_empty_cart_button_plugin_notice_nopemaybelater', $curDate);
			}
			if (isset($_GET['prowc-wc-ecb-plugin-alreadydid'])) {
				update_option('prowc_empty_cart_button_plugin_notice_alreadydid', 'true');
			}
		}
		/* Admin Notice for Plugin Review End */
	}

endif;

if (!function_exists('prowc_empty_cart_free_activation')) {

	/**
	 * Add action on plugin activation
	 *
	 * @version 1.3.4
	 * @since   1.3.4
	 */
	function prowc_empty_cart_free_activation() {

		// Deactivate Empty Cart Button Pro for WooCommerce
		deactivate_plugins('empty-cart-button-pro-for-woocommerce/empty-cart-button-pro-for-woocommerce.php'); 
		
	}
}
register_activation_hook(__FILE__, 'prowc_empty_cart_free_activation');

if (!function_exists('prowc_empty_cart_button')) {
	/**
	 * Returns the main instance of ProWC_Empty_Cart_Button to prevent the need to use globals.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return  ProWC_Empty_Cart_Button
	 */
	function prowc_empty_cart_button() {
		return ProWC_Empty_Cart_Button::instance();
	}
}

/* Admin Notice for upgrade plan End */

prowc_empty_cart_button();
