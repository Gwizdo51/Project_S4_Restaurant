<!-- loading spinner greyed bg -->
<div id="spinnerFullPage" class="h-100 w-100 z-1 position-fixed bg-body opacity-75 d-flex flex-column justify-content-center align-items-center d-none">
    <div class="spinner-border text-light" role="status" style="height: 5rem; width: 5rem;"></div>
</div>

<div class="container-fluid min-vh-100 d-flex flex-column">

<!-- title bar -->
<div class="row bg-body-tertiary position-sticky top-0 align-items-center">
    <div class="col-9 display-5 pt-2 pb-3 text-center text-body">Serveur: <?= $server_name ?></div>
    <div class="col-3 p-0 text-end">
        <a href="/mobile" type="button" class="btn btn-primary p-1 m-2">
            <img src="/assets/img/log-out.svg" alt="logout icon" class="img-fluid icon">
        </a>
    </div>
    <hr class="mb-0">
</div>

<!-- table template -->
<template id="tableTemplate">
    <div class="row bg-body-secondary border border-2 border-success rounded my-2" data-table-id="1" data-state="success">
        <div class="col-9 d-flex flex-column" role="button" onclick="onTableClick(this);">
            <div class="row flex-grow-1">
                <div class="tableNumber col-6 px-0 d-flex flex-column justify-content-center">
                    Table 1
                </div>
                <div class="tableState col-6 border-start border-end border-2 border-success px-0 d-flex flex-column justify-content-center text-success-emphasis">
                    Disponible
                </div>
            </div>
        </div>
        <div class="col-3 px-0">
            <!-- <button type="button" class="btn btn-secondary m-2 invisible" data-bs-toggle="modal" data-bs-target="#reservationsDetailsModal" onclick="console.log('reservation icon clicked');"> -->
            <button type="button" class="btn btn-secondary m-2 invisible" onclick="onReservationButtonClick(this);">
                <img src="/assets/img/reserved.svg" alt="reservation icon" class="icon">
            </button>
        </div>
    </div>
</template>

<!-- reservation template -->
<template id="reservationTemplate">
    <div class="row">
        <div class="col-6 text-secondary text-end">
            <div>Nom du client</div>
            <div>Heure</div>
            <div>Nombre de personnes</div>
            <div>Détails</div>
        </div>
        <div class="col-6">
            <div class="rowName">Anderson</div>
            <div class="rowTime">19:20</div>
            <div class="rowPeople">4</div>
            <div class="rowDetails">Un bébé</div>
        </div>
    </div>
    <hr>
</template>

<!-- order template -->
<template id="orderTemplate">
    <div class="row bg-body-secondary border border-2 border-secondary rounded my-2" role="button" data-order-id="48" onclick="onOrderClick(this);">
        <div class="orderId col-4 px-0 py-4 d-flex flex-column justify-content-center text-secondary-emphasis">
            Commande 48
        </div>
        <div class="tableNumber col-4 border-start border-end border-2 border-secondary px-0 py-4 d-flex flex-column justify-content-center">
            Table 1
        </div>
        <div class="place col-4 px-0 py-4 d-flex flex-column justify-content-center">
            Cuisine
        </div>
    </div>
</template>

