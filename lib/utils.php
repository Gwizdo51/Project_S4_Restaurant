<?php

/**
 * @param string $view_path
 * @param string $page_title
 * @return void
 */
function display_view($view_path, $page_title): void {
    echo "<!DOCTYPE html>\n"
        ."<html lang=\"en\">\n\n"
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
