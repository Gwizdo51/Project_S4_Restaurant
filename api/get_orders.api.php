<?php

require_once './models/database_manager.class.php';

/* pseudocode :
if no "place" in GET parameters:
    return error JSON
else:
    return the JSON containing the list of all the orders to prepare in the requested place
*/
if (!array_key_exists('place', $_GET)) {
    // wrong use of this URL
    $result_json = '"ERROR: no \"place\" in GET request"';
}
else {
    // $selected_brand = $_GET['brand'];
    // $result_json = DBManager::get_model_json($selected_brand);
    DBManager::disconnect();
}

echo $result_json;
