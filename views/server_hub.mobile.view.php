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
        <div class="col-9 d-flex flex-column" role="button" onclick="console.log('table clicked');">
            <div class="row flex-grow-1">
                <div class="col-6 px-0 d-flex flex-column justify-content-center">
                    Table 1
                </div>
                <div class="col-6 border-start border-end border-2 border-success px-0 d-flex flex-column justify-content-center text-success-emphasis">
                    Disponible
                </div>
            </div>
        </div>
        <div class="col-3 px-0">
            <button type="button" class="btn btn-secondary m-2 invisible" data-bs-toggle="modal" data-bs-target="#reservations-details-modal" onclick="console.log('reservation icon clicked');">
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
            <div>Anderson</div>
            <div>19:20</div>
            <div>4</div>
            <div>Un bébé</div>
        </div>
    </div>
    <hr>
</template>

<!-- order template -->
<template id="orderTemplate">
    <div class="row bg-body-secondary border border-2 border-secondary rounded my-2" role="button" data-bs-toggle="modal" data-bs-target="#confirmation-modal" data-order-id="48" onclick="console.log('order clicked');">
        <div class="col-4 px-0 py-4 d-flex flex-column justify-content-center">
            Table 1
        </div>
        <div class="col-4 border-start border-end border-2 border-secondary px-0 py-4 d-flex flex-column justify-content-center">
            Commande 48
        </div>
        <div class="col-4 px-0 py-4">
            Cuisine
        </div>
    </div>
</template>

<!-- page content -->
<main class="row flex-grow-1 d-flex flex-column justify-content-center text-center py-2">

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
                                États des tables du secteur
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
            <div class="col-11 d-flex flex-column">
                <!-- <div class="row bg-body-secondary border border-2 border-success rounded my-2" dataset-table-id="1">
                    <div class="col-9 d-flex flex-column" role="button" onclick="console.log('table clicked');">
                        <div class="row flex-grow-1">
                            <div class="col-6 px-0 d-flex flex-column justify-content-center">
                                Table 1
                            </div>
                            <div class="col-6 border-start border-end border-2 border-success px-0 d-flex flex-column justify-content-center text-success-emphasis">
                                Disponible
                            </div>
                        </div>
                    </div>
                    <div class="col-3 px-0">
                        <button type="button" class="btn btn-secondary m-2 invisible" data-bs-toggle="modal" data-bs-target="#reservations-details-modal" onclick="console.log('reservation icon clicked');">
                            <img src="/assets/img/reserved.svg" alt="reservation icon" class="icon">
                        </button>
                    </div>
                </div>
                <div class="row bg-body-secondary border border-2 border-primary rounded my-2" dataset-table-id="2">
                    <div class="col-9 d-flex flex-column" role="button" onclick="console.log('table clicked');">
                        <div class="row flex-grow-1">
                            <div class="col-6 px-0 d-flex flex-column justify-content-center">
                                Table 2
                            </div>
                            <div class="col-6 border-start border-end border-2 border-primary px-0 d-flex flex-column justify-content-center text-primary-emphasis">
                                Occupée
                            </div>
                        </div>
                    </div>
                    <div class="col-3 px-0">
                        <button type="button" class="btn btn-secondary m-2" data-bs-toggle="modal" data-bs-target="#reservations-details-modal" onclick="console.log('reservation icon clicked');">
                            <img src="/assets/img/reserved.svg" alt="reservation icon" class="icon">
                        </button>
                    </div>
                </div>
                <div class="row bg-body-secondary border border-2 border-danger rounded my-2" dataset-table-id="3">
                    <div class="col-9 d-flex flex-column" onclick="console.log('table clicked');">
                        <div class="row flex-grow-1">
                            <div class="col-6 px-0 d-flex flex-column justify-content-center">
                                Table 3
                            </div>
                            <div class="col-6 border-start border-end border-2 border-danger px-0 d-flex flex-column justify-content-center text-danger-emphasis">
                                À nettoyer
                            </div>
                        </div>
                    </div>
                    <div class="col-3 px-0">
                        <button type="button" class="btn btn-secondary m-2" data-bs-toggle="modal" data-bs-target="#reservations-details-modal" onclick="console.log('reservation icon clicked');">
                            <img src="/assets/img/reserved.svg" alt="reservation icon" class="icon">
                        </button>
                    </div>
                </div> -->
            </div>
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
            <div class="col-11 d-flex flex-column">
                <!-- <div class="row bg-body-secondary border border-2 border-secondary rounded my-2" role="button" data-bs-toggle="modal" data-bs-target="#confirmation-modal" dataset-order-id="48" onclick="console.log('order clicked');">
                    <div class="col-4 px-0 py-4 d-flex flex-column justify-content-center">
                        Table 1
                    </div>
                    <div class="col-4 border-start border-end border-2 border-secondary px-0 py-4 d-flex flex-column justify-content-center">
                        Commande 48
                    </div>
                    <div class="col-4 px-0 py-4">
                        Cuisine
                    </div>
                </div>
                <div class="row bg-body-secondary border border-2 border-secondary rounded my-2" role="button" data-bs-toggle="modal" data-bs-target="#confirmation-modal" dataset-order-id="72" onclick="console.log('order clicked');">
                    <div class="col-4 px-0 py-4 d-flex flex-column justify-content-center">
                        Table 2
                    </div>
                    <div class="col-4 border-start border-end border-2 border-secondary px-0 py-4 d-flex flex-column justify-content-center">
                        Commande 72
                    </div>
                    <div class="col-4 px-0 py-4">
                        Bar
                    </div>
                </div>
                <div class="row bg-body-secondary border border-2 border-secondary rounded my-2" role="button" data-bs-toggle="modal" data-bs-target="#confirmation-modal" dataset-order-id="127" onclick="console.log('order clicked');">
                    <div class="col-4 px-0 py-4 d-flex flex-column justify-content-center">
                        Table 3
                    </div>
                    <div class="col-4 border-start border-end border-2 border-secondary px-0 py-4 d-flex flex-column justify-content-center">
                        Commande 127
                    </div>
                    <div class="col-4 px-0 py-4">
                        Cuisine
                    </div>
                </div> -->
            </div>
        </div>

    </div>

