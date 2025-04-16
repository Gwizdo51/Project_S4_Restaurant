<!-- order template -->
<template id="template-order">
    <div class="row border border-success border-2 rounded m-0 mb-3 bg-body" data-order-id="" data-date-creation="" data-state="success">
        <div class="col-4 p-3">
            <table class="table">
                <tbody>
                    <tr class="order-number">
                        <td class="text-end w-75">Numéro commande :</td>
                        <th>41</th>
                    </tr>
                    <tr class="table-number">
                        <td class="text-end">Numéro table :</td>
                        <th>8</th>
                    </tr>
                    <tr class="time-passed">
                        <td class="text-end">Commande passée il y a :</td>
                        <th class="text-success-emphasis">16 min</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="ordered-items-list col-6 border-start border-end border-success border-2 p-3">
            <dl class="list-group list-group-flush"></dl>
        </div>
        <div class="col-2 p-3 d-grid">
            <button type="button" class="btn btn-primary" onclick="onReadyButtonClick(this)">Prête</button>
        </div>
    </div>
</template>

<!-- item template -->
<template id="template-item">
    <div class="list-group-item">
        <dt>Entrecôte</dt>
        <dd>Cuisson : Saignant</dd>
    </div>
</template>

<!-- page content -->
<div id="page-content" class="bg-body-tertiary px-3 pt-3 mb-3 rounded d-flex flex-column">

<!-- display a message when there are no orders to display -->
<div id="no-orders-message" class="fs-4 text-center mb-3 text-secondary">
    Aucune commande à préparer.
</div>

</div>
<!-- end of page content -->

</div>

</div>

</main>

<!-- 🔹 Bootstrap JS -->
<script src="./assets/js/bootstrap.bundle.min.js"></script>

