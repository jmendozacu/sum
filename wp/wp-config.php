<?php
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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'summit_blog');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '6tJdz6?_2h[a/fuyvgjK9n+Kv;Z)t=G::#,wcy-}1:n%BkjV`(H^``i8kq2pDD?V');
define('SECURE_AUTH_KEY',  'W>xF[pX^;!&&%%ElfSAR}tod}%:{4vNU8GZ;F(nfwid%L[/18Z-l=WZ>?TIO ouA');
define('LOGGED_IN_KEY',    '_o=^fx(N?[i7gBt[ sK3jcKV)Qdb?5~A^(fdTHw{+#}%|*7v5B^vyzL3AA/[H3Z.');
define('NONCE_KEY',        'u6u.nhp9ueadRM1,d~B31Wok&c842~`/3<vB3Yzlm<OFvwq+ZQt]wj2D|EmF6=}?');
define('AUTH_SALT',        '_:52J)ct?A(-}!r!6Obwcw+gp3=%vrov(I%hzXc&51eWUBlrPRz6zh<b)IhzYZ(w');
define('SECURE_AUTH_SALT', 'rzOe=Zw,`^_#J0+QX)p@z1]8d+hTr4jBnN2fWr?F<:{m6t||G_58$.jS~P:6qy%*');
define('LOGGED_IN_SALT',   'vso]>$gWekn@he vxS5zu:a~s%5gY.;TL#^ZL$;8ccm=1>.a@7w%fdv]Wpe!Zrog');
define('NONCE_SALT',       'ZML1z|CpU:9En=9O~B:hWsw4EL.H_Z[yst|c$|V@#on!1|I/oWjj)7=ryGtmft<H');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
