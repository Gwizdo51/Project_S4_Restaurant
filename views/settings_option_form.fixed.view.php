<!-- page content -->
<main id="pageContent" class="bg-body-tertiary rounded mt-3 pt-2 px-0 d-flex flex-column flex-grow-1">

    <!-- option label -->
    <div class="row align-items-center m-2">
        <label class="col-3 py-0 px-2 col-form-label col-form-label-lg" for="inputLabel">Titre de l'option</label>
        <div class="col-9 py-0 px-2">
            <input id="inputLabel" type="text" class="form-control form-control-lg" form="form" name="optionLabel" placeholder="Cuisson" value="" required>
        </div>
    </div>

    <!-- choice type -->
    <div class="row align-items-center m-2">
        <label class="col-3 py-0 px-2 col-form-label col-form-label-lg">Type de choix</label>
        <div class="col-9 py-0 px-2">
            <div class="row border rounded m-0 p-2 fs-5 bg-body">
                <div class="col-6 p-2">
                    <div class="form-check">
                        <input class="form-check-input" form="form" id="radioUnique" type="radio" name="choiceType" value="1" required>
                        <label class="form-check-label user-select-none" for="radioUnique">
                            Unique
                        </label>
                    </div>
                </div>
                <div class="col-6 p-2">
                    <div class="form-check">
                        <input class="form-check-input" form="form" id="radioMultiple" type="radio" name="choiceType" value="2" required>
                        <label class="form-check-label user-select-none" for="radioMultiple">
                            Multiple
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- list of choices -->
    <div class="row align-items-center m-2">
        <label class="col-3 py-0 px-2 col-form-label col-form-label-lg">Liste de choix</label>
        <div class="col-9 py-0 px-2">
            <div class="row border rounded m-0 p-2 fs-5 bg-body">
                <div class="col-12 p-0">
                    <div id="choiceList" class="d-flex flex-column"></div>
                    <!-- add choice button -->
                     <div class="row m-2 justify-content-center">
                        <div class="col-3 p-0 d-grid">
                            <button class="btn btn-outline-primary p-0 fs-4" onclick="addChoiceElement();">
                                <img src="/assets/img/plus.svg" alt="plus icon" class="mh-3rem">
                            </button>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>

    <!-- controls -->
    <div class="row mx-3 pb-3 pt-2 mt-auto justify-content-center pe-none">
        <div class="col-6 p-0 bg-body-tertiary border border-secondary rounded pe-auto">
            <div class="row m-2">
                <div class="col-6 p-2 d-grid">
                    <a href="/fixe/configuration/carte/options" type="button" class="btn btn-danger btn-control-big fs-4 d-flex justify-content-center align-items-center">Annuler</a>
                </div>
                <div class="col-6 p-2 d-grid">
                    <button type="button" class="btn btn-success btn-control-big fs-4 d-flex justify-content-center align-items-center" onclick="onValidateButtonClick();">Valider</button>
                </div>
            </div>
        </div>
    </div>

</main>
<!-- end of page content -->

<form id="form"></form>

<!-- server template -->
<template id="optionTemplate">
    <div class="row my-2 mx-0">
        <div class="col-10 px-2 d-grid">
            <input type="text" class="form-control form-control-lg" form="form" value="" required>
        </div>
        <div class="col-2 px-2 d-grid">
            <button type="button" class="btn btn-outline-danger fs-4" onclick="this.parentElement.parentElement.remove()">X</button>
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
        if optionId != 0 (modify option) :
            display the full page spinner
            request the option data from the API : /api/order-option?id={orderId}
            fill the form with the option data
            remove the full page spinner
    on add choice button click :
        copy the content from the choice template
        add it to the list
    on delete choice button click :
        remove the choice from the list
    on validate button click :
        trigger the form validation (form.reportValidity())
        if the form is valid :
            display the full page spinner
            make a JSON containing the form data
            send the JSON to the API : /api/order-option
            on response, redirect to /fixe/configuration
    */

    const storedData = {
        optionId: <?= $option_id ?>,
        inputLabelElement: document.querySelector("#inputLabel"),
        spinnerFullPageElement: document.querySelector("#spinnerFullPage"),
        optionTemplateElement: document.querySelector("#optionTemplate"),
        choiceListElement: document.querySelector("#choiceList"),
        formElement: document.forms[0]
    };

    async function pageSetup() {
        // if the page is called to modify an option ...
        if (storedData.optionId !== 0) {
            // display the full page spinner
            storedData.spinnerFullPageElement.classList.remove('d-none');
            // request the option data from the API
            const response = await fetch(`/api/order-option?id=${storedData.optionId}`);
            if (response.ok) {
                const apiJsonResponse = await response.json();
                // add the option label to the related input
                storedData.inputLabelElement.value = apiJsonResponse.label;
                // select the right choice type
                if (apiJsonResponse.id_type_choix === 1) {
                    document.querySelector("#radioUnique").checked = true;
                }
                else {
                    document.querySelector("#radioMultiple").checked = true;
                }
                // display the list of choices
                apiJsonResponse.choix.forEach((choice) => {
                    addChoiceElement(choice);
                });
            }
            // hide the full page spinner
            storedData.spinnerFullPageElement.classList.add('d-none');
        }
    }

    document.onreadystatechange = () => {
        // on DOM content loaded
        if (document.readyState === "interactive") {
            // setup the form
            pageSetup();
        }
    }

    // adds a choice element with the provided label
    function addChoiceElement(choiceLabel = "") {
        // clone the content from the option template
        const optionElement = storedData.optionTemplateElement.content.cloneNode(true);
        const mainDiv = optionElement.firstElementChild;
        // add the specified label as value of the input
        mainDiv.querySelector("input").value = choiceLabel;
        // add the option to the list
        storedData.choiceListElement.append(optionElement);
    }

    async function onValidateButtonClick() {
        // if the form is valid ...
        if (storedData.formElement.reportValidity()) {
            // display the full page spinner
            storedData.spinnerFullPageElement.classList.remove("d-none");
            // make a JSON containing the option data
            const optionData = {
                id: storedData.optionId,
                label: storedData.inputLabelElement.value,
                choiceTypeId: Number(storedData.formElement.elements.choiceType.value),
                choices: []
            };
            document.querySelectorAll("#choiceList input").forEach((choiceInputElement) => {
                optionData.choices.push(choiceInputElement.value);
            });
            // send the JSON to /api/order-option
            const response = await fetch("/api/order-option", {
                // use the "PUT" method for a new option
                // and the "POST" method for an update
                method: storedData.optionId === 0 ? "PUT" : "POST",
                headers: {
                    "Content-Type": "application/json; charset=utf-8",
                },
                body: JSON.stringify(optionData)
            });
            if (response.ok) {
                const apiJsonResponse = await response.json();
                if (apiJsonResponse.success) {
                    window.location.href = "/fixe/configuration/carte/options";
                }
            }
        }
    }
</script>

</body>
</html>
