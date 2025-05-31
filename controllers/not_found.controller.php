<?php

http_response_code(404);
$tab_title = 'Page introuvable - '.WEBSITE_TITLE;
require './views/not_found.view.php';