<!-- page content -->
<main class="row flex-grow-1 d-flex flex-column justify-content-center text-center py-2 overflow-x-hidden">

    <!-- loading spinner -->
    <div id="spinnerFirstLoad" class="row justify-content-center">
        <div class="spinner-border text-light" role="status" style="height: 5rem; width: 5rem;"></div>
    </div>

    <!-- tables tab content -->
    <div id="pageTables" class="col-12">

        <!-- display a message when there are no tables in the sector -->
        <div id="noTablesMessage" class="fs-4 text-center mb-3 text-secondary d-none">
            Pas de tables assignées au secteur.
        </div>

        <!-- columns descriptions -->
        <div id="tablesColumnsDescriptions" class="row justify-content-center d-none">
            <div class="col-11 mb-2">
                <div class="row text-secondary align-items-center">
                    <div class="col-9">
                        <div class="row">
                            <div class="col-6 offset-6">
                                États des tables
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        Réservations pour aujourd'hui
                    </div>
                </div>
            </div>
        </div>

        <!-- list of tables -->
        <div id="tablesList" class="row justify-content-center">
            <div class="col-11 d-flex flex-column"></div>
        </div>

    </div>

    <!-- orders ready tab content -->
    <div id="pageOrders" class="col-12 d-none">

        <!-- display a message when there are no orders that are ready for the tables in the sector -->
        <div id="noOrdersMessage" class="fs-4 text-center mb-3 text-secondary d-none">
            Pas de commandes prêtes.
        </div>

        <!-- columns descriptions -->
        <div id="ordersColumnsDescriptions" class="row justify-content-center d-none">
            <div class="col-11 mb-2">
                <div class="row text-secondary align-items-center">
                    <div class="col-4 offset-8">
                        Lieu de préparation
                    </div>
                </div>
            </div>
        </div>

        <!-- list of ready order -->
        <div id="ordersList" class="row justify-content-center">
            <div class="col-11 d-flex flex-column"></div>
        </div>

    </div>

</main>

<!-- bottom navigation tabs -->
<!-- display was buggy on android
https://stackoverflow.com/questions/72830064/sticky-html-element-gets-hidden-below-the-mobile-navigation-bar-in-chrome-fire -->
<!-- add a second hidden one to account for the space -->
<div class="row text-center fs-4 invisible">
    <div class="col-6 py-3 px-0 rounded-top-5 bg-primary active-tab" data-content-id="pageTables" data-tab-index="0">
        Tables
    </div>
    <div class="col-6 py-3 px-0 rounded-top-5 bg-primary-subtle text-primary-emphasis" data-content-id="pageOrders" data-tab-index="1" role="button">
        Commandes
    </div>
    <span class="position-absolute end-0 top-0 translate-middle badge rounded-circle bg-danger border border-light d-none me-3 w-auto" style="padding: .75rem;">
        <span class="visually-hidden">!</span>
    </span>
</div>
<div id="navTabs" class="row position-fixed bottom-0 w-100 text-center fs-4">
    <div class="col-6 py-3 px-0 rounded-top-5 bg-primary active-tab" data-content-id="pageTables" data-tab-index="0">
        Tables
    </div>
    <div class="col-6 py-3 px-0 rounded-top-5 bg-primary-subtle text-primary-emphasis" data-content-id="pageOrders" data-tab-index="1" role="button">
        Commandes
    </div>
    <span id="newOrdersBadge" class="position-absolute end-0 top-0 translate-middle badge rounded-circle bg-danger border border-light d-none me-3 w-auto" style="padding: .75rem;">
        <span class="visually-hidden">!</span>
    </span>
</div>

<!-- confirmation modal -->
<div id="confirmationModal" class="modal fade" tabindex="-1" aria-labelledby="confirmationModal" aria-hidden="true">
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
                            <button type="button" class="btn btn-success py-5 fs-4" onclick="onConfirmButtonClick();" data-bs-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- reservations details modal -->
<div id="reservationsDetailsModal" class="modal fade" tabindex="-1" aria-labelledby="reservationsDetailsModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Réservations pour aujourd'hui<br>table X</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body hide-last-hr"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary px-5 py-3" data-bs-dismiss="modal">OK</button>
            </div>
    </div>
</div>

</div>

<!-- 🔹 Bootstrap JS -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>

