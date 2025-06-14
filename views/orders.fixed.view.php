<!-- order template -->
<template id="templateOrder">
    <div class="row border border-success border-2 rounded mb-3 mx-3 bg-body" data-order-id="" data-date-creation="" data-state="success">
        <div class="col-4 p-3">
            <table class="table">
                <tbody>
                    <tr class="order-number">
                        <td class="text-end align-middle">Commande n°</td>
                        <th class="fs-5 align-middle">41</th>
                    </tr>
                    <tr class="table-number align-middle">
                        <td class="text-end">Table n°</td>
                        <th class="fs-5 align-middle">8</th>
                    </tr>
                    <tr class="time-passed align-middle">
                        <td class="text-end">Commande passée il y a</td>
                        <th class="fs-5 align-middle text-success-emphasis">16 min</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="ordered-items-list col-6 border-start border-end border-success border-2 p-3">
            <dl class="list-group list-group-flush"></dl>
        </div>
        <div class="col-2 p-3 d-grid">
            <button type="button" class="btn btn-primary fs-4" data-bs-toggle="modal" data-bs-target="#confirmationModal">Prête</button>
        </div>
    </div>
</template>

<!-- item template -->
<template id="templateItem">
    <div class="list-group-item">
        <dt>Entrecôte</dt>
        <dd>Cuisson : Saignant</dd>
    </div>
</template>

<!-- modal to confirm an order is ready -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmation</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0 fs-5">La commande est-elle prête ?</p>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 d-grid">
                            <button type="button" class="btn btn-danger py-5 fs-4" data-bs-dismiss="modal">Annuler</button>
                        </div>
                        <div class="col-6 d-grid">
                            <button id="modalConfirmButton" type="button" class="btn btn-success py-5 fs-4" data-bs-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- page content -->
<main id="pageContent" class="bg-body-tertiary mt-3 pt-3 rounded flex-grow-1">

<!-- display a message when there are no orders to display -->
<div id="noOrdersMessage" class="fs-4 text-center mb-3 text-secondary">
    Chargement des commandes ...
</div>

</main>
<!-- end of page content -->

</div>

</div>

</div>

<!-- 🔹 Bootstrap JS -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>

