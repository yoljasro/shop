<?php

// BEGIN iThemes Security - Не меняйте и не удаляйте эту строку
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Отключить редактор файлов - Безопасность > Настройки > Подстройки WordPress > Редактор файлов
// END iThemes Security - Не меняйте и не удаляйте эту строку

define( 'ITSEC_ENCRYPTION_KEY', 'YkNaY3woWnlKckZkJjdMO0diU00jclUzT0IlNHRIQzA7KTQvSkhyWURqIE1yUiowYlBwQEJdNFhmUkc9TUZwQQ==' );

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'delivery_wp0208' );

/** MySQL database username */
define( 'DB_USER', 'delivery_wp0208' );

/** MySQL database password */
define( 'DB_PASSWORD', 'P!a@375XSp' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'jvcinmnmh41kwhabv4lftumm4x8rpg1gpafoqutlf34kd62r0pbtfnmdjmdhcxah' );
define( 'SECURE_AUTH_KEY',  '4uyycv6lu1cus1rupy65mrbd9mrvaxmu5lri2fscbgnwwi9nhxqostusi0aexd6l' );
define( 'LOGGED_IN_KEY',    'w2zcgj1bswa00rildwuz6aeep7rgnumxc5zbx4ix1jcyuhameriapgqwzexb4meh' );
define( 'NONCE_KEY',        'bozfckptlptugttharrnbdwj4vf4iyid5wvpdycxkghulhq60259zt3aumunx8wn' );
define( 'AUTH_SALT',        'e58qyjqmtoytzhrpwgu2edm7nhsegyv811h9envqxruhmraq9sbatuksjqxurknc' );
define( 'SECURE_AUTH_SALT', 'ykdjzdxerwzjmhsggviymosj2wa6gfofcpsfrslr5zuvfwxoelpzygqpdcchpkrs' );
define( 'LOGGED_IN_SALT',   'octuh1fdttlzkrrcvsgfuvskzbycv8swpojz971uowm8fawehaawklggex8gg6ed' );
define( 'NONCE_SALT',       '2lbnyngad2jxsaojre8rplxyub7gtwwrfnap2urkdplt14zsneqhdd29zvtoxpem' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = '';

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
define( 'WP_DEBUG', false );
define('WP_MEMORY_LIMIT', '256M');

/* Multisite */
define( 'WP_ALLOW_MULTISITE', true );
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'deliveryshop.uz');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
