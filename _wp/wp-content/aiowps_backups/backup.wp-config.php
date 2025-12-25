<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'jsnd_wp_dist' );

/** Database username */
define( 'DB_USER', 'jsnd_wp_dist' );

/** Database password */
define( 'DB_PASSWORD', 'We3ARIbR_w0op5-S6wRIP3f3bR-ST2s-' );

/** Database hostname */
define( 'DB_HOST', 'mysql80.jsnd.sakura.ne.jp' );

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
define( 'AUTH_KEY',         '}`]Rw R&&6aoUd!+j(X8D-xvaQ7Dc,n[eU}8hy_|a)&[2CWpA70` 2w#=|Vq$@a;' );
define( 'SECURE_AUTH_KEY',  '/O|X$%&rO=^AOjq.n$=u]cDJ7P)&t4l V)q|OWTjEH2HyoM2N>hy~!N^cxQ@0Z*B' );
define( 'LOGGED_IN_KEY',    'G?8Jq9;SxY&+9r (O`$+&,BB^sdk6O>Z&GplYxl-Xl;w0%OzO]_< Z?6[M-a$^~{' );
define( 'NONCE_KEY',        'aSz}m6WAb@pA8N[&v:B#k^xMQK`SL%bUw)![2r).77I|qu23<.fbI?`W]vR2PUQZ' );
define( 'AUTH_SALT',        'UIv|}1Wdn|Y|t.ks)A_B^}Gi<O^M:UT^K<xo]p U<;jNBdL#oj]*=u{)Kv@j^d6]' );
define( 'SECURE_AUTH_SALT', 'hqq{n!dBEkO-[w6}{rkHK^>JO=y-K-0+pgpGy|ZCJi<VnLZ)<3l,M;1,+Ll6`9-Z' );
define( 'LOGGED_IN_SALT',   '`Ayn3C%2-%3X>:tZ3w0Tdw9H}XjtS/vXhRu1:KcpYiw62w [X#%WZB<CsAxIrRY}' );
define( 'NONCE_SALT',       'wx~CK7S3*Um*|yI5ZH!r)Oc=q#%qQ<8%PMDUvERqai)QzMJ9reWi:nBlAL=4@I F' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_xaw6p_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

// リビジョンを5まで保存
define( 'WP_POST_REVISIONS', 5 );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';