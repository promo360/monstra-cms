<?php

/**
 *  Breadcrumbs plugin
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
                __('Breadcrumbs', 'breadcrumbs'),
                __('Breadcrumbs plugin for Promo CMS', 'breadcrumbs'),
                '1.0.0',
                'JINN',
                'http://cms.promo360.ru',
                null,
                'box');

// Load Breadcrumbs Admin for Editor and Admin
if (Session::exists('user_role') && in_array(Session::get('user_role'), array('admin', 'editor'))) {
    Plugin::admin('breadcrumbs', 'box');
}

class Breadcrumbs
{
    /**
     * Path
     *
     * @var array
     */
    public static $path = array();
    
    /**
     *  Добавление хлебных крошек
     *
     *  <code>
     *      // Добавление новой ссылки
     *      Breadcrumbs::add('http://site.ru/link', 'Заголовок');
     *  </code>
     */
    public static function add($link, $name)
    {
        Breadcrumbs::$path[] = array('link' => $link, 'name' => $name);
    }
    
    /**
     *  Считаем, количество добавленных ссылок
     *
     *  <code>
     *      echo Breadcrumbs::count();
     *  </code>
     */
    public static function count()
    {
        return count(Breadcrumbs::$path);
    }
    
    /**
     * Вывод хлебных крошек
     *
     *  <code>
     *      // Выводим весь путь
     *      echo Breadcrumbs::get();
     *  </code>
     */
    public static function get($args = array())
    {
        $count = count(Breadcrumbs::$path);
        
        // Ссылка на главную
        if (empty($args['home_link'])) $args['home_link'] = Site::url();
        
        // Название ссылки на главную, по умолчанию "Главная"
        if (empty($args['home_name'])) $args['home_name'] = __('Home', 'breadcrumbs');
        
        // Знак разделителя, между ссылками
        if (empty($args['divider'])) $args['divider'] = '&rarr;';
        
        // Шаблон для хлебных крошек
        if (empty($args['view'])) $args['view'] = 'breadcrumbs';
        
        if ($count > 0) {
            return View::factory('box/breadcrumbs/views/'.((BACKEND) ? 'backend' : 'frontend').'/'.$args['view'])
                ->assign('path', Breadcrumbs::$path)
                ->assign('count', $count)
                ->assign('args', $args)
                ->render();

        }
    }
}
