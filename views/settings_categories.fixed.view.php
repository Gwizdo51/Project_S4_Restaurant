<!-- page content -->
<main id="pageContent" class="bg-body-tertiary rounded mt-3 pt-2 px-0 d-flex flex-column flex-grow-1">

<!-- new category -->
<div class="row mx-3 my-2 p-2 border rounded">
    <label class="col-3 p-2 col-form-label col-form-label-lg align-self-center" for="inputCategoryLabel">
        Nouvelle catégorie
    </label>
    <div class="col-7 p-2 d-grid">
        <input id="inputCategoryLabel" type="text" class="form-control form-control-lg" placeholder="Boissons" value="">
    </div>
    <div class="col-2 p-2 d-grid">
        <button id="addCategoryButton" class="btn btn-outline-primary p-0 fs-4">
            <img src="/assets/img/plus.svg" alt="plus icon" class="mh-3rem">
        </button>
    </div>
    <div id="invalidFeedbackMessage" class="col-9 offset-3 pb-2 d-none">
        <div class="invalid-feedback d-inline px-3">
            Le nom de la catégorie ne peut pas être vide.
        </div>
    </div>
</div>

<div class="row mx-3 my-2 p-2 border rounded">

    <!-- display a spinner on page load -->
    <div id="spinnerPageLoad" class="row p-2 m-0 justify-content-center mt-auto">
        <div class="spinner-border text-light" role="status" style="height: 5rem; width: 5rem;"></div>
    </div>

    <!-- display a message when there are no categories to display -->
    <div id="noCategoriesMessage" class="row fs-4 justify-content-center my-2 text-secondary d-none">
        Aucune catégorie enregistrée.
    </div>

    <!-- list of categories -->
    <div id="categoriesContainer" class="row p-0 m-0"></div>
</div>

<!-- controls -->
<div class="row mx-3 pb-3 pt-2 mt-auto sticky-bottom justify-content-center pe-none">
    <div class="col-3 p-0 bg-body-tertiary border border-secondary rounded pe-auto">
        <div class="row m-2">
            <div class="col-12 p-2 d-grid">
                <a href="/fixe/configuration/carte" type="button" class="btn btn-danger btn-control-big fs-4 d-flex justify-content-center align-items-center">Retour</a>
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
                <p class="mb-0 fs-5">Supprimer la catégorie de produits ?</p>
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

