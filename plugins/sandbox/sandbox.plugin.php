<?php

/**
 *  Sandbox plugin
 *
 *  @package Promo
 *  @subpackage Plugins
 *  @author Yudin Evgeniy / JINN
 *  @copyright 2014-2015 Yudin Evgeniy / JINN
 *  @version 1.0.0
 *
 */

// Register plugin
Plugin::register( __FILE__,
                __('Sandbox', 'sandbox'),
                __('Sandbox plugin for Promo', 'sandbox'),
                '1.0.0',
                'JINN',
                'http://cms.promo360.ru/',
                'sandbox');

// Load Sandbox Admin for Editor and Admin
if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin', 'editor'))) {

    Plugin::admin('sandbox');

}

/**
 * Sandbox class
 */
class Sandbox extends Frontend
{
    /**
     * Sandbox main function
     */
    public static function main()
    {
        // Do something...
    }

    /**
     * Set Sandbox title
     */
    public static function title()
    {
        return 'Sandbox title';
    }

    /**
     * Set Sandbox keywords
     */
    public static function keywords()
    {
        return 'Sandbox keywords';
    }

    /**
     * Set Sandbox description
     */
    public static function description()
    {
        return 'Sandbox description';
    }

    /**
     * Set Sandbox content
     */
    public static function content()
    {
        return 'Sandbox content';
    }

    /**
     * Set Sandbox template
     */
    public static function template()
    {
        return 'index';
    }
}
