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
define( 'DB_NAME', 'renewgroup_wp' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
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
define( 'AUTH_KEY',         ';Ej`!<8GmtO`tc{34_f5=|YFE]xH/W?f&wPFt*=}yOgv%)C.TH6dKF-x^]j8mbzN' );
define( 'SECURE_AUTH_KEY',  'zk#@!fBw%:<3Hta3~e@GS16kBbknis|&@F)(/+%`wWBtiP3jPLM vL,/@*|n4GW*' );
define( 'LOGGED_IN_KEY',    ']5z>}|{:m?g+2JXnM{AWPAA=u,I4w2]qa%K4}1!9Ibsh=nF+Po~1eGwB3`Q:QS2@' );
define( 'NONCE_KEY',        '):x9]2iVz@;XK{O3@yvm<[Z{g&wRj+rSQwH<u m#539]cR+epk(Z;ZI}hfK<3jo*' );
define( 'AUTH_SALT',        'nE3xQiZwQhy%?eaNl0b~-tJ*]yCyD(kpD%g~d1TYGDpX0_bC0qM)zehx&AZYz,[B' );
define( 'SECURE_AUTH_SALT', 'w3ciT2pFan#jl b!yt7i/KoC(U)QMfJhmM)G^zJ^V~0{v^sqM-@$Zk[,]x`tCr6o' );
define( 'LOGGED_IN_SALT',   '|i`T&XZA^6<AET5ls44%ho9>(Js4`8Jz@1C=Q;c/M=9WB~tCz- &Ze<@~pzU;QO&' );
define( 'NONCE_SALT',       '.K=9#`g:N1pfyd16q29/u0Yl-{:8~~w=mw8#6Lgq`pG6jZJqwyg<D!f2e0-N0H%<' );

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
$table_prefix = 'rgc_';

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



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
