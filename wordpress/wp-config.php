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
define('DB_NAME', 'gyaneo');

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
define('AUTH_KEY',         '*`r4_Y%.Pl Z(hwBs*OUYBGd;JqDyWq/wyY)_19H$Sccm&+==w_kCsOB$8m}ugJA');
define('SECURE_AUTH_KEY',  '%9=9`M^BGN@]{5|JTgu]{uPUs]kSo8Ka.i((_G~]_G>_5af=bQFFpv/vQ//Eg^p8');
define('LOGGED_IN_KEY',    'E|xY2j;fiM CVW]W$,.@<Tg%>0X,C4~Og|)^?1M.S]H[5nkU>F_kBx`q2Z6A}`6i');
define('NONCE_KEY',        'H(XW+(~{:yY/!djw58l*^EL0qN6K5NekBn%Q%y@Oh2E(qG[Dj~R<XA8^v=fT(<>J');
define('AUTH_SALT',        '$7;y|@0D8uLiZ,=/F3aYx8?=w$`l{~rn1Q83mXY^_It26PaGm.J]{w t<x>^1yo[');
define('SECURE_AUTH_SALT', 'Aiu-Q/u/MoK#~8[I>elobI>,S).c9nQq5p.@&oHNa7sV<K}aW$#dfP0GK$3b7SZ/');
define('LOGGED_IN_SALT',   '~^iZE!+I3RbGWFZ$=f[Q<1txyX]k0Mi7]]NQ1&oy%>%.t`H-gPvSZpdR8*V-!1?0');
define('NONCE_SALT',       'MJJxWJ/r,H*_5arbl}_.fM3Nf]~09Wy0[<!L%z !>u_[qi]GmbY50^Ttk[-Xd ^b');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'gy';

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
