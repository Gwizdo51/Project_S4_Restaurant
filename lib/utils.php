<?php

/**
 * @param mixed $mixed
 * @return void
 */
function var_dump_pre($mixed): void {
    echo "<pre>\n";
    var_dump($mixed);
    echo "</pre>\n";
}

/**
 * @param string $view_path
 * @param string $page_title
 * @return void
 */
function display_view($view_path, $page_title): void {
    echo "<!doctype html>\n"
        ."<html lang=\"fr\">\n\n"
        ."<head>\n"
        ."    <title>".$page_title."</title>\n"
        ."    <meta charset=\"utf-8\">\n"
        ."    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n"
        ."</head>\n\n"
        ."<body>\n";
    require $view_path;
    echo "</body>\n\n"
        ."</html>\n";
}

/**
 * @return mysqli
 */
function get_db_connection(): mysqli {
    return new mysqli('mysql_container', 'root', '123456789', 'esaip_s4_restaurant');
}
