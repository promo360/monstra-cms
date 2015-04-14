<?php

/**
 *  Breadcrumbs plugin
 *
 *  @package Promo360 CMS
 *  @subpackage Plugins
 *  @author Yudin Evgeniy / JINN
 *  @copyright 2014 Yudin Evgeniy / JINN
 *  @version 1.0.0
 *
 */

// Register plugin
Plugin::register( __FILE__,
                __('Breadcrumbs', 'forms'),
                __('Breadcrumbs plugin for Promo360', 'forms'),
                '1.0.0',
                'JINN',
                'http://cms.promo360.ru',
                null,
                'box');

// Load Forms Admin for Editor and Admin
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
     *  ���������� ������� ������
     *
     *  <code>
     *      // ���������� ����� ������
     *      Breadcrumbs::add('http://site.ru/link', '���������');
     *  </code>
     */
    public static function add($link, $name)
    {
        Breadcrumbs::$path[] = array('link' => $link, 'name' => $name);
    }
    
    /**
     *  �������, ���������� ����������� ������
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
     * ����� ������� ������
     *
     *  <code>
     *      // ������� ���� ����
     *      echo Breadcrumbs::get();
     *  </code>
     */
    public static function get($args = array())
    {
        $count = count(Breadcrumbs::$path);
        
        // ������ �� �������
        if (empty($args['home_link'])) $args['home_link'] = Site::url();
        
        // �������� ������ �� �������, �� ��������� "�������"
        if (empty($args['home_name'])) $args['home_name'] = __('Home', 'breadcrumbs');
        
        // ���� �����������, ����� ��������
        if (empty($args['divider'])) $args['divider'] = '&rarr;';
        
        // ������ ��� ������� ������
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
