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
 * @param int $index_active_page
 * @return string
 */
function generate_navbar($index_active_tab): string {
    $navbar_html = "<!-- side navigation bar -->\n"
                  ."<div class=\"col-2 vh-100 sticky-top overflow-y-auto p-3 bg-body-tertiary\">\n"
                  ."    <div class=\"fs-4 px-3\">Navigation</div>\n"
                  ."    <hr>\n"
                  ."    <ul class=\"nav nav-pills flex-column\">\n";
    $sidebar_items = array_keys(SIDEBAR_CONF);
    for ($index = 0; $index < sizeof(SIDEBAR_CONF); $index++) {
        if ($index === $index_active_tab) {
            $navbar_html .= "<li class=\"nav-item\">\n"
                           .'    <a href="'.SIDEBAR_CONF[$sidebar_items[$index]]."\" class=\"nav-link active\" aria-current=\"page\">\n"
                           ."         {$sidebar_items[$index]}\n"
                           ."    </a>\n"
                           ."</li>\n";
        }
        else {
            $navbar_html .= "<li>\n"
                           .'    <a href="'.SIDEBAR_CONF[$sidebar_items[$index]]."\" class=\"nav-link link-body-emphasis\">\n"
                           ."         {$sidebar_items[$index]}\n"
                           ."    </a>\n"
                           ."</li>\n";
        }
    }
    $navbar_html .= "    </ul>\n</div>\n";
    return $navbar_html;
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
        ."    <title>{$page_title}</title>\n"
        ."    <meta charset=\"utf-8\">\n"
        ."    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n"
        ."</head>\n\n"
        ."<body>\n";
    require $view_path;
    echo "</body>\n\n"
        ."</html>\n";
}

/**
 * @param string $content_view_path
 * @param string $tab_title
 * @param string $page_title
 * @param int $index_active_tab_navbar
 * @return void
 */
function display_view_new($content_view_path, $tab_title, $page_title, $index_active_tab_navbar): void {
    // include the header
    require './views/header.inc.view.php';
    // include the side navbar
    echo generate_navbar($index_active_tab_navbar);
    // include the page title
    require './views/page_title.inc.view.php';
    // include the page content
    require $content_view_path;
}

/**
 * @return mysqli
 */
function get_db_connection(): mysqli {
    return new mysqli('mysql_container', 'root', '123456789', 'esaip_s4_restaurant');
}
