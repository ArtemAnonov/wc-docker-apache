<?php

/**
 * Plugin Name: WooVanilla
 * Version: 1.0
 * Author: ArtBot
 **/
if (!class_exists('WooVanilla')) :

  class WooVanilla
  {
    public function __construct()
    {
      $this->update_hooks();
    }

    public function update_hooks()
    {
      remove_action('init', ['WC_Shortcodes', 'init']);
      add_action('init', ['WC_Shortcodes_WV', 'init']);
    }

    private static function autoloader($class_name)
    {
      if (strpos($class_name, 'WooVanilla') === 0) {
        require plugin_dir_path(__DIR__) . 'includes/' . str_replace('\\', '/', str_replace('_', '-', strtolower($class_name))) . '.php';
      }
    }

    public static function init()
    {
      if (!class_exists('WooCommerce')) {
        throw new Exception("Please, activate WooCommerce!", 1);
      }
      spl_autoload_register(['WooVanilla', 'autoloader']);
    }
  }

  WooVanilla::init();


endif;
