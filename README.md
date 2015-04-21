# Promo CMS
Promo CMS является форком Monstra CMS 3.0.1 

## Отличия Promo CMS от Monstra CMS
1. Система ориентирована на русскоязычную аудиторию
2. Из коробки идет плагин Breadcrumbs (хлебные крошки)
3. Изменена тема админ-панели

## Системные требования
Хостинг: операционная система Unix, Linux, Windows

Веб-сервер: Apache с [Mod Rewrite](http://httpd.apache.org/docs/current/mod/mod_rewrite.html) или Ngnix с [Rewrite Module](http://wiki.nginx.org/HttpRewriteModule)

PHP 5.3.0 или выше с [SimpleXML модулем](http://php.net/simplexml) и [Multibyte String модулем](http://php.net/mbstring)   


## Установка
1. [Скачайте последнюю версию.](http://cms.promo360.ru/download);
2. Распакуйте содержимое в новую папку на вашем компьютере;
3. Загрузите эту папку через FTP на ваш хост;
4. Вам также может понадобиться установить CHMOD 755 (или 777) на папки /storage/, /tmp/, /backups/ и /public/;
5. Также вам может понадобиться установить CHMOD 755 (или 777) на файлы /install.php, /.htaccess и /sitemap.xml;
6. Введите http://example.org/install.php в браузере.

Copyright (C) 2014-2015 Yudin Evgeniy / JINN [info@promo360.ru] (Promo CMS)