<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * This has been slightly modified (to read environment variables) for use in Docker.
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// IMPORTANT: this file needs to stay in-sync with https://github.com/WordPress/WordPress/blob/master/wp-config-sample.php
// (it gets parsed by the upstream wizard in https://github.com/WordPress/WordPress/blob/f27cb65e1ef25d11b535695a660e7282b98eb742/wp-admin/setup-config.php#L356-L392)


/**
 * Include Dotenv library to pull config options from .env file.
 */
if ( file_exists( __DIR__ . '/wp-content/themes/awps/vendor/autoload.php' ) ) :
	require_once __DIR__ . '/wp-content/themes/awps/vendor/autoload.php';
	$dotenv = Dotenv\Dotenv::createImmutable( __DIR__ );
	$dotenv->load();
endif;

if ( file_exists( dirname( __DIR__ ) . '/wp-content/themes/awps/vendor/autoload.php' ) ) :
	require_once dirname( __DIR__ ) . '/wp-content/themes/awps/vendor/autoload.php';
	$dotenv = Dotenv\Dotenv::createImmutable( dirname( __DIR__ ) );
	$dotenv->load();
endif;

// a helper function to lookup "env_FILE", "env", then fallback
if ( ! function_exists( 'getenv_docker' ) ) {
	// https://github.com/docker-library/wordpress/issues/588 (WP-CLI will load this file 2x)
	function getenv_docker( $env, $default ) {
		if ( $fileEnv = getenv( $env . '_FILE' ) ) {
			return rtrim( file_get_contents( $fileEnv ), "\r\n" );
		} elseif ( ( $val = getenv( $env ) ) !== false ) {
			return $val;
		} else {
			return $default;
		}
	}
}

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', getenv_docker( 'WORDPRESS_DB_NAME', 'wp_db' ) );

/** Database username */
define( 'DB_USER', getenv_docker( 'WORDPRESS_DB_USER', 'MYSQL_USER' ) );

/** Database password */
define( 'DB_PASSWORD', getenv_docker( 'WORDPRESS_DB_PASSWORD', 'MYSQL_PASSWORD' ) );

/**
 * Docker image fallback values above are sourced from the official WordPress installation wizard:
 * https://github.com/WordPress/WordPress/blob/f9cc35ebad82753e9c86de322ea5c76a9001c7e2/wp-admin/setup-config.php#L216-L230
 * (However, using "example username" and "example password" in your database is strongly discouraged.  Please use strong, random credentials!)
 */

/** Database hostname */
define( 'DB_HOST', getenv_docker( 'WORDPRESS_DB_HOST', 'db:3306' ) );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', getenv_docker( 'WORDPRESS_DB_CHARSET', 'utf8' ) );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', getenv_docker( 'WORDPRESS_DB_COLLATE', '' ) );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY', getenv_docker( 'WORDPRESS_AUTH_KEY', '67eb8e9d3e1806c62eb931b7502c86eed51febbc' ) );
define( 'SECURE_AUTH_KEY', getenv_docker( 'WORDPRESS_SECURE_AUTH_KEY', 'e4ac1462e8b96092980043a8bdcd14aca4724973' ) );
define( 'LOGGED_IN_KEY', getenv_docker( 'WORDPRESS_LOGGED_IN_KEY', 'c71a176684a13643a17befa73268cf3d0fb61d94' ) );
define( 'NONCE_KEY', getenv_docker( 'WORDPRESS_NONCE_KEY', '4b86037ef9d5840ac4669dc9fbfe78a3c3b11402' ) );
define( 'AUTH_SALT', getenv_docker( 'WORDPRESS_AUTH_SALT', 'c71d951a22472f0f38643ef33232e9f7990c64b8' ) );
define( 'SECURE_AUTH_SALT', getenv_docker( 'WORDPRESS_SECURE_AUTH_SALT', 'c269a9337b6e04088a87887f540682920882781c' ) );
define( 'LOGGED_IN_SALT', getenv_docker( 'WORDPRESS_LOGGED_IN_SALT', '5acef97fac1c103dc321de426617cda871dbe394' ) );
define( 'NONCE_SALT', getenv_docker( 'WORDPRESS_NONCE_SALT', 'c07d862ebfe7e99181da7ac89c302ee788ea3718' ) );
// (See also https://wordpress.stackexchange.com/a/152905/199287)

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = getenv_docker( 'WORDPRESS_TABLE_PREFIX', 'wp_' );

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */

define( 'WP_DEBUG', getenv_docker( 'APP_ENV', true ) === 'development' ? true : false );
define( 'JETPACK_DEV_DEBUG', getenv_docker( 'APP_ENV', true ) === 'development' ? true : false );
define( 'WPCF7_AUTOP', getenv_docker( 'WPCF7_AUTOP', '' ) );
define( 'FS_METHOD', 'direct' );

/**
 * Define home and site url
 * reduces DB calls and increase performance
 */

define( 'WP_HOME', getenv_docker( 'WP_HOME', '' ) );
define( 'WP_SITEURL', getenv_docker( 'WP_SITEURL', '' ) );

/**
 * Manage Post revisions and autosave
 */

define( 'AUTOSAVE_INTERVAL', getenv_docker( 'AUTOSAVE_INTERVAL', '' ) );
define( 'WP_POST_REVISIONS', getenv_docker( 'WP_POST_REVISIONS', '' ) );

/**
 * Manage Trash auto empty
 */

define( 'EMPTY_TRASH_DAYS', getenv_docker( 'EMPTY_TRASH_DAYS', '' ) );

/* Add any custom values between this line and the "stop editing" line. */

// If we're behind a proxy server and using HTTPS, we need to alert WordPress of that fact
// see also https://wordpress.org/support/article/administration-over-ssl/#using-a-reverse-proxy
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && strpos( $_SERVER['HTTP_X_FORWARDED_PROTO'], 'https' ) !== false ) {
	$_SERVER['HTTPS'] = 'on';
}
// (we include this by default because reverse proxying is extremely common in container environments)

if ( $configExtra = getenv_docker( 'WORDPRESS_CONFIG_EXTRA', '' ) ) {
	eval( $configExtra );
}

define( 'SCRIPT_DEBUG', true );


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}




/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
