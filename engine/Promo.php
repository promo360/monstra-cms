<?php defined('PROMO_ACCESS') or die('No direct script access.');

/**
 * Monstra Engine
 *
 *  Monstra - Content Management System.
 *  Site: www.mostra.org
 *  Copyright (C) 2012-2014 Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * This source file is part of the Monstra Engine. More information,
 * documentation and tutorials can be found at http://monstra.org
 *
 * @package     Monstra
 *
 * @author      Romanenko Sergey / Awilum <awilum@msn.com>
 * @copyright   2012-2014 Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Promo
{
    /**
     * An instance of the Promo class
     *
     * @var core
     */
    protected static $instance = null;

    /**
     * Common environment type constants for consistency and convenience
     */
    const PRODUCTION  = 1;
    const STAGING     = 2;
    const TESTING     = 3;
    const DEVELOPMENT = 4;

    /**
     * The version of Promo
     */
    const VERSION = '0.9.0';


    /**
     * Promo environment
     *
     * @var string
     */
    public static $environment = Promo::PRODUCTION;

    /**
     * Promo environment names
     *
     * @var array
     */
    public static $environment_names = array(
        Promo::PRODUCTION  => 'production',
        Promo::STAGING     => 'staging',
        Promo::TESTING     => 'testing',
        Promo::DEVELOPMENT => 'development',
    );

    /**
     * Protected clone method to enforce singleton behavior.
     *
     * @access  protected
     */
    protected function __clone()
    {
        // Nothing here.
    }

    /**
     * Protected Construct
     */
    protected function __construct()
    {
        /**
         * Load core defines
         */
        Promo::loadDefines();

        /**
         * Compress HTML with gzip
         */
        if (PROMO_GZIP) {
            if ( ! ob_start("ob_gzhandler")) ob_start();
        } else {
            ob_start();
        }

        /**
         * Send default header and set internal encoding
         */
        header('Content-Type: text/html; charset=UTF-8');
        function_exists('mb_language') AND mb_language('uni');
        function_exists('mb_regex_encoding') AND mb_regex_encoding('UTF-8');
        function_exists('mb_internal_encoding') AND mb_internal_encoding('UTF-8');

        /**
         * Gets the current configuration setting of magic_quotes_gpc
         * and kill magic quotes
         */
        if (get_magic_quotes_gpc()) {
            function stripslashesGPC(&$value) { $value = stripslashes($value); }
            array_walk_recursive($_GET, 'stripslashesGPC');
            array_walk_recursive($_POST, 'stripslashesGPC');
            array_walk_recursive($_COOKIE, 'stripslashesGPC');
            array_walk_recursive($_REQUEST, 'stripslashesGPC');
        }

        /**
         * Set Gelato Display Errors to False for Production environment.
         */
        if (Promo::$environment == Promo::PRODUCTION) {
            define('GELATO_DEVELOPMENT', false);
        }

        /**
         * Define Promo Folder for Gelato Logs
         */
        define ('GELATO_LOGS_PATH', LOGS);

        /**
         * Include Gelato Library
         */
        include ROOT . DS . 'libraries'. DS .'Gelato'. DS .'Gelato.php';

        /**
         * Map Promo Engine Directory
         */
        ClassLoader::directory(ROOT . DS . 'engine' . DS);

        /**
         * Map all Promo Classes
         */
        ClassLoader::mapClasses(array(

            // Site Modules
            'Security'  => ROOT . DS .'engine'. DS .'Security.php',
            'Uri'       => ROOT . DS .'engine'. DS .'Uri.php',
            'Site'      => ROOT . DS .'engine'. DS .'Site.php',
            'Alert'     => ROOT . DS .'engine'. DS .'Alert.php',

            // XMLDB API
            'XML'       => ROOT . DS .'engine'. DS .'Xmldb'. DS .'XML.php',
            'DB'        => ROOT . DS .'engine'. DS .'Xmldb'. DS .'DB.php',
            'Table'     => ROOT . DS .'engine'. DS .'Xmldb'. DS .'Table.php',

            // Plugin API
            'Plugin'     => ROOT . DS .'engine'. DS .'Plugin'. DS .'Plugin.php',
            'Frontend'   => ROOT . DS .'engine'. DS .'Plugin'. DS .'Frontend.php',
            'Backend'    => ROOT . DS .'engine'. DS .'Plugin'. DS .'Backend.php',
            'Action'     => ROOT . DS .'engine'. DS .'Plugin'. DS .'Action.php',
            'Filter'     => ROOT . DS .'engine'. DS .'Plugin'. DS .'Filter.php',
            'View'       => ROOT . DS .'engine'. DS .'Plugin'. DS .'View.php',
            'I18n'       => ROOT . DS .'engine'. DS .'Plugin'. DS .'I18n.php',
            'Stylesheet' => ROOT . DS .'engine'. DS .'Plugin'. DS .'Stylesheet.php',
            'Javascript' => ROOT . DS .'engine'. DS .'Plugin'. DS .'Javascript.php',
            'Navigation' => ROOT . DS .'engine'. DS .'Plugin'. DS .'Navigation.php',

            // Option API
            'Option'    => ROOT . DS .'engine'. DS .'Option.php',

            // Shortcode API
            'Shortcode' => ROOT . DS .'engine'. DS .'Shortcode.php',

            // Idiorm
            'ORM'       => ROOT . DS .'libraries'. DS . 'Idiorm'. DS .'ORM.php',

            // PHPMailer
            'PHPMailer' => ROOT . DS .'libraries'. DS . 'PHPMailer'. DS .'PHPMailer.php',
        ));

        /**
         *  Start session
         */
        Session::start();

        /**
         * Init Idiorm
         */
        if (defined('PROMO_DB_DSN')) {
            ORM::configure(PROMO_DB_DSN);
            ORM::configure('username', PROMO_DB_USER);
            ORM::configure('password',  PROMO_DB_PASSWORD);
            ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        }

        /**
         * Auto cleanup if DEVELOPMENT environment
         */
        if (Promo::$environment == Promo::DEVELOPMENT) {
            Promo::cleanTmp();
        }

        /**
         * Set Cache dir
         */
        Cache::configure('cache_dir', CACHE);

        /**
         * Init Options API module
         */
        Option::init();

        /**
         * Set default timezone
         */
        @ini_set('date.timezone', Option::get('timezone'));
        if (function_exists('date_default_timezone_set')) date_default_timezone_set(Option::get('timezone')); else putenv('TZ='.Option::get('timezone'));

        /**
         * Sanitize URL to prevent XSS - Cross-site scripting
         */
        Security::runSanitizeURL();

        /**
         * Load default
         */
        Promo::loadPluggable();

        /**
         * Init I18n
         */
        I18n::init(Option::get('language'));

        /**
         * Init Plugins API
         */
        Plugin::init();

        /**
         * Init Notification service
         */
        Notification::init();

        /**
         * Init site module
         */
        if ( ! BACKEND) Site::init();
    }

    /**
     * Load Defines
     */
    protected static function loadDefines()
    {
        $root_defines         = ROOT . DS . 'boot' . DS . 'defines.php';
        $environment_defines  = ROOT . DS . 'boot' . DS . Promo::$environment_names[Promo::$environment] . DS . 'defines.php';
        $promo_defines      = ROOT . DS . 'engine' . DS . 'boot' . DS . 'defines.php';

        if (file_exists($root_defines)) {
            include $root_defines;
        } elseif (file_exists($environment_defines)) {
            include $environment_defines;
        } elseif (file_exists($promo_defines)) {
            include $promo_defines;
        } else {
            throw new RuntimeException("The defines file does not exist.");
        }
    }

    /**
     * Load Pluggable
     */
    protected static function loadPluggable()
    {
        $root_pluggable         = ROOT . DS . 'boot';
        $environment_pluggable  = ROOT . DS . 'boot' . DS . Promo::$environment_names[Promo::$environment];
        $promo_pluggable      = ROOT . DS . 'engine' . DS . 'boot';

        if (file_exists($root_pluggable . DS . 'filters.php')) {
            include $root_pluggable . DS . 'filters.php';
        } elseif (file_exists($environment_pluggable . DS . 'filters.php')) {
            include $environment_pluggable . DS . 'filters.php';
        } elseif (file_exists($promo_pluggable . DS . 'filters.php')) {
            include $promo_pluggable . DS . 'filters.php';
        } else {
            throw new RuntimeException("The pluggable filters.php file does not exist.");
        }

        if (file_exists($root_pluggable . DS . 'actions.php')) {
            include $root_pluggable . DS . 'actions.php';
        } elseif (file_exists($environment_pluggable . DS . 'actions.php')) {
            include $environment_pluggable . DS . 'actions.php';
        } elseif (file_exists($promo_pluggable . DS . 'actions.php')) {
            include $promo_pluggable . DS . 'actions.php';
        } else {
            throw new RuntimeException("The pluggable actions.php file does not exist.");
        }

        if (file_exists($root_pluggable . DS . 'shortcodes.php')) {
            include $root_pluggable . DS . 'shortcodes.php';
        } elseif (file_exists($environment_pluggable . DS . 'shortcodes.php')) {
            include $environment_pluggable . DS . 'shortcodes.php';
        } elseif (file_exists($promo_pluggable . DS . 'shortcodes.php')) {
            include $promo_pluggable . DS . 'shortcodes.php';
        } else {
            throw new RuntimeException("The pluggable shortcodes.php file does not exist.");
        }

    }

    /**
     * Clean Promo TMP folder.
     */
    public static function cleanTmp()
    {
        // Cleanup minify
        if (count($files = File::scan(MINIFY, array('css', 'js', 'php'))) > 0) foreach ($files as $file) File::delete(MINIFY . DS . $file);

        // Cleanup cache
        if (count($namespaces = Dir::scan(CACHE)) > 0) foreach ($namespaces as $namespace) Dir::delete(CACHE . DS . $namespace);
    }

    /**
     * Initialize Promo Engine
     *
     * @return Promo
     */
    public static function init()
    {
        if ( ! isset(self::$instance)) self::$instance = new Promo();
        return self::$instance;
    }

}
