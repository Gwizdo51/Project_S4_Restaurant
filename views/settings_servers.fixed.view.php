<!-- page content -->
<main id="pageContent" class="bg-body-tertiary rounded mt-3 pt-2 px-0 d-flex flex-column flex-grow-1">

<!-- display a message when there are no servers to display -->
<div id="noServersMessage" class="row fs-4 justify-content-center m-3 text-secondary d-none">
    Aucun serveurs actifs.
</div>

<!-- display a spinner while the page is loading -->
<div id="spinnerFirstLoad" class="row justify-content-center mt-auto">
    <div class="spinner-border text-light" role="status" style="height: 5rem; width: 5rem;"></div>
</div>

<!-- columns descriptions -->
<div id="columnsDescriptions" class="row m-0 justify-content-center text-secondary d-none">
    <div class="col-10 border border-2" style="border-color: #0000 !important;">
        <div class="row align-items-center text-center px-2">
            <div class="col-5">Nom du serveur</div>
            <div class="col-5">Secteur assigné</div>
            <div class="col-2">Supprimer le serveur</div>
        </div>
    </div>
</div>

<!-- list of servers -->
<div id="serversContainer" class="row m-0 d-flex flex-column"></div>

<!-- controls -->
<div id="controls" class="row mx-3 pb-3 pt-2 mt-auto sticky-bottom justify-content-center pe-none">
    <div class="col-9 p-0 bg-body-tertiary border border-secondary rounded pe-auto">
        <div class="row m-2">
            <div class="col-4 p-2 d-grid">
                <a href="/fixe/configuration" type="button" class="btn btn-danger btn-control-big fs-4 d-flex justify-content-center align-items-center">Annuler</a>
            </div>
            <div class="col-4 p-2 d-grid">
                <button class="btn btn-primary btn-control-big p-0 fs-4" onclick="onAddServerButtonClick();" disabled>
                    <img src="/assets/img/plus.svg" alt="plus icon" class="mh-3rem">
                </button>
            </div>
            <div class="col-4 p-2 d-grid">
                <!-- <button class="btn btn-success btn-control-big fs-4 text-wrap" data-bs-toggle="modal" data-bs-target="#confirmationModal" disabled>Valider</button> -->
                <button class="btn btn-success btn-control-big fs-4 text-wrap" onclick="onValidateButtonClick();" disabled>Valider</button>
            </div>
        </div>
    </div>
</div>

</main>
<!-- end of page content -->

<!-- modal to confirm the changes -->
<div id="confirmationModal" class="modal fade" tabindex="-1" aria-labelledby="confirmationModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmation</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0 fs-5">Valider les changements ?</p>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 d-grid">
                            <button type="button" class="btn btn-danger py-5 fs-4" data-bs-dismiss="modal">Annuler</button>
                        </div>
                        <div class="col-6 d-grid">
                            <!-- <button type="button" class="btn btn-success py-5 fs-4" onclick="onConfirmButtonClick();" data-bs-dismiss="modal">OK</button> -->
                            <button type="button" class="btn btn-success py-5 fs-4" data-bs-dismiss="modal" onclick="onModalConfirm();">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- server template -->
<template id="serverTemplate">
    <div class="row justify-content-center mx-0 my-2 p-0" data-server-id="0" data-state="secondary">
        <div class="col-10 border border-2 border-secondary rounded bg-body">
            <div class="row p-2 align-items-center">
                <div class="col-5 p-2">
                    <input type="text" class="serverNameInput form-control form-control-lg" placeholder="Nom du serveur" value="" required>
                </div>
                <div class="col-5 p-2">
                    <select class="form-select form-select-lg">
                        <option value="0" selected>(Aucun)</option>
                    </select>
                </div>
                <div class="col-2 p-2 d-flex justify-content-center">
                    <input class="deleteCheckbox form-check-input fs-2 m-0" type="checkbox">
                </div>
            </div>
        </div>
    </div>
</template>

</div>

</div>

</div>

<!-- 🔹 Bootstrap JS -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>

