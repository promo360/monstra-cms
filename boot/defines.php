<?php defined('PROMO_ACCESS') or die('No direct script access.');

/**
 * Promo CMS Defines
 */

/**
 * The filesystem path to the site 'themes' folder
 */
define('THEMES_SITE', ROOT . DS . 'public' . DS . 'themes');

/**
 * The filesystem path to the admin 'themes' folder
 */
define('THEMES_ADMIN', ROOT . DS . 'admin' . DS . 'themes');

/**
 * The filesystem path to the 'plugins' folder
 */
define('PLUGINS', ROOT . DS . 'plugins');

/**
 * The filesystem path to the 'box' folder which is contained within
 * the 'plugins' folder
 */
define('PLUGINS_BOX', PLUGINS . DS . 'box');

/**
 * The filesystem path to the 'storage' folder
 */
define('STORAGE', ROOT . DS . 'storage');

/**
 * The filesystem path to the 'xmldb' folder
 */
define('XMLDB', STORAGE . DS . 'database');

/**
 * The filesystem path to the 'cache' folder
 */
define('CACHE', ROOT . DS . 'tmp' . DS . 'cache');

/**
 * The filesystem path to the 'minify' folder
 */
define('MINIFY', ROOT . DS . 'tmp' . DS . 'minify');

/**
 * The filesystem path to the 'logs' folder
 */
define('LOGS', ROOT . DS . 'tmp' . DS . 'logs');

/**
 * The filesystem path to the 'assets' folder
 */
define('ASSETS', ROOT . DS . 'public' . DS . 'assets');

/**
 * The filesystem path to the 'uploads' folder
 */
define('UPLOADS', ROOT . DS . 'public' . DS . 'uploads');

/**
 * Set password salt
 */
define('PROMO_PASSWORD_SALT', 'YOUR_SALT_HERE');

/**
 * Set date format
 */
define('PROMO_DATE_FORMAT', 'Y-m-d / H:i:s');

/**
 * Set eval php
 */
define('PROMO_EVAL_PHP', false);

/**
 * Check Promo CMS version
 */
define('CHECK_PROMO_VERSION', true);

/**
 * Set gzip output
 */
define('PROMO_GZIP', false);

/**
 * Promo database settings
 */
//define('PROMO_DB_DSN', 'mysql:dbname=promo;host=localhost;port=3306');
//define('PROMO_DB_USER', 'root');
//define('PROMO_DB_PASSWORD', 'password');
