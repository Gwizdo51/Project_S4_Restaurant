<!-- page content -->
<main id="pageContent" class="bg-body-tertiary rounded mt-3 pt-2 px-0 d-flex flex-column flex-grow-1">

    <!-- category label -->
    <div class="row align-items-center m-2">
        <div class="col-3 py-0 px-2 col-form-label col-form-label-lg">Catégorie actuelle</div>
        <strong class="col-9 py-0 px-2 col-form-label col-form-label-lg"></strong>
    </div>

    <!-- product label -->
    <div class="row align-items-center m-2">
        <label class="col-3 py-0 px-2 col-form-label col-form-label-lg" for="productLabelInput">Nom du produit</label>
        <div class="col-9 py-0 px-2">
            <input id="productLabelInput" type="text" class="form-control form-control-lg" form="form" name="productLabel" placeholder="Pâtes">
        </div>
        <div id="invalidLabelFeedbackMessage" class="col-9 offset-3 pt-1 px-2 d-none">
            <div class="invalid-feedback d-inline px-3">
                Le nom du produit ne peut pas être vide.
            </div>
        </div>
    </div>

    <!-- preparation place -->
    <div class="row align-items-center m-2">
        <label class="col-3 py-0 px-2 col-form-label col-form-label-lg">Lieu de préparation</label>
        <div class="col-9 py-0 px-2">
            <div id="preparationPlaceContainer" class="row border rounded m-0 p-2 bg-body">
                <div class="col-6 p-2 fs-5">
                    <div class="form-check">
                        <input class="form-check-input" id="radioKitchen" form="form" type="radio" name="preparationPlace" value="1">
                        <label class="form-check-label user-select-none" for="radioKitchen">
                            Cuisine
                        </label>
                    </div>
                </div>
                <div class="col-6 p-2 fs-5">
                    <div class="form-check">
                        <input class="form-check-input" id="radioBar" form="form" type="radio" name="preparationPlace" value="2">
                        <label class="form-check-label user-select-none" for="radioBar">
                            Bar
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div id="invalidPlaceFeedbackMessage" class="col-9 offset-3 px-2 pt-1 d-none">
            <div class="invalid-feedback d-inline px-3">
                Sélectionnez un lieu de préparation.
            </div>
        </div>
    </div>

    <!-- price -->
    <div class="row align-items-center m-2">
        <label class="col-3 py-0 px-2 col-form-label col-form-label-lg" for="productPriceInput">Prix</label>
        <div class="col-9 py-0 px-2">
            <div class="input-group input-group-lg">
                <input id="productPriceInput" type="number" class="form-control" form="form" name="productPrice" placeholder="00.00" min="0" step=".01">
                <span class="input-group-text">€</span>
            </div>
        </div>
        <div id="invalidPriceFeedbackMessage" class="col-9 offset-3 pt-1 px-2 d-none">
            <div class="invalid-feedback d-inline px-3">
                Le prix du produit doit être renseigné.
            </div>
        </div>
    </div>

    <!-- list of free and assigned tables -->
    <div class="row align-items-center m-2">
        <label class="col-3 py-0 px-2 col-form-label col-form-label-lg">Options de commande</label>
        <div class="col-9 py-0 px-2">
            <div id="orderOptionsContainer" class="row border rounded m-0 p-2 fs-5 bg-body">
                <!-- display a message when there are no order options -->
                <div id="noOptionsMessage" class="col-12 fs-4 text-center my-2 text-secondary d-none">
                    Aucune option de commande.
                </div>
            </div>
        </div>
    </div>

    <!-- controls -->
    <div class="row mx-3 pb-3 pt-2 mt-auto justify-content-center pe-none">
        <div class="col-6 p-0 bg-body-tertiary border border-secondary rounded pe-auto">
            <div class="row m-2">
                <div class="col-6 p-2 d-grid">
                    <a href="/fixe/configuration/carte/categories/<?= $category_id ?>" type="button" class="btn btn-danger btn-control-big fs-4 d-flex justify-content-center align-items-center">Annuler</a>
                </div>
                <div class="col-6 p-2 d-grid">
                    <button id="validateButtonClick" type="button" class="btn btn-success btn-control-big fs-4 d-flex justify-content-center align-items-center">Valider</button>
                </div>
            </div>
        </div>
    </div>

</main>
<!-- end of page content -->

<form id="form" name="form"></form>

