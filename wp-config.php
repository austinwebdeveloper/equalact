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
define('AUTH_KEY',         '>/&RujM7u8(oRshl&U^#8]_.j^:;y4rtwC91w$<#=hVZ]?Pq|({My;NgZP*+zxlF');
define('SECURE_AUTH_KEY',  'z;82n>KyP<BMKkfzmaB`D%-HF=k&b= ,)x/}u%#%8/47Fvl;u?[^hg`x?~{$g(a<');
define('LOGGED_IN_KEY',    '7uRtq)OPB$~Bo7ZReyFj6ekt4Z{6>d+{_)|%e2bKw[`(z*N@ej@m8 Qb{ARD<.~i');
define('NONCE_KEY',        '.Es?NSJy:bdMHrK?=#1bVV}}4%0C&p}19|tP/k7XulMXyu|>Z[{+y:eezTT<MwkR');
define('AUTH_SALT',        'f.n`2iWDAMrCDpho%X:^O>+_*e}tm4#)BDIuIsm(b88{vqJ$O[~Z<K,:$AUR5%s5');
define('SECURE_AUTH_SALT', '}2^H[`lA(lze |sI>gr,HmC3on~=Hfl#KmeS(dc,dxs;fL:^p5egg9js=XWPEx&8');
define('LOGGED_IN_SALT',   'g*OQ@mAkZcz3wu.TAjR4YSh%kg[[cfs#;oMn^) oy28tiI*$o]e6<;,6(jZ{HQB}');
define('NONCE_SALT',       'XFc/xh3?^{G8LIcGDHDl?pm6zDnQ:_q[QI!HGN]b!3Y%MTZ-y:o)t hsXXpSi2*C');

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
