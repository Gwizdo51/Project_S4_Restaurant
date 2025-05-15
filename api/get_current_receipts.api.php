<?php

// import the required models
require_once './models/receipt.class.php';

// send back a JSON
header('Content-Type: application/json; charset=utf-8');
echo json_encode(Receipt::get_all_current_receipts_json());
