<?php
echo "<a href=\"{$args['home_link']}\">{$args['home_name']}</a>";

foreach ($path as $key => $arr) {
    echo " &nbsp;<span>{$args['divider']}</span>&nbsp; " . (($count-1 == $key) ? $arr['name'] : "<a href=\"{$arr['link']}\">{$arr['name']}</a>");
}