<?php

// option form page display script
// - header
require './views/header.inc.fixed.view.php';
// - side navbar
echo generate_navbar(6);
// - page title
require './views/page_title.inc.fixed.view.php';
// - page content
require './views/settings_option_form.fixed.view.php';
