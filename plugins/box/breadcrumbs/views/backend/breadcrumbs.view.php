<?php
echo "<li><a href=\"{$args['home_link']}\">{$args['home_name']}</a></li>";

foreach ($path as $key => $arr) {
    echo ($count-1 == $key) ? "<li class=\"active\">{$arr['name']}</li>" : "<li><a href=\"{$arr['link']}\">{$arr['name']}</a></li>";
}