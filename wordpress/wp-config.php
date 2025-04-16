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
define( 'DB_NAME', 'nataysa' );

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
define( 'AUTH_KEY',         '@Iu?>L:Fm1PC!HDsXk)B?<wY)tatbUMJF9qogZ<.X}~d2j=eqjO;VKa1l=lB&zx>' );
define( 'SECURE_AUTH_KEY',  'A[Y.QhQQIJPM+e[oUlCr%+<>>S!`=?Rv?[{#:PxN|6e@;J]JP^^IWYRU /p=D/@S' );
define( 'LOGGED_IN_KEY',    '9#J|1tA1iP+b$I}H~<?2Yc{dw?069l7[y;NF:,Su>8}_60a?IE(kG05Ya~dA+^GY' );
define( 'NONCE_KEY',        ',%a5)_%Bjs*Y}#B f+/`IGo7,iC[o*dBYzIF-3B:Ny&<5x_t,blCNa<3Z81*F>nn' );
define( 'AUTH_SALT',        '!8VyW0s?wtV13rUBy0X>K*Em`2VrimXz_p%p&hjsQp]!#Ch?Vyi} zcfIn=QZP n' );
define( 'SECURE_AUTH_SALT', 'iVQK9VrPYH]ZpBIBm2Ar|U&s^(t3/PhB0.JXnSpjT_(77RZH9sD5,@$-7d!&yGo;' );
define( 'LOGGED_IN_SALT',   ':.OmS<:/0AaTWX[AP>A$)=DGuTe9ei&BHh34~9L4Nj+GY]C$B4LsCUM|^hQk >3f' );
define( 'NONCE_SALT',       'wV=^_b$C8E3]C]y^+0lSx)~tH5UflYk#c3tHUD 0(6-~Je~1|Ut9h 6du21T@hRb' );

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
