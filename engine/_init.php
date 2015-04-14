<?php defined('PROMO_ACCESS') or die('No direct script access.');

/**
 *  Promo requires PHP 5.3.0 or greater
 */
if (version_compare(PHP_VERSION, "5.3.0", "<")) {
    exit("Promo requires PHP 5.3.0 or greater.");
}

/**
 *  Include Promo Engine
 */
include ROOT . DS .'engine'. DS .'Promo.php';

/**
 * Set Promo Environment
 *
 * Promo has four predefined environments:
 *   Promo::DEVELOPMENT - The development environment.
 *   Promo::TESTING     - The test environment.
 *   Promo::STAGING     - The staging environment.
 *   Promo::PRODUCTION  - The production environment.
 */
Promo::$environment = Promo::PRODUCTION;

/**
 * Report Errors
 */
if (Promo::$environment == Promo::PRODUCTION) {
    error_reporting(0); 
} else {
    error_reporting(-1);
}

/**
 * Initialize Promo
 */
Promo::init();
