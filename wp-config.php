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
define('DB_NAME', 'justice');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost:8888');

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
define('AUTH_KEY',         'QRf6tUa^lP]q_N_,Dt!2{S/HNt}RQp #2Q],ifvEN~p`(6/gcDn9e?+).><TiJQI');
define('SECURE_AUTH_KEY',  '(*jZ>+jB2F*,fdAzo}cb<UEB)BTxq(N@.43J=<w-]#)zB2(r8LuZ%{uhJgX}13iq');
define('LOGGED_IN_KEY',    'H1;D]UM6oUp07?T!ghHORpN)XAT:att}g>.Ko(Jj<}*ids:)vbi@u`loF*k3?o;}');
define('NONCE_KEY',        'cH.]#ra`0Nt-ct-$MAE|.v2LG5b9>ZCUFb5WR~(WYsF*}U$LzPuMYPDxVs(T2Cg<');
define('AUTH_SALT',        '.l|i@0Bvr2`Gglc{3Q4`xsG1xW(/a|ji[7u#=<^{2wRj9Y~.5:q_<Td)/ZtTYlUB');
define('SECURE_AUTH_SALT', 'eS`hM(B=FFf]7{]2^>>~9I/Iet7yD7}!1-% (2*ln2H~)Cv8T8AoO+`l$dOGea@w');
define('LOGGED_IN_SALT',   '/[~UD_Wv9>73QnA90Fw/:PB][)7u>FWpi2w`VdMyLgYX?EO&6u(MLDZ#fG~<nI.9');
define('NONCE_SALT',       'GuVtltUNY&!b%MT<&KxNPe,s<zs6m^+kWwP#t@l1Ozc-C6a6<&Kyyx%mWnqGL)hS');

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
