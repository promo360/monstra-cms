# Promo CMS
Promo - это современная и легковесная система управления сайтом (CMS). Promo CMS является ответвлением Monstra CMS 3.0.1 

## Отличия Promo CMS 1.0.0 от Monstra CMS 3.0.1
1. Система ориентирована на русскоязычную аудиторию, хотя в ней по прежнему поддерживается мультиязычность
2. Из коробки идут плагины Breadcrumbs (хлебные крошки) и Pagination (постраничная навигация)
3. Изменена тема админ-панели
4. Изменен дефолтный шаблон сайта

## Системные требования
Операционная система: Unix, Linux, Windows, Mac OS   
Связующее ПО: PHP 5.3.0 или выше с [SimpleXML модулем](http://php.net/simplexml) и [Multibyte String модулем](http://php.net/mbstring)   
Веб-сервер: Apache с [Mod Rewrite](http://httpd.apache.org/docs/current/mod/mod_rewrite.html) или Ngnix с [Rewrite Module](http://wiki.nginx.org/HttpRewriteModule)   

## Шаги по установке
1. [Скачайте последнюю версию.](http://cms.promo360.ru/download);
2. Распакуйте содержимое в новую папку на вашем компьютере;
3. Загрузите эту папку через FTP на ваш хост;
4. Вам также может понадобиться установить CHMOD 755 (или 777) на папки /storage/, /tmp/, /backups/ и /public/;
5. Также вам может понадобиться установить CHMOD 755 (или 777) на файлы /install.php, /.htaccess и /sitemap.xml;
6. Введите http://example.org/install.php в браузере.

Copyright (C) 2012-2014 Romanenko Sergey / Awilum [awilum@msn.com] (Monstra CMS)

Copyright (C) 2014-2015 Yudin Evgeniy / JINN [info@promo360.ru] (Promo CMS)