<!-- category template -->
<template id="categoryTemplate">
    <div class="col-6 fs-5 p-2" data-category-id="1">
        <div class="row hoverable bg-body border border-secondary border-2 rounded m-0" style="transition: 0.1s;">
            <a href="/fixe/configuration/carte/categories/1" class="col-9 p-0 border-end border-secondary border-2
            link-underline link-underline-opacity-0 text-body justify-content-center d-flex flex-column align-items-center">
                Softs
            </a>
            <div class="col-3 p-3 d-grid">
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
        request the list of categories from the api (/api/category)
        on response :
            hide the page load spinner
            if there are categories to display, display them
            otherwise, display the "no categories" message
    on add category button click :
        if the new category name is empty :
            show the input as invalid
            display a feedback message
        else :
            show the full page spinner
            send a PUT request to /api/category with the label input by the user
            on positive response :
                clear the input value and state
                hide the feedback message
                display the new category
            hide the full page spinner
    on modal confirm click :
        display the full page spinner
        send a DELETE request to /api/category with the id of the category to DELETE
        on positive reponse :
            remove the deleted category
        hide the full page spinner
    */

    import {decodeHtml} from '/assets/js/utils.js';

    const storedData = {
        categoryElementToDelete: null,
        spinnerFullPageElement: document.querySelector("#spinnerFullPage"),
        inputCategoryLabel: document.querySelector("#inputCategoryLabel"),
        invalidFeedbackMessage: document.querySelector("#invalidFeedbackMessage"),
        categoriesContainer: document.querySelector("#categoriesContainer"),
        noCategoriesMessage: document.querySelector("#noCategoriesMessage"),
        categoryTemplate: document.querySelector("#categoryTemplate")
    };

    function addCategoryElement(categoryId, categoryLabel) {
        // clone the content from the category template
        const categoryElement = storedData.categoryTemplate.content.cloneNode(true);
        const mainDiv = categoryElement.firstElementChild;
        const anchorElement = mainDiv.querySelector("a");
        // add the category ID to the dataset
        mainDiv.dataset.categoryId = categoryId;
        // add the link target
        anchorElement.href = `/fixe/configuration/carte/categories/${categoryId}`;
        // add the category label
        anchorElement.textContent = categoryLabel;
        // change the color of the background of the category on mouse hover
        const hoverable = mainDiv.querySelector(".hoverable");
        hoverable.addEventListener("mouseenter", (event) => {
            hoverable.classList.remove("bg-body");
            hoverable.classList.add("bg-secondary-subtle");
        });
        hoverable.addEventListener("mouseleave", (event) => {
            hoverable.classList.add("bg-body");
            hoverable.classList.remove("bg-secondary-subtle");
        });
        // add an "on click" event listener to the button
        mainDiv.querySelector("button").addEventListener("click", (event) => {
            storedData.categoryElementToDelete = event.srcElement.parentElement.parentElement.parentElement;
        });
        // display the category
        storedData.categoriesContainer.append(categoryElement);
        // hide the "no categories" message
        storedData.noCategoriesMessage.classList.add("d-none");
    }

    async function pageSetup() {
        const response = await fetch("/api/category");
        if (response.ok) {
            const apiJsonResponse = await response.json();
            // hide the page load spinner
            document.querySelector("#spinnerPageLoad").classList.add("d-none");
            // if the list of categories is empty, show the "no categories" message
            if (Object.keys(apiJsonResponse).length === 0) {
                storedData.noCategoriesMessage.classList.remove("d-none");
            }
            // display each category
            for (const categoryId in apiJsonResponse) {
                addCategoryElement(categoryId, decodeHtml(apiJsonResponse[categoryId]));
            }
        }
    }

    document.onreadystatechange = () => {
        // add "on click" event listeners to buttons
        document.querySelector("#addCategoryButton").addEventListener("click", onAddCategoryButtonClick);
        document.querySelector("#confirmModalButton").addEventListener("click", onModalConfirmButtonClick);
        // fetch and display the categories from the database
        pageSetup();
    }

    async function onAddCategoryButtonClick() {
        // the new category name cannot be empty
        const newCategoryLabel = storedData.inputCategoryLabel.value.trim();
        if (newCategoryLabel.length === 0) {
            // show the input is invalid
            storedData.inputCategoryLabel.classList.add("is-invalid");
            // display the feedback message
            storedData.invalidFeedbackMessage.classList.remove("d-none");
            // set the focus on the input
            storedData.inputCategoryLabel.focus();
        }
        else {
            // show the full page spinner
            storedData.spinnerFullPageElement.classList.remove("d-none");
            // send the JSON with the new category name to /api/category
            const response = await fetch("/api/category", {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json; charset=utf-8",
                },
                body: JSON.stringify({newCategoryLabel})
            });
            if (response.ok) {
                const categoryApiJsonResponse = await response.json();
                if (categoryApiJsonResponse.success) {
                    // clear the input value and state
                    storedData.inputCategoryLabel.value = "";
                    storedData.inputCategoryLabel.classList.remove("is-invalid");
                    // hide the feedback message
                    storedData.invalidFeedbackMessage.classList.add("d-none");
                    // display the new category
                    addCategoryElement(categoryApiJsonResponse.newCategoryId, newCategoryLabel);
                }
            }
            // hide the full page spinner
            storedData.spinnerFullPageElement.classList.add("d-none");
        }
    }

    async function onModalConfirmButtonClick() {
        // show the full page spinner
        storedData.spinnerFullPageElement.classList.remove("d-none");
        // send the JSON with the ID of the category to delete to /api/category
        const response = await fetch("/api/category", {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json; charset=utf-8",
            },
            body: JSON.stringify({
                CategoryToDeleteId: Number(storedData.categoryElementToDelete.dataset.categoryId)
            })
        });
        if (response.ok) {
            const categoryApiJsonResponse = await response.json();
            if (categoryApiJsonResponse.success) {
                // remove the category from the displayed list
                storedData.categoryElementToDelete.remove();
                // if there are no categories displayed ...
                if (storedData.categoriesContainer.childElementCount === 0) {
                    // show the "no categories" message
                    storedData.noCategoriesMessage.classList.remove("d-none");
                }
            }
        }
        // hide the full page spinner
        storedData.spinnerFullPageElement.classList.add("d-none");
    }
</script>

</body>
</html>