<!-- option order template -->
<template id="optionTemplate">
    <div class="col-6 p-2">
        <div class="form-check">
            <input class="form-check-input" form="form" id="option3" type="checkbox" name="option3" data-option-id="3">
            <label class="form-check-label user-select-none" for="option3">
                Sauces
            </label>
        </div>
    </div>
</template>

</div>

</div>

</div>

<!-- 🔹 Bootstrap JS -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>

<script type="module">
    /* pseudocode :
    on page load :
        display the full page spinner
        request the product data from the API : /api/product?id={productId}
        fill the form with the product data (when modifying a product)
        add the order option
        remove the full page spinner
    on validate button click :
        if the form is not valid :
            show feedback for each element
        else :
            display the full page spinner
            make a JSON containing the product data
            send the JSON to the API : /api/product (PUT or POST)
            on response, redirect to /fixe/configuration/carte/categories/XXX
    */

    import {decodeHtml} from '/assets/js/utils.js';

    const storedData = {
        categoryId: <?= $category_id ?>,
        productId: <?= $product_id ?>,
        formElement: document.forms.form,
        formValidation: {
            labelIsValid: null,
            placeIsValid: null,
            priceIsSet: null,
            priceIsNumber: null
        },
        spinnerFullPage: document.querySelector("#spinnerFullPage"),
        productLabelInput: document.querySelector("#productLabelInput"),
        invalidLabelFeedbackMessage: document.querySelector("#invalidLabelFeedbackMessage"),
        preparationPlaceContainer: document.querySelector("#preparationPlaceContainer"),
        invalidPlaceFeedbackMessage: document.querySelector("#invalidPlaceFeedbackMessage"),
        productPriceInput: document.querySelector("#productPriceInput"),
        invalidPriceFeedbackMessage: document.querySelector("#invalidPriceFeedbackMessage"),
        noOptionsMessage: document.querySelector("#noOptionsMessage"),
        optionTemplate: document.querySelector("#optionTemplate"),
        orderOptionsContainer: document.querySelector("#orderOptionsContainer")
    };
    // for debugging purposes
    // window.storedData = storedData;

    document.onreadystatechange = () => {
        // show the full page spinner
        storedData.spinnerFullPage.classList.remove("d-none");
        // add "on click" event listeners to buttons
        document.querySelector("#validateButtonClick").addEventListener("click", onValidateButtonClick);
        // fetch and display the category data (name and products) from the database
        pageSetup();
    }

    async function pageSetup() {
        const response = await fetch(`/api/product?productId=${storedData.productId}&categoryId=${storedData.categoryId}`);
        if (response.ok) {
            const apiJsonResponse = await response.json();
            // display the "no options" message if the list of options is empty
            if (Object.keys(apiJsonResponse.orderOptions).length === 0) {
                storedData.noOptionsMessage.classList.remove("d-none");
            }
            // add the order options
            for (const optionId in apiJsonResponse.orderOptions) {
                // clone the content from the option template
                const optionElement = storedData.optionTemplate.content.cloneNode(true);
                const mainDiv = optionElement.firstElementChild;
                const inputElement = mainDiv.querySelector("input");
                const labelElement = mainDiv.querySelector("label");
                // add the option ID
                inputElement.dataset.optionId = optionId;
                // set the "name" and "id" tags
                const id = "option" + optionId;
                inputElement.id = id;
                inputElement.name = id;
                // add the option label
                labelElement.setAttribute("for", id);
                labelElement.textContent = decodeHtml(apiJsonResponse.orderOptions[optionId]);
                // display the order option
                storedData.orderOptionsContainer.append(optionElement);
            }
            // add the category label
            document.querySelector("strong").textContent = decodeHtml(apiJsonResponse.categoryLabel);
            // add the product data (when modifying a product)
            if (storedData.productId !== 0) {
                // add the product label
                storedData.productLabelInput.value = decodeHtml(apiJsonResponse.productData.label);
                // add the product preparation place
                document.querySelector(`input[type="radio"][value="${apiJsonResponse.productData.preparationPlaceId}"]`).checked = true;
                // add the product price
                storedData.productPriceInput.value = apiJsonResponse.productData.price;
                // add the selected order options
                for (const optionId of apiJsonResponse.productData.orderOptions) {
                    // select the related order option
                    document.querySelector(`#option${optionId}`).checked = true;
                }
            }
        }
        // hide the full page spinner
        storedData.spinnerFullPage.classList.add("d-none");
    }

    async function onValidateButtonClick() {
        // if the form is valid ...
        if (validateForm()) {
            // display the full page spinner
            storedData.spinnerFullPage.classList.remove("d-none");
            // make a JSON containing the product data
            const productData = {
                productId: storedData.productId,
                categoryId: storedData.categoryId,
                label: storedData.formElement.elements.productLabel.value.trim(),
                preparationPlaceId: Number(storedData.formElement.elements.preparationPlace.value),
                price: Number(storedData.formElement.elements.productPrice.value.trim()),
                orderOptionsIds: []
            };
            storedData.orderOptionsContainer.querySelectorAll("input").forEach((inputElement) => {
                if (inputElement.checked) {
                    productData.orderOptionsIds.push(Number(inputElement.dataset.optionId));
                }
            });
            // send the JSON to the API : /api/product (PUT or POST)
            const response = await fetch("/api/product", {
                // use the "PUT" method for a new product
                // and the "POST" method for an update
                method: storedData.productId === 0 ? "PUT" : "POST",
                headers: {
                    "Content-Type": "application/json; charset=utf-8",
                },
                body: JSON.stringify(productData)
            });
            if (response.ok) {
                const apiJsonResponse = await response.json();
                if (apiJsonResponse.success) {
                    window.location.href = `/fixe/configuration/carte/categories/${storedData.categoryId}`;
                }
            }
        }
        // otherwise ...
        else {
            // show feedback for the product label
            if (storedData.formValidation.labelIsValid) {
                storedData.productLabelInput.classList.add("is-valid");
                storedData.productLabelInput.classList.remove("is-invalid");
                storedData.invalidLabelFeedbackMessage.classList.add("d-none");
            }
            else {
                storedData.productLabelInput.classList.remove("is-valid");
                storedData.productLabelInput.classList.add("is-invalid");
                storedData.invalidLabelFeedbackMessage.classList.remove("d-none");
            }
            // show feedback for the preparation place
            if (storedData.formValidation.placeIsValid) {
                storedData.preparationPlaceContainer.classList.add("border-success");
                storedData.preparationPlaceContainer.classList.remove("border-danger");
                storedData.invalidPlaceFeedbackMessage.classList.add("d-none");
            }
            else {
                storedData.preparationPlaceContainer.classList.remove("border-success");
                storedData.preparationPlaceContainer.classList.add("border-danger");
                storedData.invalidPlaceFeedbackMessage.classList.remove("d-none");
            }
            // show feedback for the product price
            if (storedData.formValidation.priceIsSet && storedData.formValidation.priceIsNumber) {
                storedData.productPriceInput.classList.add("is-valid");
                storedData.productPriceInput.classList.remove("is-invalid");
                storedData.invalidPriceFeedbackMessage.classList.add("d-none");
            }
            else {
                storedData.productPriceInput.classList.remove("is-valid");
                storedData.productPriceInput.classList.add("is-invalid");
                if (!storedData.formValidation.priceIsSet) {
                    storedData.invalidPriceFeedbackMessage.firstElementChild.textContent = "Le prix du produit doit être renseigné.";
                }
                else if (!storedData.formValidation.priceIsNumber) {
                    storedData.invalidPriceFeedbackMessage.firstElementChild.textContent = "Le prix doit être un nombre décimal positif.";
                }
                storedData.invalidPriceFeedbackMessage.classList.remove("d-none");
            }
        }
    }

    function validateForm() {
        // the product label cannot be empty
        storedData.formValidation.labelIsValid = storedData.formElement.elements.productLabel.value.trim().length !== 0;
        // a preparation place must be selected
        storedData.formValidation.placeIsValid = storedData.formElement.elements.preparationPlace.value !== "";
        // the price must be set, and be a float
        const inputPrice = storedData.formElement.elements.productPrice.value.trim();
        // storedData.formValidation.priceIsValid = (inputPrice.length !== 0) && (!isNaN(Number.parseFloat(inputPrice)));
        storedData.formValidation.priceIsSet = inputPrice.length !== 0;
        storedData.formValidation.priceIsNumber = !isNaN(Number.parseFloat(inputPrice));
        return storedData.formValidation.labelIsValid && storedData.formValidation.placeIsValid && storedData.formValidation.priceIsSet && storedData.formValidation.priceIsNumber;
    }
</script>

</body>
</html>
