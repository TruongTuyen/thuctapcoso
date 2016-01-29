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
define('DB_NAME', 'thuctapcoso');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'Xu+%iiPRN(!|sx5wY2xY1UX<V^ki7M[+Ac[+@Q<F`-CVHw:hcU{BVneq[nrng9rV');
define('SECURE_AUTH_KEY',  ' 0[S^8(lxmHSgSh$EGH~vHR9^PDUg(iS/Y5nN_K|93?e0`-Ex2&}A*;[(YZ2{-+B');
define('LOGGED_IN_KEY',    'C>tZ>L+vC)>(zJ`b7[3F+<]/qz~Hbr?Zi:_8k`#&VB;*X8?)#l+Ye2=fHK$1AxW7');
define('NONCE_KEY',        '$+c|w)zw0|pw(dHCa~IF--{[lAdV>odT:5vkw7(|L1,NK/Pypry6I#Pf@7]%vBIA');
define('AUTH_SALT',        '${?2%;YBhmHa>~`h]^I9)E+9HiNw[{p!j/cA::)yl|C1Dw20U 3zUElA^Xe|A_&B');
define('SECURE_AUTH_SALT', 'NEzZghbr|YWz^Jst@t-@7+&YM785H-++P%&7SLBha6p`XEs{TSu#=W@F-0*^>qj7');
define('LOGGED_IN_SALT',   'Wo)|{J2+Bl8wK6@yYrwAO,_X~j~5CQ56;x^bNAk5B&;M|0ULc0ix,5-2,+Y(s%eg');
define('NONCE_SALT',       'O PG-}m)MI.Nw IWr#w;Cbow`gUu@h*n~/1rAMs[:IuatHZ8?JgEigJs+|V5a0FK');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_tt_';

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
