# Project_S4_Restaurant

Common repository for the ESAIP 4th semester project

# POC idea

- A single page, `/commandes-cuisine`, that displays orders to prepare for the kitchen
    - The list of orders updates automatically
    - The user can indicate that an order is ready by clicking on a button next to it
- 2 API :
    - `/api/set/order-ready`, to tell the system that an order is ready
    - `/api/get/kitchen-orders`, to get all orders to prepare in the kitchen

file tree :
- `index.php` -> front controller, routes a URL to a specific controller
- `.htaccess` -> to get beautiful urls
- `lib/`
    - `database_manager.class.php` -> class that handles all DB requests
- `controllers/`
    - `kitchen_orders.controller.php` -> controller for the view (mostly empty)
- `views/`
    - `kitchen_orders.view.php` -> contains the html + AJAX to request new orders, and confirm that an order is ready
- `api/`
    - `kitchen_orders.api.php` -> answers the AJAX request with a JSON containing all orders for the kitchen
    - `order_ready.api.php` -> for declaring an order ready

# Resources

- JS fetch API : https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch
