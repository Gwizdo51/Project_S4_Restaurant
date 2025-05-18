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
 * Helper function to get a connection to the database
 * @return mysqli
 */
function get_db_connection(): mysqli {
    return new mysqli('mysql_container', 'restaurant_app_user', 'password', 'esaip_s4_restaurant');
}

/**
 * Sets up $_SESSION
 * @return void
 */
function session_setup(): void {
    if (count($_SESSION) === 0) {
        // add the 'order_forms' array
        $_SESSION['order_forms'] = [];
    }
}

/**
 * @param string $input
 * @return string
 */
function sanitize_input($input): string {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

const PRICE_FORMATTER = new NumberFormatter('fr_FR', NumberFormatter::CURRENCY);
/**
 * Returns the string representing the specified number
 * formatted as a price in euros
 * @param float $price_number
 * @return string
 */
function format_price($price_number): string {
    return PRICE_FORMATTER->formatCurrency($price_number, "EUR");
}
