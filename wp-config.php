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
define('DB_NAME', '_realtorSG');

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
define('AUTH_KEY',         'p|uGtC:s/RLqXE7/hy29agFaD%2*`|CE27,m3Um}<9r`_]s]B0B2X2tEH@qv-sXO');
define('SECURE_AUTH_KEY',  'k&=z^6(CWkk*5_2x MSQPJI;FbP&R&_W]=g+tGHL?Hsr8la8uJg&k#X^sv6KZs><');
define('LOGGED_IN_KEY',    ':[:0n]y5@uD+*2QiPLrWG+7eK5!N`9hq3?b-H4Gy4+5[90#4KOKB{kJ52+S/qfA`');
define('NONCE_KEY',        'BC[:}@q1);1w#um5XQ;C/kv|2ol3ty,gQ;^y{{XZQ%5P2p:kreWiwpl06m/m$n^ ');
define('AUTH_SALT',        'wpW(66*/4Fz+]Vhm7ESUa^-ST jQ24A6*bFa|A`:#}L:Ycm#*I>;x{|L0~;G,d8f');
define('SECURE_AUTH_SALT', '+qD73Uj:$S~CVwXNA/9-c1CVNX&QCr>@vZTgm%$}ho%@*>8-:)a7x_^ic]m~:-w3');
define('LOGGED_IN_SALT',   'Yd|fR8njL/_/XL,KM<FY`<hJbQfcR2imx-VizHx}Oaly2pMjzq.K3% !%fic7y#F');
define('NONCE_SALT',       'UWO&v0g^bYR&Ip&arL$-c`xcVGyc9W:F5}:,GqMMshPgLeEzFy,aId*Dq tw)KQG');

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
