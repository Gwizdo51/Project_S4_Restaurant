<div class="container-fluid min-vh-100 d-flex flex-column">

<!-- title bar -->
<div class="row bg-body-tertiary position-sticky top-0 align-items-center">
    <div class="col-9 display-5 pt-2 pb-3 text-center text-body">Serveur: Johnathan</div>
    <div class="col-3 p-0 text-end">
        <a href="/mobile" type="button" class="btn btn-primary p-1 m-2">
            <img src="/assets/img/log-out.svg" alt="logout icon" class="img-fluid" style="max-height: 50px;">
        </a>
    </div>
    <hr class="mb-0">
</div>

<!-- page content -->
<main class="row flex-grow-1 d-flex flex-column justify-content-center text-center py-2">

    <!-- tables tab content -->
    <div id="pageTables" class="col-12">

        <!-- display a message when there are no tables in the sector -->

        <!-- columns descriptions -->
        <div class="row justify-content-center">
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
        <div class="row justify-content-center">
            <div class="col-11 d-flex flex-column">
                <div class="row bg-body-secondary border border-2 border-success rounded my-2">
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
                        <button type="button" class="btn btn-secondary m-2 invisible" data-bs-toggle="modal" data-bs-target="#confirmation-modal-cancel" onclick="console.log('reservation icon clicked');">
                            <img src="/assets/img/reserved.svg" alt="reservation icon" style="height: 50px;">
                        </button>
                    </div>
                </div>
                <div class="row bg-body-secondary border border-2 border-primary rounded my-2">
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
                        <button type="button" class="btn btn-secondary m-2" data-bs-toggle="modal" data-bs-target="#confirmation-modal-cancel" onclick="console.log('reservation icon clicked');">
                            <img src="/assets/img/reserved.svg" alt="reservation icon" style="height: 50px;">
                        </button>
                    </div>
                </div>
                <div class="row bg-body-secondary border border-2 border-danger rounded my-2">
                    <div class="col-9 d-flex flex-column" role="button" onclick="console.log('table clicked');">
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
                        <button type="button" class="btn btn-secondary m-2" data-bs-toggle="modal" data-bs-target="#confirmation-modal-cancel" onclick="console.log('reservation icon clicked');">
                            <img src="/assets/img/reserved.svg" alt="reservation icon" style="height: 50px;">
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- orders ready tab content -->
    <div id="pageOrders" class="col-12 d-none">

        <!-- display a message when there are no orders that are ready for the tables in the sector -->

        <!-- columns descriptions -->
         <div class="row justify-content-center">
            <div class="col-11 mb-2">
                <div class="row text-secondary align-items-center">
                    <div class="col-4 offset-8">
                        Lieu de préparation
                    </div>
                </div>
            </div>
        </div>

        <!-- list of ready order -->
        <div class="row justify-content-center">
            <div class="col-11 d-flex flex-column">
                <div class="row bg-body-secondary border border-2 border-secondary rounded my-2" role="button" onclick="console.log('order clicked');">
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
                <div class="row bg-body-secondary border border-2 border-secondary rounded my-2" role="button" onclick="console.log('order clicked');">
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
                <div class="row bg-body-secondary border border-2 border-secondary rounded my-2" role="button" onclick="console.log('order clicked');">
                    <div class="col-4 px-0 py-4 d-flex flex-column justify-content-center">
                        Table 3
                    </div>
                    <div class="col-4 border-start border-end border-2 border-secondary px-0 py-4 d-flex flex-column justify-content-center">
                        Commande 127
                    </div>
                    <div class="col-4 px-0 py-4">
                        Cuisine
                    </div>
                </div>
            </div>
        </div>

    </div>

</main>

<!-- bottom navigation tabs -->
<div id="navTabs" class="row position-sticky bottom-0 text-center fs-4">
    <div class="active-tab col-6 py-3 px-0 rounded-top-5 bg-primary" data-content-id="pageTables">
        Tables
    </div>
    <div class="col-6 py-3 px-0 rounded-top-5 bg-primary-subtle text-primary-emphasis" data-content-id="pageOrders" role="button">
        Commandes
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
    on hovering an inactive tab :
        turn the cursor into a pointer
    on clicking an inactive tab :
        hide the content of the active tab
        display the content of the inactive tab
    on clicking a table :
        ...
    on click an order :
        ...
    */

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
    }

    // schedule update functions when the DOM is loaded
    // https://developer.mozilla.org/en-US/docs/Web/API/Document/readyState
    document.onreadystatechange = () => {
        // on DOM content loaded
        if (document.readyState === "interactive") {
            // updateOrders();
            // storedData.idTimerUpdateOrders = setInterval(updateOrders, 5000);
            // storedData.idTimerUpdateOrdersStates = setInterval(updateOrdersStates, 1000);
            document.querySelectorAll("#navTabs > div").forEach((tabElement) => {
                tabElement.addEventListener("click", (event) => {onNavTabClick(tabElement);});
            });
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
