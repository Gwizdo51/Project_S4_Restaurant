<!-- page content -->
<main id="pageContent" class="bg-body-tertiary rounded mt-3 pt-2 px-0 d-flex flex-column flex-grow-1">

    <!-- category label -->
    <div class="row mx-3 my-2 p-2 border rounded">
        <label class="col-3 p-2 col-form-label col-form-label-lg align-self-center" for="inputCategoryLabel">
            Nom
        </label>
        <div class="col-7 p-2 d-grid">
            <input id="inputCategoryLabel" type="text" class="form-control form-control-lg" value="">
        </div>
        <div class="col-2 p-2 d-grid">
            <button id="changeCategoryLabelButton" class="btn btn-outline-primary p-0 fs-4" style="height: 50px;">Modifier</button>
        </div>
        <div id="invalidFeedbackMessage" class="col-9 offset-3 pb-2 px-2 d-none">
            <div class="invalid-feedback d-inline px-3">
                Le nom de la catégorie ne peut pas être vide.
            </div>
        </div>
    </div>

    <div class="row mx-3 my-2 p-2 justify-content-center border rounded d-flex flex-column">

        <!-- display a message when there are no products to display -->
        <div id="noProductsMessage" class="row p-0 mx-0 my-2 fs-4 justify-content-center text-secondary d-none">
            Aucun produit dans la catégorie.
        </div>

        <!-- columns descriptions -->
        <div id="columnsDescriptions" class="col-12 p-2 justify-content-center text-secondary d-none">
            <div class="row border border-2 align-items-center text-center m-0" style="border-color: #0000 !important;">
                <div class="col-10">
                    <div class="row">
                        <div class="col-6">Nom du produit</div>
                        <div class="col-3">Prix</div>
                        <div class="col-3">Lieu de préparation</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- list of products -->
        <div id="productsContainer" class="row p-0 m-0"></div>

    </div>

    <!-- controls -->
    <div class="row mx-3 pb-3 pt-2 mt-auto sticky-bottom justify-content-center pe-none">
        <div class="col-6 p-0 bg-body-tertiary border border-secondary rounded pe-auto">
            <div class="row m-2">
                <div class="col-6 p-2 d-grid">
                    <a href="/fixe/configuration/carte/categories" type="button" class="btn btn-danger btn-control-big fs-4 d-flex justify-content-center align-items-center">Retour</a>
                </div>
                <div class="col-6 p-2 d-grid">
                    <a href="/fixe/configuration/carte/categories/<?= $category_id ?>/nouveau-produit" role="button" class="btn btn-primary btn-control-big p-0 fs-4 d-flex justify-content-center align-items-center">
                        <img src="/assets/img/plus.svg" alt="plus icon" class="mh-3rem">
                    </a>
                </div>
            </div>
        </div>
    </div>

</main>
<!-- end of page content -->

<!-- confirmation modal -->
<div id="confirmationModal" class="modal fade" tabindex="-1" aria-labelledby="confirmationModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmation</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0 fs-5">Supprimer le produit ?</p>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 d-grid">
                            <button type="button" class="btn btn-danger py-5 fs-4" data-bs-dismiss="modal">Annuler</button>
                        </div>
                        <div class="col-6 d-grid">
                            <button id="confirmModalButton" type="button" class="btn btn-success py-5 fs-4" data-bs-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- product template -->
