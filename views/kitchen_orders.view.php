<h2>Liste des commandes à préparer en cuisine :</h2>

<ul id="list-orders">

    <!-- <li class="order-list-item" order-id="4">
        <p>Numéro commande : <b>4</b></p>
        <p>Numero de table : <b>16</b></p>
        <p>Commande passée il y a : <b class="order-time-passed" data-date-creation="2025-04-01 10:46:09">3</b> minutes</p>
        <p>Items :
            <ul class="list-items">
                <li class="item-list-items">
                    <p><b>1</b> Entrecôte</p>
                    <p>Cuisson : Saignant</p>
                </li>
                <li class="item-list-items">
                    <p><b>2</b> Salade verte</p>
                </li>
            </ul>
        </p>
        <button onclick="onReadyButtonClick(this)">Commande prête</button>
    </li> -->

</ul>

<script>
    "use strict";

    // console.log("hello world!");
    // console.log(new Date(Date.parse("2025-04-01 10:46:09")));

    /* pseudocode :
    on page load :
        request the list of all orders to prepare in the kitchen (API)
        display the list
    every 5 seconds :
        request the list of all orders to prepare in the kitchen (API)
        update the displayed list if it changed
    every second :
        update the number of minutes that have passed since the order was created
    on "order ready" button click :
        disable the button (to indicate the command is being processed)
        set the related order to "ready" (API)
        on response, remove the order from the list
    */

    // get the number of minutes that passed since a given datetime
    function timePassedMinutes(date) {
        return Math.floor((Date.now() - date) / 60000);
    }

    // get the HTML representing an order
    function getOrderHTML(orderID, JSONResponse) {
        // get the order with the specified ID from the JSON
        const currentOrder = JSONResponse[orderID];
        // create the list item
        const orderHTML = document.createElement("li");
        orderHTML.setAttribute("class", "order-list-item");
        orderHTML.setAttribute("order-id", orderID);
        // add the command number
        let paragraph = document.createElement("p");
        paragraph.innerHTML = `Numéro commande : <b>${orderID}</b>`;
        orderHTML.appendChild(paragraph);
        // add the table number
        paragraph = document.createElement("p");
        paragraph.innerHTML = `Numéro de table : <b>${currentOrder.numero_table}</b>`;
        orderHTML.appendChild(paragraph);
        // add the number of minutes since the table was created
        paragraph = document.createElement("p");
        const timePassed = timePassedMinutes(Date.parse(currentOrder.date_creation));
        paragraph.innerHTML = `Commande passée il y a : <b class="order-time-passed" data-date-creation="${currentOrder.date_creation}">${timePassed}</b> minutes`;
        orderHTML.appendChild(paragraph);
        // add the list of items
        const itemsList = document.createElement("ul");
        itemsList.setAttribute("class", "list-items");
        currentOrder.items.forEach((productItem) => {
            // console.log(item);
            let listItem = document.createElement("li");
            listItem.setAttribute("class", "item-list-items");
            // add the product label
            paragraph = document.createElement("p");
            paragraph.textContent = productItem.label;
            listItem.appendChild(paragraph);
            // add the details if there are any
            if (productItem.details.length !== 0) {
                paragraph = document.createElement("p");
                paragraph.textContent = productItem.details;
                listItem.appendChild(paragraph);
            }
            itemsList.appendChild(listItem);
        });
        orderHTML.appendChild(itemsList);
        // add the button
        const button = document.createElement("button");
        button.setAttribute("onclick", "onReadyButtonClick(this)");
        button.textContent = "Commande prête";
        orderHTML.appendChild(button);
        // return the list item
        return orderHTML;
    }

    // update the displayed list of orders based on the JSON received from the API
    function updateDisplayedOrders(JSONResponse) {
        const orderList = document.querySelector("#list-orders");
        // get the list of all order IDs displayed on the page
        const queryResponse = document.querySelectorAll("#list-orders > li");
        const displayedOrdersIDList = [];
        // for each order displayed ...
        queryResponse.forEach((orderDisplayed) => {
            let displayedOrderID = orderDisplayed.getAttribute("order-id");
            // if the order is not in the JSON response ...
            if (!Object.keys(JSONResponse).includes(displayedOrderID)) {
                // remove it from the document
                orderDisplayed.remove();
            }
            // else, add it to the list of displayed orders IDs
            else {
                displayedOrdersIDList.push(orderDisplayed.getAttribute("order-id"));
            }
        });
        // for each order in the JSON response ...
        for (let orderID in JSONResponse) {
            // if the order is not displayed, add it to the end of the list
            if (!displayedOrdersIDList.includes(orderID)) {
                orderList.appendChild(getOrderHTML(orderID, JSONResponse));
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

    // update the amount of minutes for each displayed orders
    function updateMinutesPassed() {
        // get all orders displayed
        const queryResponse = document.querySelectorAll("b.order-time-passed");
        queryResponse.forEach((node) => {
            node.textContent = timePassedMinutes(Date.parse(node.getAttribute("data-date-creation")));
        });
    }
    setInterval(updateMinutesPassed, 1000);

    // set an order to "ready" state on button click
    function onReadyButtonClick(button) {
        const orderID = button.parentElement.getAttribute("order-id");
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
                        button.parentElement.remove();
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
