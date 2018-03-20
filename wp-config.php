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
define('DB_NAME', 'nextu');

/** MySQL database username */
define('DB_USER', 'wordpress');

/** MySQL database password */
define('DB_PASSWORD', '12345');

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
define('AUTH_KEY',         'Ksita}>(UoPpd.l&Wiv(HK^K#$YPDSIcmkVss;XowJdw_$,gVILI rYSiJ&d Se]');
define('SECURE_AUTH_KEY',  'qu0F>|999ftQy|=4nMP@6Q1dirf^)J4H(Pb<d%GP7~feg-VV.Sv1lzXJ0s2&O!aL');
define('LOGGED_IN_KEY',    'Qt/:mabR1aAA;pi4JA$0[_=^.KrcV[4`RIOilYo70)2:V#NavCtZ w3RBB[ZCMCg');
define('NONCE_KEY',        '[56~a9*<v*21/=7i.&7_M+&qodtCE&@+ DDA)w,@zs[t3-bIOh:R;68_1-nMF_-.');
define('AUTH_SALT',        ']$^0K=,0{1f3=APM!A@pPex!q2{L1l3Gy`VKRjf-3cvc8i,dIc{hen:`s5>+M/p@');
define('SECURE_AUTH_SALT', 'F>%~^w2lGun0]pU|}R*J~noclvz88|4ACKB0xebD6qji](G;Vw#2B]`S>{&J!ZD8');
define('LOGGED_IN_SALT',   '9+uKrf5FCJaK{P#|:`aBNBhAv}N11%2`gZD? dP<A uD1=.?yvZZk@g`b^dfs@$9');
define('NONCE_SALT',       '|;iXk-yA?@<S2>j~@f1;q(8T[J<b7MH<u0KZB%o4dfC?CTUQ6k=xf86PJlte4&0k');

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