<script>
    "use strict";

    /* pseudocode :
    on page load :
        request the JSON of all tables in the sector assigned to the server
        and the list of all orders that are ready for the tables in the sector (API)
        store the JSON in storedData
        if the list of tables is not empty :
            hide the "loading" message
            display the tables in the list
        else :
            change the "loading" message to "no tables"
        if the list of orders is not empty :
            hide the "loading" message
            display the orders in the list
        else :
            change the "loading" message to "no orders"
    every 5 seconds :
        update the table states and the orders with the API
    on clicking an inactive tab :
        hide the content of the active tab
        display the content of the inactive tab
    on clicking a table :
        ...
    on clicking an order :
        ...
    on clicking a reservation icon :
        fill the modal with the reservation data from the stored JSON
        display the modal
    */

    const storedData = {
        serverId: <?= $server_id ?>,
        // 0 -> tables
        // 1 -> orders
        activeTabIndex: 0,
        // last clicked table or order element that triggered the confirmation modal
        clickedElement: null,
        apiJsonResponse: null,
        // relevant page elements
        noTablesMessage: null,
        noOrdersMessage: null,
        tablesColumnsDescriptions: null,
        ordersColumnsDescriptions: null,
        tablesList: null,
        ordersList: null,
        spinnerFirstLoad: null,
        spinnerFullPage: null,
        reservationsDetailsModalContent: null,
        confirmationModalBody: null,
        newOrdersBadge: null,
        // update from API timer id
        idTimerupdateData: null
    };

    const tableStates = {
        1: {
            dataset: "success",
            text: "Disponible"
        },
        2: {
            dataset: "primary",
            text: "Occupée"
        },
        3: {
            dataset: "danger",
            text: "À nettoyer"
        }
    }

    const places = {
        1: "Cuisine",
        2: "Bar"
    }

    function onNavTabClick(tabElement) {
        // if the tab is active, return
        if (tabElement.classList.contains("active-tab")) {
            return;
        }
        // get the active tab
        const activeTabElement = document.querySelector('#navTabs > div.active-tab');
        // disable the active tab
        activeTabElement.classList.remove("active-tab", "bg-primary");
        activeTabElement.classList.add("bg-primary-subtle", "text-primary-emphasis");
        activeTabElement.setAttribute("role", "button");
        // hide its content
        document.querySelector(`#${activeTabElement.dataset.contentId}`).classList.add("d-none");
        // enable the inactive tab
        tabElement.classList.add("active-tab", "bg-primary");
        tabElement.classList.remove("bg-primary-subtle", "text-primary-emphasis");
        tabElement.removeAttribute("role");
        // show is content
        document.querySelector(`#${tabElement.dataset.contentId}`).classList.remove("d-none");
        // remember which tab is being shown
        storedData.activeTabIndex = Number(tabElement.dataset.tabIndex);
    }

    function generateTableElements() {
        for (let tableId in storedData.apiJsonResponse) {
            const currentTableJson = storedData.apiJsonResponse[tableId];
            // clone the content from the table template
            const tableElement = document.querySelector("#tableTemplate").content.cloneNode(true);
            const mainDiv = tableElement.firstElementChild;
            // add the table ID
            mainDiv.dataset.tableId = tableId;
            // add the table number
            mainDiv.querySelector("div.tableNumber").textContent = `Table ${currentTableJson.numero}`;
            // add the table element to the document
            storedData.tablesList.firstElementChild.append(tableElement);
        }
    }

    function generateOrderElement(orderId, tableNumber, preparationPlaceId) {
        // clone the content from the order template
        const orderElement = document.querySelector("#orderTemplate").content.cloneNode(true);
        const mainDiv = orderElement.firstElementChild;
        // console.log(mainDiv);
        mainDiv.dataset.orderId = orderId;
        orderElement.querySelector(".tableNumber").textContent = `Table ${tableNumber}`;
        orderElement.querySelector(".orderId").textContent = `Commande ${orderId}`;
        orderElement.querySelector(".place").textContent = places[preparationPlaceId];
        return orderElement;
    }

    function updateTableState(tableElement, newState) {
        const oldState = tableElement.dataset.state;
        if (newState.dataset !== oldState) {
            // update the state of the table element
            tableElement.dataset.state = newState.dataset;
            // - the outer borders
            tableElement.classList.remove(`border-${oldState}`);
            tableElement.classList.add(`border-${newState.dataset}`);
            // - the inner borders and the text color
            const stateElement = tableElement.querySelector("div.tableState");
            stateElement.classList.remove(`border-${oldState}`, `text-${oldState}-emphasis`);
            stateElement.classList.add(`border-${newState.dataset}`, `text-${newState.dataset}-emphasis`);
            // - the text content
            stateElement.textContent = newState.text;
        }
    }

    function updateTables() {
        // for each table displayed ...
        document.querySelectorAll("#tablesList > div > div").forEach((tableElement) => {
            const currentTableJson = storedData.apiJsonResponse[tableElement.dataset.tableId];
            // const oldState = tableElement.dataset.state;
            // const newState = tableStates[currentTableJson.etat].dataset;
            const newState = tableStates[currentTableJson.etat];
            // update the state if it is different from the one in the json
            // if (newState !== oldState) {
            //     // update the state of the table element
            //     tableElement.dataset.state = newState;
            //     // - the outer borders
            //     tableElement.classList.remove(`border-${oldState}`);
            //     tableElement.classList.add(`border-${newState}`);
            //     // - the inner borders and the text color
            //     const stateElement = tableElement.querySelector("div.tableState");
            //     stateElement.classList.remove(`border-${oldState}`, `text-${oldState}-emphasis`);
            //     stateElement.classList.add(`border-${newState}`, `text-${newState}-emphasis`);
            //     // - the text content
            //     stateElement.textContent = tableStates[currentTableJson.etat].text;
            // }
            updateTableState(tableElement, newState);
            // display or hide the reservation button
            if (Object.keys(currentTableJson).includes("reservations")) {
                tableElement.querySelector("button").classList.remove("invisible");
            }
            else {
                tableElement.querySelector("button").classList.add("invisible");
            }
        });
    }

    function updateDisplayedContent() {
        // console.log(storedData.apiJsonResponse);
        // add the list of tables on the first call
        if (!storedData.spinnerFirstLoad.classList.contains("d-none")) {
            // hide the first load spinner spinnerFirstLoad
            storedData.spinnerFirstLoad.classList.add("d-none");
            // if the list of tables in the json is empty ...
            if (storedData.apiJsonResponse.length === 0) {
                // display the "no tables" message
                storedData.noTablesMessage.classList.remove("d-none");
                // display the "no orders" message
                storedData.noOrdersMessage.classList.remove("d-none");
            }
            else {
                // display the tables columns descriptions
                storedData.tablesColumnsDescriptions.classList.remove("d-none");
                // display every table
                generateTableElements();
            }
        }
        // make a list of all the orders in the json response
        const ordersToDisplay = {};
        for (let tableId in storedData.apiJsonResponse) {
            if (Object.keys(storedData.apiJsonResponse[tableId]).includes('commandes')) {
                for (let orderId in storedData.apiJsonResponse[tableId].commandes) {
                    ordersToDisplay[orderId] = {
                        tableNumber: storedData.apiJsonResponse[tableId].numero,
                        preparationPlaceId: storedData.apiJsonResponse[tableId].commandes[orderId].id_lieu_preparation
                    };
                }
            }
        }
        // console.log(ordersToDisplay);
        // get the list of all displayed orders
        const displayedOrdersList = storedData.ordersList.querySelectorAll("div.row");
        // if the list of orders to display is empty ...
        if (Object.keys(ordersToDisplay).length === 0) {
            // remove all displayed orders
            displayedOrdersList.forEach((displayedOrder) => {
                displayedOrder.remove();
            });
            // hide the columns descriptions
            storedData.ordersColumnsDescriptions.classList.add("d-none");
            // display the "no orders" message
            storedData.noOrdersMessage.classList.remove("d-none");
            // hide the "new orders" badge
            storedData.newOrdersBadge.classList.add("d-none");
        }
        else {
            // display the columns descriptions
            storedData.ordersColumnsDescriptions.classList.remove("d-none");
            // hide the "no orders" message
            storedData.noOrdersMessage.classList.add("d-none");
            // display the "new orders" badge
            storedData.newOrdersBadge.classList.remove("d-none");
            // update the displayed list of orders
            const displayedOrdersIDList = [];
            // for each order displayed ...
            displayedOrdersList.forEach((displayedOrder) => {
                // if the order is not in the json response ...
                if (!Object.keys(ordersToDisplay).includes(displayedOrder.dataset.orderId)) {
                    // remove it from the document
                    displayedOrder.remove();
                }
                // otherwise, add it to the list of displayed orders
                else {
                    displayedOrdersIDList.push(displayedOrder.dataset.orderId);
                }
            });
            // for each order in the json response ...
            for (let jsonResponseOrderId in ordersToDisplay) {
                // if the order is not displayed, display it
                if (!displayedOrdersIDList.includes(jsonResponseOrderId)) {
                    storedData.ordersList.firstElementChild.append(generateOrderElement(
                        jsonResponseOrderId,
                        ordersToDisplay[jsonResponseOrderId].tableNumber,
                        ordersToDisplay[jsonResponseOrderId].preparationPlaceId
                    ));
                }
            }
        }
        // update the states and the reservations of the tables
        updateTables();
    }

    async function updateData() {
        const response = await fetch(`/api/get-server-hub-data/${storedData.serverId}`);
        if (response.ok) {
            storedData.apiJsonResponse = await response.json();
            updateDisplayedContent()
        }
    }

    function onReservationButtonClick(button) {
        const tableId = button.parentElement.parentElement.dataset.tableId;
        // console.log(tableId);
        // clear the content of the reservation modal
        storedData.reservationsDetailsModalContent.innerHTML = "";
        // fill the reservation modal with the reservations data
        const reservationsDataArray = storedData.apiJsonResponse[tableId].reservations;
        reservationsDataArray.forEach((reservationDataArray) => {
            // clone the content from the reservation template
            const reservationElement = document.querySelector("#reservationTemplate").content.cloneNode(true);
            const mainDiv = reservationElement.firstElementChild;
            const dataColumn = mainDiv.querySelector("div.row > div:last-child");
            // get the time of the reservation
            const reservationDate = new Date(reservationDataArray.date);
            const hoursString = `${reservationDate.getHours()}`.padStart(2, "0");
            const minutesString = `${reservationDate.getMinutes()}`.padStart(2, "0");
            // fill the reservation element with the data
            dataColumn.querySelector(".rowName").textContent = reservationDataArray.nomClient;
            dataColumn.querySelector(".rowTime").textContent = `${hoursString}:${minutesString}`;
            dataColumn.querySelector(".rowPeople").textContent = reservationDataArray.nombrePersonnes;
            dataColumn.querySelector(".rowDetails").innerHTML = reservationDataArray.notes.replace("\r\n", "<br>");
            // add the element to the modal
            storedData.reservationsDetailsModalContent.append(reservationElement);
        });
        // show the modal
        (new bootstrap.Modal("#reservationsDetailsModal")).show();
    }

    function onTableClick(tableElement) {
        // console.log(tableElement);
        // remember which table was clicked
        storedData.clickedElement = tableElement.parentElement;
        // if the table is in the "occupied" state ...
        if (storedData.clickedElement.dataset.state === "primary") {
            // console.log("creating a new order ...");
            window.location.href = `/mobile/${storedData.serverId}/nouvelle-commande/${storedData.clickedElement.dataset.tableId}`;
        }
        else {
            // replace the text of the confirmation modal
            const tableNumber = storedData.apiJsonResponse[storedData.clickedElement.dataset.tableId].numero;
            if (storedData.clickedElement.dataset.state === "success") {
                storedData.confirmationModalBody.querySelector("p").textContent = `Créer un bon pour la table ${tableNumber} ?`;
            }
            else {
                storedData.confirmationModalBody.querySelector("p").textContent = `La table ${tableNumber} est-elle prête ?`;
            }
            // show the confirmation modal
            (new bootstrap.Modal("#confirmationModal")).show();
        }
    }

    function onOrderClick(orderElement) {
        // remember which order was clicked
        storedData.clickedElement = orderElement;
        // replace the text of the confirmation modal
        storedData.confirmationModalBody.querySelector("p").textContent = "Effacer la notification ?";
        // show the confirmation modal
        (new bootstrap.Modal("#confirmationModal")).show();
    }

    async function onConfirmButtonClick() {
        // console.log("modal confirmed");
        // display the full page spinner
        storedData.spinnerFullPage.classList.remove("d-none");
        // make a FormData object to send via POST
        const formData = new FormData();
        // if the active tab is "Tables" ...
        if (storedData.activeTabIndex === 0) {
            formData.append("tableId", storedData.clickedElement.dataset.tableId);
            // if the table clicked is in the "available" state ...
            if (storedData.clickedElement.dataset.state === "success") {
                // create a new receipt for this table and set the table to "occupied"
                formData.append("serverId", storedData.serverId);
                const response = await fetch("/api/create-receipt", {
                    method: "POST",
                    body: formData
                });
                if (!response.ok) {
                    console.error("The server encountered an error while creating an order");
                }
                else {
                    // update the table state
                    updateTableState(storedData.clickedElement, tableStates[2]);
                }
            }
            else {
                // setting the table to "ready"
                formData.append("stateId", 1);
                const response = await fetch("/api/set-table-state", {
                    method: "POST",
                    body: formData
                });
                if (!response.ok) {
                    console.error("The server encountered an error while creating an order");
                }
                else {
                    // update the table state
                    updateTableState(storedData.clickedElement, tableStates[1]);
                }
            }
        }
        // otherwise, if the active tab is "Orders" ...
        else {
            // make a FormData object to send via POST
            const formData = new FormData();
            formData.append("order-id", storedData.clickedElement.dataset.orderId);
            const response = await fetch("/api/set-order-delivered", {
                method: "POST",
                body: formData
            });
            if (response.ok) {
                const JSONResponse = await response.json();
                if (JSONResponse.success) {
                    // remove the order from the list
                    storedData.clickedElement.remove();
                    // if there are no orders displayed ...
                    if (storedData.ordersList.querySelectorAll("div.row").length === 0) {
                        // hide the columns descriptions
                        storedData.ordersColumnsDescriptions.classList.add("d-none");
                        // display the "no orders" message
                        storedData.noOrdersMessage.classList.remove("d-none");
                        // hide the "new orders" badge
                        storedData.newOrdersBadge.classList.add("d-none");
                    }
                }
            }
        }
        // hide the full page spinner
        storedData.spinnerFullPage.classList.add("d-none");
    }

    // schedule update functions when the DOM is loaded
    // https://developer.mozilla.org/en-US/docs/Web/API/Document/readyState
    document.onreadystatechange = () => {
        // on DOM content loaded
        if (document.readyState === "interactive") {
            // add the handles to the relevant HTML elements
            storedData.noTablesMessage = document.querySelector("#noTablesMessage");
            storedData.noOrdersMessage = document.querySelector("#noOrdersMessage");
            storedData.tablesColumnsDescriptions = document.querySelector("#tablesColumnsDescriptions");
            storedData.ordersColumnsDescriptions = document.querySelector("#ordersColumnsDescriptions");
            storedData.tablesList = document.querySelector("#tablesList");
            storedData.ordersList = document.querySelector("#ordersList");
            storedData.spinnerFirstLoad = document.querySelector("#spinnerFirstLoad");
            storedData.spinnerFullPage = document.querySelector("#spinnerFullPage");
            storedData.reservationsDetailsModalContent = document.querySelector("#reservationsDetailsModal div.hide-last-hr");
            storedData.confirmationModalBody = document.querySelector("#confirmationModal div.modal-body");
            storedData.newOrdersBadge = document.querySelector("#newOrdersBadge");
            // add the tabs click listeners
            document.querySelectorAll("#navTabs > div").forEach((tabElement) => {
                tabElement.addEventListener("click", (event) => {onNavTabClick(tabElement);});
            });
            // get and update the list of displayed tables and ready orders
            updateData();
            storedData.idTimerupdateData = setInterval(updateData, 5000);
        }
    };

    // disable page updates when it is not visible
    // https://developer.mozilla.org/en-US/docs/Web/API/Page_Visibility_API
    document.addEventListener("visibilitychange", () => {
        // if the window becomes hidden ...
        if (document.hidden) {
            // stop requesting updates
            clearInterval(storedData.idTimerupdateData);
        }
        // otherwise ...
        else {
            // restart requesting updates
            updateData();
            storedData.idTimerupdateData = setInterval(updateData, 5000);
        }
    });
</script>

</body>
</html>