<script>
    "use strict";

    /* pseudocode :
    on page load :
        request the list of the current servers from the API
        on response :
            remove the spinner
            enable both buttons
        display it
        save the list in a variable
    on check delete server :
        if the server is new :
            delete it from the displayed list
        else :
            color the border in red
    on uncheck delete server :
        color the border back what is was
    on modifying a value :
        // color the border
        if the "delete" checkbox is not checked :
            if the server is not new :
                if either value (name or sector) is different from the original one :
                    color the border in blue
                else :
                    color the border in grey
            else :
                color the border in green
        else :
            color the border in red
        // color the name input in red if it is empty
        if the input changed is the name input :
            if the input is empty :
                color the border in red (is-invalid)
            else :
                color the border in the base color
        // enable/disable the "validate" button
        enable the "validate" button
        for each name input :
            if the input is invalid :
                disable the "validate" button
                break
    on modal confirm :
        show the full page spinner
        make a JSON containing the servers data
        send the JSON to /api/update-servers
        on response, redirect to /fixe/configuration
    */

    // returns a string in which the HTML characters are decoded
    // https://stackoverflow.com/a/7394787/16509326
    function decodeHtml(html) {
        var txt = document.createElement("textarea");
        txt.innerHTML = html;
        return txt.value;
    }

    let apiJsonResponse = null;

    // update the border color and validates the name field (must not be empty)
    function updateServerVisualState(serverElement) {
        const checkboxElement = serverElement.querySelector("input.deleteCheckbox");
        const serverId = Number(serverElement.dataset.serverId);
        const nameInputElement = serverElement.querySelector("input.serverNameInput");
        let newState;
        // if the delete checkbox is checked ...
        if (checkboxElement.checked) {
            // color the border in red
            newState = "danger";
        }
        // else if the server is new ...
        else if (serverId === 0) {
            // color the border in green
            newState = "success";
        }
        else {
            // if either value (name or sector) is different from the original one ...
            const nameIsDifferent = nameInputElement.value !== apiJsonResponse.serveurs[serverId].nom;
            const selectedSectorId = Number(serverElement.querySelector("select").selectedOptions[0].value);
            const sectorIsDifferent = selectedSectorId !== apiJsonResponse.serveurs[serverId].id_secteur;
            if (nameIsDifferent || sectorIsDifferent) {
                // color the border in blue
                newState = "primary";
            }
            else {
                // color the border in grey
                newState = "secondary";
            }
        }
        // update the border
        serverElement.firstElementChild.classList.remove(`border-${serverElement.dataset.state}`);
        serverElement.dataset.state = newState;
        serverElement.firstElementChild.classList.add(`border-${serverElement.dataset.state}`);
        // validate the name input -> must not be empty
        if (nameInputElement.value.length === 0) {
            nameInputElement.classList.add("is-invalid");
        }
        else {
            nameInputElement.classList.remove("is-invalid");
        }
    }

    function onToggleCheckbox(checkboxElement) {
        const serverElement = checkboxElement.parentElement.parentElement.parentElement.parentElement;
        const serverId = Number(serverElement.dataset.serverId);
        // if the server is new ...
        if (serverId === 0) {
            // delete the server
            serverElement.remove();
            // if the list of displayed servers is empty ...
            if (document.querySelectorAll("#serversContainer > div").length === 0) {
                // hide the columns descriptions
                document.querySelector("#columnsDescriptions").classList.add("d-none");
                // show the "no servers" message
                document.querySelector("#noServersMessage").classList.remove("d-none");
            }
        }
        updateVisualStateAndValidateForm(serverElement);
    }

    // updates the visual state of the server element when the name changes
    // disables the "validate" button if an input on the page is not valid
    function updateVisualStateAndValidateForm(serverElement) {
        updateServerVisualState(serverElement);
        let formIsValid = true;
        for (const inputNameElement of document.querySelectorAll("input.serverNameInput")) {
            const relatedDeleteCheckbox = inputNameElement.parentElement.parentElement.querySelector("input.deleteCheckbox");
            // console.log(relatedDeleteCheckbox);
            if (inputNameElement.value.length === 0 && !relatedDeleteCheckbox.checked) {
                formIsValid = false;
                break;
            }
        }
        const validateButton = document.querySelector("#controls button.btn-success");
        if (formIsValid) {
            validateButton.removeAttribute("disabled");
        }
        else {
            validateButton.setAttribute("disabled", "");
        }
    }

    async function pageSetup() {
        const response = await fetch(`/api/get-server-settings`);
        if (response.ok) {
            apiJsonResponse = await response.json();
            // apiJsonResponse.serveurs = {};
            // console.log(apiJsonResponse);
            // hide the first load spinner
            document.querySelector("#spinnerFirstLoad").classList.add("d-none");
            // enable the disabled control buttons
            document.querySelectorAll("#controls button").forEach((buttonElement) => {
                buttonElement.removeAttribute("disabled");
            });
            // add the sectors to the template select element
            const templateContent = document.querySelector("#serverTemplate").content;
            const sectorSelectElement = templateContent.querySelector("select");
            for (const sectorId in apiJsonResponse.secteurs) {
                const sectorOption = document.createElement("option");
                sectorOption.setAttribute("value", sectorId);
                sectorOption.textContent = apiJsonResponse.secteurs[sectorId];
                sectorSelectElement.append(sectorOption);
            }
            // if the list of active servers is empty ...
            if (Object.keys(apiJsonResponse.serveurs).length === 0) {
                // show the "no servers" message
                document.querySelector("#noServersMessage").classList.remove("d-none");
            }
            else {
                // show the columns descriptions
                document.querySelector("#columnsDescriptions").classList.remove("d-none");
                // display each server
                const serversContainer = document.querySelector("#serversContainer");
                for (const serverId in apiJsonResponse.serveurs) {
                    const serverData = apiJsonResponse.serveurs[serverId];
                    // clone the content from the order template
                    const serverElement = document.querySelector("#serverTemplate").content.cloneNode(true);
                    const mainDiv = serverElement.firstElementChild;
                    // add the server ID
                    mainDiv.dataset.serverId = serverId;
                    // add the server name
                    mainDiv.querySelector("input.serverNameInput").setAttribute("value", decodeHtml(serverData.nom));
                    // set the correct sector option as selected
                    if (serverData.id_secteur !== null) {
                        mainDiv.querySelector('option[value="0"]').removeAttribute("selected");
                        mainDiv.querySelector(`option[value="${serverData.id_secteur}"]`).setAttribute("selected", "");
                    }
                    // add the event listeners
                    addEventListenersToServerElement(mainDiv);
                    // display the server
                    serversContainer.append(serverElement);
                }
            }
        }
    }

    function addEventListenersToServerElement(serverElement) {
        // add an "on change" event listener to the checkbox
        const checkboxElement = serverElement.querySelector("input.deleteCheckbox");
        checkboxElement.addEventListener("change", (event) => {
            onToggleCheckbox(checkboxElement);
        });
        // add an "on change" event listener to the select
        serverElement.querySelector("select").addEventListener("change", (event) => {
            updateServerVisualState(serverElement);
        });
        // add an "on change" event listener to the name input
        serverElement.querySelector("input.serverNameInput").addEventListener("input", (event) => {
            updateVisualStateAndValidateForm(serverElement);
        });
    }

    document.onreadystatechange = () => {
        // on DOM content loaded
        if (document.readyState === "interactive") {
            // fetch and display the active servers in the database
            pageSetup();
        }
    }

    function onAddServerButtonClick() {
        // clone the content from the order template
        const serverElement = document.querySelector("#serverTemplate").content.cloneNode(true);
        const mainDiv = serverElement.firstElementChild;
        // add the event listeners
        addEventListenersToServerElement(mainDiv);
        // add the template as-is to the list of servers
        document.querySelector("#serversContainer").append(serverElement);
        // update its visual state and validate the form
        updateVisualStateAndValidateForm(mainDiv);
    }

    function onValidateButtonClick() {
        console.log("validate button clicked");
        // if nothing would be updated, redirect the user to /fixe/configuration
        let nothingToUpdate = true;
        for (const serverElement of document.querySelectorAll("#serversContainer > div")) {
            if (serverElement.dataset.state !== "secondary") {
                nothingToUpdate = false;
                break;
            }
        };
        if (nothingToUpdate) {
            // redirect the user to /fixe/configuration
            window.location.href = "/fixe/configuration";
        }
        else {
            // show the confirmation modal
            (new bootstrap.Modal("#confirmationModal")).show();
        }
    }

    async function onModalConfirm() {
        // show the full page spinner
        document.querySelector("#spinnerFullPage").classList.remove("d-none");
        // make a JSON containing the servers data
        const serversData = {
            changed: [],
            new: [],
            toDelete: []
        };
        document.querySelectorAll("#serversContainer > div").forEach((serverElement) => {
            const serverId = Number(serverElement.dataset.serverId);
            const serverName = serverElement.querySelector("input.serverNameInput").value;
            const sectorId = Number(serverElement.querySelector("select").selectedOptions[0].value)
            switch (serverElement.dataset.state) {
                case "primary":
                    serversData.changed.push({
                        serverId,
                        serverName,
                        sectorId
                    });
                    break;
                case "success":
                    serversData.new.push({
                        serverName,
                        sectorId
                    });
                    break;
                case "danger":
                    serversData.toDelete.push(serverId);
                    break;
            }
        });
        // send the JSON to /api/update-servers
        const response = await fetch("/api/update-servers", {
            method: "POST",
            headers: {
                "Content-Type": "application/json; charset=utf-8",
            },
            body: JSON.stringify(serversData)
        });
        if (response.ok) {
            const serversUpdateApiJsonResponse = await response.json();
            if (serversUpdateApiJsonResponse.success) {
                window.location.href = "/fixe/configuration";
            }
        }
        // remove the full page spinner
        document.querySelector("#spinnerFullPage").classList.add("d-none");
    }
</script>

</body>
</html>
