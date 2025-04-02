<?php

require_once './models/order.class.php';

echo Order::get_all_orders_to_prepare("cuisine");
