<?php

    /**
     * Promo :: Installator
     */

    // Main engine defines
    if ( ! defined('DS')) define('DS', DIRECTORY_SEPARATOR);
    if ( ! defined('ROOT')) define('ROOT', rtrim(dirname(__FILE__), '\\/'));
    if ( ! defined('BACKEND')) define('BACKEND', false);
    if ( ! defined('PROMO_ACCESS')) define('PROMO_ACCESS', true);

    // Load bootstrap file
    require_once(ROOT . DS . 'engine' . DS . '_init.php');

    // Get array with the names of all modules compiled and loaded
    $php_modules = get_loaded_extensions();

    // Get server port    
    if ($_SERVER["SERVER_PORT"] == "80") $port = ""; else $port = ':'.$_SERVER["SERVER_PORT"];
    
    // Get site URL
    $site_url = 'http://'.$_SERVER["SERVER_NAME"].$port.str_replace(array("index.php", "install.php"), "", $_SERVER['PHP_SELF']);

    // Replace last slash in site_url
    $site_url = rtrim($site_url, '/');

    // Rewrite base
    $rewrite_base = str_replace(array("index.php", "install.php"), "", $_SERVER['PHP_SELF']);

    // Errors array
    $errors = array();

    // Directories to check
    $dir_array = array('public', 'storage', 'backups', 'tmp');

    // Languages array
    $languages_array = array('ru', 'en');

    // Select Promo language
    if (Request::get('language')) {
        if (Request::get('action') && Request::get('action') == 'install') {
            $action = '?action=install';
        } else {
            $action = '';
        }
        if (in_array(Request::get('language'), $languages_array)) {
            if (Option::update('language', Request::get('language'))) {
                Request::redirect($site_url.$action);
            }
        } else {
            Request::redirect($site_url.$action);
        }
    }

    // If pressed <Install> button then try to install
    if (Request::post('install_submit')) {

        if (Request::post('sitename') == '')           $errors['sitename'] = __('Field "Site name" is empty', 'system');
        if (Request::post('siteurl') == '')            $errors['siteurl'] = __('Field "Site url" is empty', 'system');
        if (Request::post('login') == '')              $errors['login'] = __('Field "Username" is empty', 'system');
        if (Request::post('password') == '')           $errors['password'] = __('Field "Password" is empty', 'system');
        if (Request::post('email') == '')              $errors['email'] = __('Field "Email" is empty', 'system');
        if ( ! Valid::email(Request::post('email')))   $errors['email_valid'] = __('Email not valid', 'system');
        if (trim(Request::post('php') !== ''))         $errors['php'] = true;
        if (trim(Request::post('simplexml') !== ''))   $errors['simplexml'] = true;
        if (trim(Request::post('mod_rewrite') !== '')) $errors['mod_rewrite'] = true;
        if (trim(Request::post('htaccess') !== ''))    $errors['htaccess'] = true;
        if (trim(Request::post('sitemap') !== ''))     $errors['sitemap'] = true;
        if (trim(Request::post('install') !== ''))     $errors['install'] = true;
        if (trim(Request::post('public') !== ''))      $errors['public'] = true;
        if (trim(Request::post('storage') !== ''))     $errors['storage'] = true;
        if (trim(Request::post('backups') !== ''))     $errors['backups'] = true;
        if (trim(Request::post('tmp') !== ''))         $errors['tmp'] = true;

        // If errors is 0 then install cms
        if (count($errors) == 0) {

            // Update options
            Option::update(array('maintenance_status' => 'off',
                                 'sitename'           => Request::post('sitename'),
                                 'siteurl'            => Request::post('siteurl'),
                                 'slogan'             => __('Site slogan', 'system'),
                                 'defaultpage'        => 'home',
                                 'timezone'           => Request::post('timezone'),
                                 'system_email'       => Request::post('email'),
                                 'theme_site_name'    => 'default',
                                 'theme_admin_name'   => 'default'));

            // Get users table
            $users = new Table('users');

            // Insert new user with role = admin
            $users->insert(array('login'           => Security::safeName(Request::post('login')),
                                 'password'        => Security::encryptPassword(Request::post('password')),
                                 'email'           => Request::post('email'),
                                 'hash'            => Text::random('alnum', 12),
                                 'date_registered' => time(),
                                 'role'            => 'admin'));

            // Write .htaccess
            $htaccess = file_get_contents('.htaccess');
            $save_htaccess_content = str_replace("/%siteurlhere%/", $rewrite_base, $htaccess);

            $handle = fopen ('.htaccess', "w");
            fwrite($handle, $save_htaccess_content);
            fclose($handle);

            // Installation done :)
            header("location: index.php?install=done");
        } else {            
            Notification::setNow('errors', $errors);                
        }
    }
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>PROMO CMS :: Установка</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <link rel="icon" href="<?php echo $site_url; ?>/favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="<?php echo $site_url; ?>/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="<?php echo $site_url; ?>/public/assets/css/bootstrap.css" media="all" type="text/css" />
        <link rel="stylesheet" href="<?php echo $site_url; ?>/admin/themes/default/css/default.css" media="all" type="text/css" />

        <style>

            .install-body {
                margin-top: 40px;
                background: #FAFAFA;
            }

            .install-languages {
                margin: 20px auto 20px;
                text-align: center;
                width: 600px;
            }

            .install-block,
            .promo-dialog,
            .install-block-footer {
                margin: 0 auto;
                width: 600px;                
            }

            .install-block-footer {
                margin-top: 20px;
                margin-bottom: 20px;
            }

            .well {                                
                border: none;
                border-radius: 0px;
                background: #fff;
                color: #555;
                -webkit-font-smoothing: subpixel-antialiased;
                -webkit-box-shadow: 0 1px 3px rgba(0,0,0,.13);
                        box-shadow: 0 1px 3px rgba(0,0,0,.13);
            }


            .form-control {
                border-radius: 0px;
            }

            .promo-says {
                margin: 20px;
            }

            .error {
                color:#8E0505;
                padding-top: 5px;
                padding-bottom: 5px;
                padding-top: 5px;
                padding-bottom: 5px;
                margin-bottom: 5px;
            }

            .ok {
                color:#00853F;
                padding-top: 5px;
                padding-bottom: 5px;
                margin-bottom: 5px;
            }

            .warn {
                color: #F74C18;
                padding-top: 5px;
                padding-bottom: 5px;
            }

            .install-languages a {
                padding-left: 2px;
                padding-right: 2px;
            }

            .language-link img {
                -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=30)";
                filter: alpha(opacity=30);                
                -khtml-opacity: 0.3;
                  -moz-opacity:0.3;
                       opacity: 0.3;
            }

            .language-link-current img {
                -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
                filter: alpha(opacity=100);
                -moz-opacity:1.0;
                -khtml-opacity: 1.0;
                opacity: 1.0;
            }

            .install-languages a img:hover {
                -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
                filter: alpha(opacity=100);
                -moz-opacity:1.0;
                -khtml-opacity: 1.0;
                opacity: 1.0;
            }

            .continue {
                width: 100%;
            }

       </style>
       <script src="<?php echo $site_url; ?>/public/assets/js/jquery.min.js"></script>
       <script src="<?php echo $site_url; ?>/public/assets/js/bootstrap.min.js"></script>
    </head>
    <body class="install-body">


    <?php
        if (version_compare(PHP_VERSION, "5.2.3", "<")) {
            $errors['php'] = 'error';
        } else {
            $errors['php'] = '';
        }

        if (in_array('SimpleXML', $php_modules)) {
             $errors['simplexml'] = '';
        } else {
             $errors['simplexml'] = 'error';
        }

        if (function_exists('apache_get_modules')) {
            if ( ! in_array('mod_rewrite', apache_get_modules())) {
                $errors['mod_rewrite'] = 'error';
            } else {
                 $errors['mod_rewrite'] = '';
            }
        } else {
             $errors['mod_rewrite'] = '';
        }

        if (is_writable(__FILE__)) {
            $errors['install'] = '';
        } else {
            $errors['install'] = 'error';
        }

        if (is_writable('sitemap.xml')) {
            $errors['sitemap'] = '';
        } else {
            $errors['sitemap'] = 'error';
        }

        if (is_writable('.htaccess')) {
            $errors['htaccess'] = '';
        } else {
            $errors['htaccess'] = 'error';
        }

        // Dirs 'public', 'storage', 'backups', 'tmp'
        foreach ($dir_array as $dir) {
            if (is_writable($dir.'/')) {
                $errors[$dir] = '';
            } else {
                $errors[$dir] = 'error';
            }
        }
    ?>

        <div class="text-center"><a class="brand" href="<?php echo Html::toText($site_url); ?>"><img src="<?php echo $site_url; ?>/public/assets/img/promo-logo-256px.png" alt="Promo"></a></div>

        <div class="install-languages">
            <?php
                if (Request::get('action') && Request::get('action') == 'install') {
                    $action = '&action=install';
                } else {
                    $action = '';
                }
            ?>
            <?php foreach ($languages_array as $lang_code) { ?>
            <a data-placement="top" data-toggle="tooltip" class="language-link<?php if (Option::get('language') == $lang_code) echo ' language-link-current';?>" title="<?php echo I18n::$locales[$lang_code]; ?>" href="<?php echo $site_url.'/?language=' . $lang_code.$action; ?>"><img src="<?php echo $site_url; ?>/public/assets/img/flags/<?php echo $lang_code?>.png" alt="<?php echo $lang_code?>"></a>
            <?php } ?>
        </div>        
            
        <div class="install-block <?php if(Request::get('action') && Request::get('action') == 'install') { ?><?php } else { ?> hide <?php } ?>">

            <ul class="list-unstyled">
            <?php
                // Promo Notifications
                if (Notification::get('errors') && count(Notification::get('errors') > 0)) {
                    foreach (Notification::get('errors') as $error) {
            ?>
                 <li class="error alert alert-danger"><?php echo $error; ?></li>
            <?php
                    }
                    
                }        
            ?>
            </ul>

        <div class="well">
            <form action="install.php?action=install" method="post">
                <input type="hidden" name="php" value="<?php echo $errors['php']; ?>">
                <input type="hidden" name="simplexml" value="<?php echo $errors['simplexml']; ?>">
                <input type="hidden" name="mod_rewrite" value="<?php echo $errors['mod_rewrite']; ?>">
                <input type="hidden" name="install" value="<?php echo $errors['install']; ?>">
                <input type="hidden" name="sitemap" value="<?php echo $errors['sitemap']; ?>">
                <input type="hidden" name="htaccess" value="<?php echo $errors['htaccess']; ?>">
                <input type="hidden" name="public" value="<?php echo $errors['public']; ?>">
                <input type="hidden" name="storage" value="<?php echo $errors['storage']; ?>">
                <input type="hidden" name="backups" value="<?php echo $errors['backups']; ?>">
                <input type="hidden" name="tmp" value="<?php echo $errors['tmp']; ?>">

                <div class="form-group">
                    <label><?php echo __('Site Name', 'system'); ?></label>
                    <input class="form-control" name="sitename" type="text" value="<?php if (Request::post('sitename')) echo Html::toText(Request::post('sitename')); ?>" />
                </div>

                <div class="form-group">
                    <label><?php echo __('Site Url', 'system'); ?></label>
                    <input class="form-control" name="siteurl" type="text" value="<?php echo Html::toText($site_url); ?>" />
                </div>

                <div class="form-group">
                    <label><?php echo __('Username', 'users'); ?></label>
                    <input class="form-control login" name="login" value="<?php if(Request::post('login')) echo Html::toText(Request::post('login')); ?>" type="text" />
                </div>

                <div class="form-group">
                    <label><?php echo __('Password', 'users'); ?></label>
                    <input class="form-control" name="password" type="password" />
                </div>
                
                <div class="form-group">
                    <label><?php echo __('Time zone', 'system'); ?></label>
                    <select class="form-control" name="timezone">
                        <?php 
                        foreach (Date::timezones() as $zone => $GMT) {
                            $select = (Option::get('timezone') == $zone) ? ' selected' : '';
                            echo '<option value="'.$zone.'"'.$select.'>'.$GMT.'</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label><?php echo __('Email', 'users'); ?></label>
                    <input name="email" class="form-control" value="<?php if (Request::post('email')) echo Html::toText(Request::post('email')); ?>" type="text" />
                </div>                                
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="install_submit" value="<?php echo __('Install', 'system'); ?>" />
                </div>                                
            </form>

            </div>
        </div>

        <div class="promo-dialog <?php if(Request::get('action') && Request::get('action') == 'install') { ?>hide<?php } ?>">
            <ul class="list-unstyled">
            <?php

                if (version_compare(PHP_VERSION, "5.2.0", "<")) {
                    echo '<li class="error alert alert-danger">'.__('PHP 5.2 or greater is required', 'system').'</li>';
                } else {
                    echo '<li class="ok alert alert-success">'.__('PHP Version', 'system').' '.PHP_VERSION.'</li>';
                }

                if (in_array('SimpleXML', $php_modules)) {
                    echo '<li class="ok alert alert-success">'.__('Module SimpleXML is installed', 'system').'</li>';
                } else {
                    echo '<li class="error alert alert-danger">'.__('SimpleXML module is required', 'system').'</li>';
                }

                if (in_array('dom', $php_modules)) {
                    echo '<li class="ok alert alert-success">'.__('Module DOM is installed', 'system').'</li>';
                } else {
                    echo '<li class="error alert alert-danger">'.__('Module DOM is required', 'system').'</li>';
                }

                if (function_exists('apache_get_modules')) {
                    if ( ! in_array('mod_rewrite',apache_get_modules())) {
                        echo '<li class="error alert alert-danger">'.__('Apache Mod Rewrite is required', 'system').'</li>';
                    } else {
                        echo '<li class="ok alert alert-success">'.__('Module Mod Rewrite is installed', 'system').'</li>';
                    }
                } else {
                    echo '<li class="ok alert alert-success">'.__('Module Mod Rewrite is installed', 'system').'</li>';
                }

                foreach ($dir_array as $dir) {
                    if (is_writable($dir.'/')) {
                        echo '<li class="ok alert alert-success">'.__('Directory: <b> :dir </b> writable', 'system', array(':dir' => $dir)).'</li>';
                    } else {
                        echo '<li class="error alert alert-danger">'.__('Directory: <b> :dir </b> not writable', 'system', array(':dir' => $dir)).'</li>';
                    }
                }

                if (is_writable(__FILE__)) {
                    echo '<li class="ok alert alert-success">'.__('Install script writable', 'system').'</li>';
                } else {
                    echo '<li class="error alert alert-danger">'.__('Install script not writable', 'system').'</li>';
                }

                if (is_writable('sitemap.xml')) {
                    echo '<li class="ok alert alert-success">'.__('Sitemap file writable', 'system').'</li>';
                } else {
                    echo '<li class="error alert alert-danger">'.__('Sitemap file not writable', 'system').'</li>';
                }

                if (is_writable('.htaccess')) {
                    echo '<li class="ok alert alert-success">'.__('Main .htaccess file writable', 'system').'</li>';
                } else {
                    echo '<li class="error alert alert-danger">'.__('Main .htaccess file not writable', 'system').'</li>';
                }

                if (isset($errors['sitename']))    echo '<li class="error">'.$errors['sitename'].'</li>';
                if (isset($errors['siteurl']))     echo '<li class="error">'.$errors['siteurl'].'</li>';
                if (isset($errors['login']))       echo '<li class="error">'.$errors['login'].'</li>';
                if (isset($errors['password']))    echo '<li class="error">'.$errors['password'].'</li>';
                if (isset($errors['email']))       echo '<li class="error">'.$errors['email'].'</li>';
                if (isset($errors['email_valid'])) echo '<li class="error">'.$errors['email_valid'].'</li>';
            ?>
            </ul>
            <a href="install.php?action=install" class="btn btn-primary continue"><?php echo __('Continue', 'system'); ?></a>
        </div>
    
        <div class="install-block-footer login-footer">
            <div class="text-center">
                <span>© 2014 - 2015 <a href="http://cms.promo360.ru" class="small-grey-text" target="_blank">Promo CMS</a> – <?php echo __('Version', 'system'); ?> <?php echo Promo::VERSION; ?></span>
            </div>
        </div>

       <script type="text/javascript">
            $('.language-link').tooltip();
        
            $(document).ready(function() {
                $('.continue').click(function() {
                    $('.promo-dialog').addClass('hide');
                    $('.install-block').removeClass('hide');
                });
            });
       </script>
    </body>
</html>
