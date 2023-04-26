<?php
define( 'WP_CACHE', false ); // Added by WP Rocket

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
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
define( 'DB_NAME', 'scionintl_new' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         'v2jeU)~mQmOK8uaBH]F!HrGuU_pUp[=G(~<!Kv;.#!|NZiRUh3:66#W<w%fU2940' );
define( 'SECURE_AUTH_KEY',  'S($5k+o)N/v](R!>J/$cy}YBH*jl)Bg-vjHc}PfR7CPF+[f0<*4{Vv2?^xVxY[M<' );
define( 'LOGGED_IN_KEY',    '/C%Va^/=[gIEROI6J++LZZBzSa7R&wu~bFczfQV;Sf^5BUY{SAqb&>_Ln}a#KSxN' );
define( 'NONCE_KEY',        'XoruJW9%Z|)#:Ruf;o4eyY]pm9&bJ#ptl+}z+Vg,onJA8-,*a9-l;wt8u&*Vn{Jt' );
define( 'AUTH_SALT',        ')l1 {a+blWVIzM}h[i:uLyUh+B}&ydXvdK}TF.,~7q@vIQ0s,Dhn.*KL:@ZF>IX-' );
define( 'SECURE_AUTH_SALT', 'i5EhfY>(QeDvk e,+Glah#2T)5klLf+#p dpP^JNlmTLGf}8;pyf8$) [G<c`1P0' );
define( 'LOGGED_IN_SALT',   'u)xJBgkQ+g)O[o@J@Gud~6pw4z-.p~g~&Qff3&?uO/oq)8@(@.eglY2SD%u3P{=v' );
define( 'NONCE_SALT',       '2p9f,uB0w/$@|sg<([SAAd`U[D<5T@+k%7V>m!iwj2c$<&c;{C6f[hn8ET54a=Hw' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
