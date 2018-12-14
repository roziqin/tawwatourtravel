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
define('DB_NAME', 'new_tawwatour');

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
define('AUTH_KEY',         '5QMy&l@l?5bbJmAm]be;P.(Ri(OJKri{~@tD[<?5x>&:-Ctc,Adj1T}Qt!blPyqn');
define('SECURE_AUTH_KEY',  'JRSlq-:@k/}gR<<<fI(_,47Xw@_Mp:My)(;!RM%8vMp@Vd3dnM=NJU-c$wP)Ttf?');
define('LOGGED_IN_KEY',    '~]UaAlf]_UXFJ1Xy!]:tY+}X/}G/oNI UubU#q1cjn%:9V-N+R-i{[]bCY6CB/0x');
define('NONCE_KEY',        'p;_0S%87}v.sS~n}sPUkai|)2ay$vcs:!gw^GyB`{on:[B,x&S$MI/2{gGA`GUj)');
define('AUTH_SALT',        '%lo]];$Kf*F2X#jFdQ68a7f_/ 9[2-%>FO-6nqt|Hin4[.+LC-$ZLi?k`<st]zxi');
define('SECURE_AUTH_SALT', '>0,C0,HC>%>517YKT=prdh)Rg$#2.HrY4kNoc[)-15{b>Q=uD&-iPCf5u/O@?uFS');
define('LOGGED_IN_SALT',   '_^$qAA4`11d$LHJ=x+u5{BM7Dj]m?`n&Ar1D*`.C*Si`uw4^]NQn%ER1`K0}c6Xg');
define('NONCE_SALT',       'T?MV`_(T0IBmH]Cy&0V+op|4am`>~.m&MklkS#m*d0t/;]BwNm<gE.6 jL?;RSA.');

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
