<?php

// import the required models
require_once './models/receipt.class.php';

echo json_encode(Receipt::get_all_current_receipts());
// echo '{}';