<script type="module">

    /* pseudocode :
    on page load :
        request the list of all orders to prepare in the specified place (API)
        if the list is not empty :
            hide the "no orders" message
            display the list
    every 5 seconds :
        request the list of all orders to prepare in the specified place (API)
        if the list is empty :
            remove all displayed order
            display the "no orders" message
        else :
            hide the "no orders" message
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

    import {decodeHtml} from '/assets/js/utils.js';

    // global object to store data
    const storedData = {
        // which button was clicked
        orderElementClicked: null,
        // the id of the timers
        idTimerUpdateOrders: null,
        idTimerUpdateOrdersStates: null
    };

    // get the number of minutes that passed since a given datetime
    function getTimePassedMinutes(date) {
        return Math.floor((Date.now() - Date.parse(date)) / 60000);
    }

    // the time passed thresholds in minutes
    const timeThresholdsMinutes = [10, 20];

    // update the color of the text and the borders of an order based on the time passed
    function updateOrderColor(orderMainDiv, timePassedMinutes) {
        // get the state the order should be in ("success", "warning" or "danger")
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
        // clone the content from the order template
        const orderElement = document.querySelector("#templateOrder").content.cloneNode(true);
        const templateItem = document.querySelector("#templateItem");
        const mainDiv = orderElement.firstElementChild;
        // add the order ID
        mainDiv.dataset.orderId = orderID;
        mainDiv.querySelector("tr.order-number th").textContent = orderID;
        // add the table number
        mainDiv.querySelector("tr.table-number th").textContent = currentOrder.numero_table;
        // add the creation date
        mainDiv.dataset.dateCreation = currentOrder.date_creation;
        // add the time passed since the order was created
        const timePassedMinutes = getTimePassedMinutes(currentOrder.date_creation);
        mainDiv.querySelector("tr.time-passed th").textContent = `${timePassedMinutes} min`;
        // update the border and text color according to the time passed
        updateOrderColor(mainDiv, timePassedMinutes);
        // add the ordered items
        const orderedItemsContainer = mainDiv.querySelector("dl");
        currentOrder.items.forEach((item) => {
            // clone the content from the item template
            let itemElement = templateItem.content.cloneNode(true);
            // add the product label
            itemElement.querySelector("dt").textContent = decodeHtml(item.label);
            // add the order details if there are any
            let detailsElement = itemElement.querySelector("dd");
            if (item.details.length !== 0) {
                detailsElement.innerHTML = item.details.replaceAll("\n", "<br>");
            }
            else {
                detailsElement.remove();
            }
            // add the item element to the order element
            orderedItemsContainer.append(itemElement);
        });
        // add an "on click" event listener to the button
        mainDiv.querySelector("button").addEventListener("click", () => {
            storedData.orderElementClicked = mainDiv;
        });
        return orderElement;
    }

    // update the list of displayed orders based on the JSON response
    function updateDisplayedOrders(JSONResponse) {
        const ordersContainer = document.querySelector("#pageContent");
        const noOrdersMessageDiv = ordersContainer.querySelector("#noOrdersMessage");
        // change the "no orders" message
        noOrdersMessageDiv.textContent = "Aucune commande à préparer.";
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
                // if the order is not displayed, display it
                if (!displayedOrdersIDList.includes(orderID)) {
                    ordersContainer.append(generateOrderElement(orderID, JSONResponse));
                }
            }
        }
    }

    async function updateOrders() {
        const response = await fetch("/api/get-orders-to-prepare/<?= $id_place ?>");
        if (response.ok) {
            updateDisplayedOrders(await response.json());
        }
    }

    // update the amount of minutes passed and the state of each displayed orders
    function updateOrdersStates() {
        // for each order displayed on the page ...
        document.querySelectorAll("#pageContent > div.row").forEach((orderElement) => {
            // get the time that passed since the order was created
            const timePassedMinutes = getTimePassedMinutes(orderElement.dataset.dateCreation);
            orderElement.querySelector("tr.time-passed th").textContent = `${timePassedMinutes} min`;
            // update the border and text color according to the time passed
            updateOrderColor(orderElement, timePassedMinutes);
        });
    }

    // set an order to "ready" state on "OK" button click in confirmation modal
    async function onConfirmButtonClick() {
        // disable every "order ready" buttons while waiting for the API response
        document.querySelectorAll("#pageContent > div.row button").forEach((button) => {
            button.setAttribute("disabled", "");
        });
        // make a FormData object to send via POST
        const formData = new FormData();
        formData.append("order-id", storedData.orderElementClicked.dataset.orderId);
        const response = await fetch("/api/set-order-ready", {
            method: "POST",
            body: formData
        });
        if (response.ok) {
            const JSONResponse = await response.json();
            if (JSONResponse.success) {
                // remove the order from the list
                storedData.orderElementClicked.remove();
                // if there are no orders displayed ...
                if (document.querySelectorAll("#pageContent > div.row").length === 0) {
                    // display the "no orders" message
                    document.querySelector("#noOrdersMessage").classList.remove("d-none");
                }
            }
            else {
                alert("Une erreur est survenue lors du traitement de la requête");
            }
        }
        else {
            alert("Une erreur est survenue lors de l'envoi de la requête");
        }
        // enable every "order ready" button
        document.querySelectorAll("#pageContent > div.row button").forEach((button) => {
            button.removeAttribute("disabled");
        });
    }

    // schedule update functions when the DOM is loaded
    // https://developer.mozilla.org/en-US/docs/Web/API/Document/readyState
    document.onreadystatechange = () => {
        // add "on click" event listeners to the modal button
        document.querySelector("#modalConfirmButton").addEventListener("click", onConfirmButtonClick);
        // update displayed orders now and every 5 seconds
        updateOrders();
        storedData.idTimerUpdateOrders = setInterval(updateOrders, 5000);
        // update displayed orders states every second
        storedData.idTimerUpdateOrdersStates = setInterval(updateOrdersStates, 1000);
    };

    // disable page updates when it is not visible
    // https://developer.mozilla.org/en-US/docs/Web/API/Page_Visibility_API
    document.addEventListener("visibilitychange", () => {
        // if the window becomes hidden ...
        if (document.hidden) {
            // stop requesting new orders
            clearInterval(storedData.idTimerUpdateOrders);
            // stop updating the orders States
            clearInterval(storedData.idTimerUpdateOrdersStates);
        }
        // otherwise ...
        else {
            // restart requesting new orders
            updateOrders();
            storedData.idTimerUpdateOrders = setInterval(updateOrders, 5000);
            // restart updating the orders states
            updateOrdersStates();
            storedData.idTimerUpdateOrdersStates = setInterval(updateOrdersStates, 1000);
        }
    });
</script>

</body>
</html>