<template id="productTemplate">
    <div class="col-12 fs-5 p-2" data-product-id="1">
        <div class="row hoverable bg-body border border-secondary border-2 rounded m-0" style="transition: 0.1s;">
            <a href="/fixe/configuration/carte/categories/<?= $category_id ?>/1" class="col-10 p-0 link-underline link-underline-opacity-0 text-body text-center d-flex flex-column">
                <div class="row m-0 flex-grow-1">
                    <div class="productName col-6 p-3 d-flex flex-column justify-content-center">
                        Grenadine
                    </div>
                    <div class="productPrice col-3 p-3 border-start border-end border-secondary border-2 d-flex flex-column justify-content-center">
                        1,5 €
                    </div>
                    <div class="productPlace col-3 p-3 border-end border-secondary border-2 d-flex flex-column justify-content-center">
                        Bar
                    </div>
                </div>
            </a>
            <div class="col-2 p-3 d-grid">
                <button type="button" class="btn btn-outline-danger fs-4" data-bs-toggle="modal" data-bs-target="#confirmationModal">X</button>
            </div>
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
        show the full page spinner
        request the category data from the api (/api/category?categoryId=XXX)
        on response :
            hide the full page spinner
            if there are categories to display, display them and the columns descriptions
            otherwise, display the "no categories" message
    on change category label button click :
        if the new category name is empty :
            show the input as invalid
            display the feedback message
        else if the new label is different from the original label :
            show the full page spinner
            stop showing the input as invalid
            hide the feedback message
            send a POST request to /api/category with the label input by the user
            wait for response
            hide the full page spinner
    on modal confirm button click :
        display the full page spinner
        send a DELETE request to /api/product with the id of the product to delete
        on positive reponse :
            remove the deleted product
        hide the full page spinner
    */

    import {decodeHtml} from '/assets/js/utils.js';

    const storedData = {
        categoryId: <?= $category_id ?>,
        originalCategoryLabel: null,
        productElementToDelete: null,
        spinnerFullPage: document.querySelector("#spinnerFullPage"),
        inputCategoryLabel: document.querySelector("#inputCategoryLabel"),
        invalidFeedbackMessage: document.querySelector("#invalidFeedbackMessage"),
        columnsDescriptions: document.querySelector("#columnsDescriptions"),
        productsContainer: document.querySelector("#productsContainer"),
        noProductsMessage: document.querySelector("#noProductsMessage"),
        productTemplate: document.querySelector("#productTemplate")
    };
    // for debugging purposes
    window.storedData = storedData;

    const preparationPlaces = {
        1: "Cuisine",
        2: "Bar"
    };

    async function pageSetup() {
        // console.log(storedData.categoryId);
        const response = await fetch(`/api/category?categoryId=${storedData.categoryId}`);
        if (response.ok) {
            const apiJsonResponse = await response.json();
            console.log(apiJsonResponse);
            // hide the full page spinner
            storedData.spinnerFullPage.classList.add("d-none");
            // add the category label to the input
            const categoryLabel = decodeHtml(apiJsonResponse.label);
            storedData.inputCategoryLabel.value = categoryLabel;
            // remember the original category label
            storedData.originalCategoryLabel = categoryLabel;
            // if the list of products is empty, show the "no products" message
            if (apiJsonResponse.produits.length === 0) {
                storedData.noProductsMessage.classList.remove("d-none");
            }
            // otherwise, show the columns descriptions
            else {
                storedData.columnsDescriptions.classList.remove("d-none");
            }
            // display each product
            apiJsonResponse.produits.forEach((product) => {
                // clone the content from the product template
                const productElement = storedData.productTemplate.content.cloneNode(true);
                const mainDiv = productElement.firstElementChild;
                // add the product ID to the dataset
                mainDiv.dataset.productId = product.id;
                // add the product label
                mainDiv.querySelector(".productName").textContent = decodeHtml(product.label);
                // add the product price
                mainDiv.querySelector(".productPrice").textContent = product.prix;
                // add the product preparation place
                mainDiv.querySelector(".productPlace").textContent = preparationPlaces[product.id_lieu_preparation];
                // add an "on click" event listener to the button
                mainDiv.querySelector("button").addEventListener("click", (event) => {
                    storedData.productElementToDelete = event.srcElement.parentElement.parentElement.parentElement;
                });
                // display the product
                storedData.productsContainer.append(productElement);
            });
        }
    }

    document.onreadystatechange = () => {
        // show the full page spinner
        storedData.spinnerFullPage.classList.remove("d-none");
        // add "on click" event listeners to buttons
        document.querySelector("#changeCategoryLabelButton").addEventListener("click", onChangeLabelButtonClick);
        document.querySelector("#confirmModalButton").addEventListener("click", onModalConfirmButtonClick);
        // fetch and display the category data (name and products) from the database
        pageSetup();
    }

    async function onChangeLabelButtonClick() {
        // the new category name cannot be empty
        const newCategoryLabel = storedData.inputCategoryLabel.value.trim();
        if (newCategoryLabel.length === 0) {
            // show the input is invalid
            storedData.inputCategoryLabel.classList.add("is-invalid");
            // display the feedback message
            storedData.invalidFeedbackMessage.classList.remove("d-none");
        }
        else {
            // stop showing the input as invalid
            storedData.inputCategoryLabel.classList.remove("is-invalid");
            // display the feedback message
            storedData.invalidFeedbackMessage.classList.add("d-none");
            // if the category name would change ...
            if (newCategoryLabel !== storedData.originalCategoryLabel) {
                // show the full page spinner
                storedData.spinnerFullPage.classList.remove("d-none");
                // send a POST request to /api/category with the label input by the user
                const response = await fetch("/api/category", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json; charset=utf-8",
                    },
                    body: JSON.stringify({
                        categoryId: storedData.categoryId,
                        newCategoryLabel
                    })
                });
                // hide the full page spinner
                storedData.spinnerFullPage.classList.add("d-none");
            }
        }
    }

    async function onModalConfirmButtonClick() {
        // show the full page spinner
        storedData.spinnerFullPage.classList.remove("d-none");
        // send the JSON with the ID of the category to delete to /api/category
        const response = await fetch("/api/product", {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json; charset=utf-8",
            },
            body: JSON.stringify({
                productToDeleteId: Number(storedData.productElementToDelete.dataset.productId)
            })
        });
        if (response.ok) {
            const productApiJsonResponse = await response.json();
            console.log(productApiJsonResponse);
            if (productApiJsonResponse.success) {
                // remove the product from the displayed list
                storedData.productElementToDelete.remove();
                // if there are no products displayed ...
                if (storedData.productsContainer.childElementCount === 0) {
                    // hide the columns descriptions
                    storedData.columnsDescriptions.classList.add("d-none");
                    // show the "no products" message
                    storedData.noProductsMessage.classList.remove("d-none");
                }
            }
        }
        // hide the full page spinner
        storedData.spinnerFullPage.classList.add("d-none");
    }
</script>

</body>
</html>