<script>
    "use strict";

    /* pseudocode :
    on page load :
        request the list of all orders to prepare in the kitchen (API)
        if the list is not empty :
            remove the "no orders" message
            display the list
    every 5 seconds :
        request the list of all orders to prepare in the kitchen (API)
        if the list is empty :
            remove all displayed order
            display the "no orders" message
        else :
            remove the "no orders" message
            update the displayed list of orders
    every second :
        update the number of minutes that have passed since the order was created
        if the time is above 10min :
            color the border in orange
        if the time is above 20min :
            color the border in red
    on "order ready" button click :
        disable the button (to indicate the command is being processed)
        set the related order to "ready" (API)
        on success, remove the order from the displayed list
        if the list of displayed order is empty :
            display the "no orders" message
    */

    // get the number of minutes that passed since a given datetime
    function getTimePassedMinutes(date) {
        return Math.floor((Date.now() - Date.parse(date)) / 60000);
    }

    // the time passed thresholds in minutes
    const timeThresholdsMinutes = [10, 20];

    // update the color of the text and the borders of an order based on the time passed
    function updateOrderColor(orderMainDiv, timePassedMinutes) {
        // get the state the order should be in (success, warning or danger)
        let newState;
        if (timePassedMinutes < timeThresholdsMinutes[0]) {
            newState = "success";
        }
        else if (timePassedMinutes < timeThresholdsMinutes[1]) {
            newState = "warning";
        }
        else {
            newState = "danger";
        }
        // console.log(newState);
        // if the new state is different from the current state ...
        const currentState = orderMainDiv.dataset.state;
        if (newState !== currentState) {
            // update the colors of the border and the text of the element:
            // - the borders of the main div
            orderMainDiv.classList.remove(`border-${currentState}`);
            orderMainDiv.classList.add(`border-${newState}`);
            // - the text color of the time passed
            const timePassedElement = orderMainDiv.querySelector("tr.time-passed th");
            timePassedElement.classList.remove(`text-${currentState}-emphasis`);
            timePassedElement.classList.add(`text-${newState}-emphasis`);
            // - the borders of the ordered items list
            const orderedItemsElement = orderMainDiv.querySelector(".ordered-items-list");
            orderedItemsElement.classList.remove(`border-${currentState}`);
            orderedItemsElement.classList.add(`border-${newState}`);
            // set the state of the order to the new state
            orderMainDiv.dataset.state = newState;
        }
    }

    // generate the HTML element of an order from the JSON response
    function generateOrderElement(orderID, JSONResponse) {
        // get the order with the specified ID from the JSON
        const currentOrder = JSONResponse[orderID];
        // clone the content of the order template
        const orderElement = document.querySelector("#template-order").content.cloneNode(true);
        const templateItem = document.querySelector("#template-item");
        const mainDiv = orderElement.querySelector("div.row");
        // add the order ID
        mainDiv.dataset.orderId = orderID;
        mainDiv.querySelector("tr.order-number th").textContent = orderID;
        // add the table number
        mainDiv.querySelector("tr.table-number th").textContent = currentOrder["numero_table"];
        // add the creation date
        mainDiv.dataset.dateCreation = currentOrder["date_creation"];
        // add the time passed since the order was created
        const timePassedMinutes = getTimePassedMinutes(currentOrder["date_creation"]);
        mainDiv.querySelector("tr.time-passed th").textContent = `${timePassedMinutes} min`;
        // update the border and text color according to the time passed
        updateOrderColor(mainDiv, timePassedMinutes);
        // add the ordered items
        const orderedItemsContainer = mainDiv.querySelector("dl");
        currentOrder.items.forEach((item) => {
            // clone the content from the item template
            let itemElement = document.querySelector("#template-item").content.cloneNode(true);
            // add the product label
            itemElement.querySelector("dt").textContent = item.label;
            // add the order details if there are any
            let detailsElement = itemElement.querySelector("dd");
            if (item.details.length !== 0) {
                detailsElement.textContent = item.details;
            }
            else {
                detailsElement.remove();
            }
            // add the item element to the order element
            orderedItemsContainer.append(itemElement);
        });
        return orderElement;
    }

    // update the list of displayed orders based on the JSON response
    function updateDisplayedOrders(JSONResponse) {
        const ordersContainer = document.querySelector("#page-content");
        const noOrdersMessageDiv = ordersContainer.querySelector("#no-orders-message");
        // get the list of all orders displayed on the page
        const displayedOrdersList = ordersContainer.querySelectorAll("div.row");
        // if the list of orders to prepare is empty ...
        if (Object.keys(JSONResponse).length === 0) {
            // remove all displayed orders
            displayedOrdersList.forEach((value) => {
                value.remove();
            })
            // display the "no orders" message
            noOrdersMessageDiv.classList.remove("d-none");
        }
        else {
            // remove the "no orders" message
            noOrdersMessageDiv.classList.add("d-none");
            const displayedOrdersIDList = [];
            // for each order displayed ...
            displayedOrdersList.forEach((displayedOrder) => {
                // let displayedOrderID = displayedOrder.getAttribute("order-id");
                let displayedOrderID = displayedOrder.dataset.orderId;
                // if the order is not in the JSON response ...
                if (!Object.keys(JSONResponse).includes(displayedOrderID)) {
                    // remove it from the document
                    displayedOrder.remove();
                }
                // else, add it to the list of displayed orders IDs
                else {
                    displayedOrdersIDList.push(displayedOrderID);
                }
            });
            // for each order in the JSON response ...
            for (let orderID in JSONResponse) {
                // if the order is not displayed, add it to the end of the list
                if (!displayedOrdersIDList.includes(orderID)) {
                    ordersContainer.append(generateOrderElement(orderID, JSONResponse));
                }
            }
        }
    }

    // request the list of new orders and update the displayed list
    function updateOrders() {
        const xhttp = new XMLHttpRequest();
        xhttp.open("GET", "/api/get/kitchen-orders");
        xhttp.send();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                updateDisplayedOrders(JSON.parse(this.responseText));
            }
        };
    }
    updateOrders();
    setInterval(updateOrders, 5000);

    // update the amount of minutes passed and the state of each displayed orders
    function updateOrdersStates() {
        // for each order displayed on the page ...
        document.querySelectorAll("#page-content > div.row").forEach((orderElement) => {
            // get the time that passed since the order was created
            const timePassedMinutes = getTimePassedMinutes(orderElement.dataset.dateCreation);
            orderElement.querySelector("tr.time-passed th").textContent = `${timePassedMinutes} min`;
            // update the border and text color according to the time passed
            updateOrderColor(orderElement, timePassedMinutes);
        });
    }
    setInterval(updateOrdersStates, 1000);

    // set an order to "ready" state on button click
    function onReadyButtonClick(button) {
        const orderID = button.parentElement.parentElement.dataset.orderId;
        // if the user confirms that the order is ready ...
        if (confirm(`La commande ${orderID} est prête ?`)) {
            // disable the button
            button.setAttribute("disabled", "");
            // make a FormData object to send via POST
            const formData = new FormData();
            formData.append("order-id", orderID);
            // send the order ID to be deleted to the API
            const xhttp = new XMLHttpRequest();
            xhttp.open("POST", "/api/set/order-ready");
            xhttp.send(formData);
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    const JSONResponse = JSON.parse(this.responseText);
                    if (JSONResponse.success) {
                        // remove the order from the list
                        button.parentElement.parentElement.remove();
                        // if there are no orders displayed ...
                        if (document.querySelectorAll("#page-content > div.row").length === 0) {
                            // display the "no orders" message
                            document.querySelector("#no-orders-message").classList.remove("d-none");
                        }
                    }
                    else {
                        alert("Une erreur est survenue lors de l'envoi de la requête");
                        button.removeAttribute("disabled");
                    }
                }
            }
        }
    }
</script>

</body>
</html>