</main>

<!-- bottom navigation tabs -->
<div id="navTabs" class="row position-sticky bottom-0 text-center fs-4">
    <div class="col-6 py-3 px-0 rounded-top-5 bg-primary active-tab" data-content-id="pageTables" data-tab-index="0">
        Tables
    </div>
    <div class="col-6 py-3 px-0 rounded-top-5 bg-primary-subtle text-primary-emphasis" data-content-id="pageOrders" data-tab-index="1" role="button">
        Commandes
    </div>
</div>

<!-- confirmation modal -->
<div id="confirmation-modal" class="modal fade" tabindex="-1" aria-labelledby="confirmation-modal" aria-hidden="true">
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
<div id="reservations-details-modal" class="modal fade" tabindex="-1" aria-labelledby="reservations-details-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Réservations pour aujourd'hui<br>table X</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body hide-last-hr">
                <!-- <div class="row">
                    <div class="col-6 text-secondary text-end">
                        <div>Nom du client</div>
                        <div>Heure</div>
                        <div>Nombre de personnes</div>
                        <div>Détails</div>
                    </div>
                    <div class="col-6">
                        <div>Anderson</div>
                        <div>19:20</div>
                        <div>4</div>
                        <div>Un bébé</div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6 text-secondary text-end">
                        <div>Nom du client</div>
                        <div>Heure</div>
                        <div>Nombre de personnes</div>
                        <div>Détails</div>
                    </div>
                    <div class="col-6">
                        <div>Anderson</div>
                        <div>19:20</div>
                        <div>4</div>
                        <div>Un bébé</div>
                    </div>
                </div>
                <hr> -->
            </div>
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
        request the list of all tables in the sector assigned to the server
        and the list of all orders that are ready for the tables in the sector (API)
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
        ...
    on clicking an inactive tab :
        hide the content of the active tab
        display the content of the inactive tab
    on clicking a table :
        ...
    on clicking an order :
        ...
    on clicking a reservation icon :
        ...
    */

    const storedData = {
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
        spinnerFullPage: null
    };

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
        // ...
    }

    function generateOrderElement(orderId, tableId, preparationPlaceId) {
        console.log(orderId, tableId, preparationPlaceId);
        // ...
    }

    function updateTablesStates() {
        console.log(storedData.tablesList);
    }

    function updateDisplayedContent() {
        console.log(storedData.apiJsonResponse);
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
            // console.log(storedData.apiJsonResponse[tableId]);
            if (Object.keys(storedData.apiJsonResponse[tableId]).includes('commandes')) {
                for (let orderId in storedData.apiJsonResponse[tableId].commandes) {
                    ordersToDisplay[orderId] = {
                        tableId,
                        preparationPlaceId: storedData.apiJsonResponse[tableId].commandes[orderId].id_lieu_preparation
                    };
                }
            }
        }
        console.log(ordersToDisplay);
        // get the list of all displayed orders
        const displayedOrdersList = storedData.ordersList.querySelectorAll("div.row");
        // if the list of orders to display is empty ...
        if (ordersToDisplay.length === 0) {
            // remove all displayed orders
            displayedOrdersList.forEach((displayedOrder) => {
                displayedOrder.remove();
            });
            // hide the columns descriptions
            storedData.ordersColumnsDescriptions.classList.add("d-none");
            // display the "no orders" message
            storedData.noOrdersMessage.classList.remove("d-none");
        }
        else {
            // display the columns descriptions
            storedData.ordersColumnsDescriptions.classList.remove("d-none");
            // hide the "no orders" message
            storedData.noOrdersMessage.classList.add("d-none");
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
                    generateOrderElement(
                        jsonResponseOrderId,
                        ordersToDisplay[jsonResponseOrderId].tableId,
                        ordersToDisplay[jsonResponseOrderId].preparationPlaceId
                    );
                }
            }
        }
        // update the states of the tables
        updateTablesStates();
    }

    async function updateData() {
        const response = await fetch("/api/get-server-hub-data/<?= $server_id ?>");
        if (response.ok) {
            storedData.apiJsonResponse = await response.json();
            updateDisplayedContent()
        }
    }

    // schedule update functions when the DOM is loaded
    // https://developer.mozilla.org/en-US/docs/Web/API/Document/readyState
    document.onreadystatechange = () => {
        // on DOM content loaded
        if (document.readyState === "interactive") {
            // updateOrders();
            // storedData.idTimerUpdateOrders = setInterval(updateOrders, 5000);
            // storedData.idTimerUpdateOrdersStates = setInterval(updateOrdersStates, 1000);
            // add the handles to the relevant HTML elements
            storedData.noTablesMessage = document.querySelector("#noTablesMessage");
            storedData.noOrdersMessage = document.querySelector("#noOrdersMessage");
            storedData.tablesColumnsDescriptions = document.querySelector("#tablesColumnsDescriptions");
            storedData.ordersColumnsDescriptions = document.querySelector("#ordersColumnsDescriptions");
            storedData.tablesList = document.querySelector("#tablesList");
            storedData.ordersList = document.querySelector("#ordersList");
            storedData.spinnerFirstLoad = document.querySelector("#spinnerFirstLoad");
            storedData.spinnerFullPage = document.querySelector("#spinnerFullPage");
            // add the tabs click listeners
            document.querySelectorAll("#navTabs > div").forEach((tabElement) => {
                tabElement.addEventListener("click", (event) => {onNavTabClick(tabElement);});
            });
            // get and update the list of displayed tables and ready orders
            updateData();
        }
    };

    // disable page updates when it is not visible
    // https://developer.mozilla.org/en-US/docs/Web/API/Page_Visibility_API
    document.addEventListener("visibilitychange", () => {
        // if the window becomes hidden ...
        if (document.hidden) {
            // // stop requesting new orders
            // clearInterval(storedData.idTimerUpdateOrders);
            // // stop updating the orders States
            // clearInterval(storedData.idTimerUpdateOrdersStates);
        }
        // otherwise ...
        else {
            // // restart requesting new orders
            // updateOrders();
            // storedData.idTimerUpdateOrders = setInterval(updateOrders, 5000);
            // // restart updating the orders states
            // updateOrdersStates();
            // storedData.idTimerUpdateOrdersStates = setInterval(updateOrdersStates, 1000);
        }
    });
</script>

</body>
</html>
