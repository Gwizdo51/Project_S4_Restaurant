</main>

<!-- controls -->
<div class="row rounded justify-content-center px-3 pb-3 pe-none invisible">
    <div class="col-12 bg-body-tertiary border border-secondary rounded d-grid pe-auto">
        <div class="row p-2">
            <div class="col-sm-4 col-6 p-0 d-grid">
                <button type="button" class="btn btn-control btn-danger fs-5 p-0 m-2" data-bs-toggle="modal" data-bs-target="#confirmationModal" onclick="onCancelOrderButtonClick();">Annuler</button>
            </div>
            <div class="col-sm-4 col-6 p-0 d-grid">
                <button type="button" class="btn btn-primary fs-5 p-0 m-2" onclick="onAddItemButtonClick();">
                    <img src="/assets/img/plus.svg" alt="plus icon" class="mh-3rem img-fluid">
                </button>
            </div>
            <div class="col-sm-4 col-12 p-0 d-grid">
                <button type="button" class="btn btn-control btn-success fs-5 m-2" data-bs-toggle="modal" data-bs-target="#confirmationModal" onclick="onConfirmOrderButtonClick();"<?= $disable_confirm_button ?>>Valider</button>
            </div>
        </div>
    </div>
</div>
<div class="row rounded position-fixed w-100 bottom-0 justify-content-center px-3 pb-3 pe-none">
    <div class="col-12 bg-body-tertiary border border-secondary rounded d-grid pe-auto">
        <div class="row p-2">
            <div class="col-sm-4 col-6 p-0 d-grid">
                <button type="button" class="btn btn-control btn-danger fs-5 p-0 m-2" data-bs-toggle="modal" data-bs-target="#confirmationModal" onclick="onCancelOrderButtonClick();">Annuler</button>
            </div>
            <div class="col-sm-4 col-6 p-0 d-grid">
                <button type="button" class="btn btn-primary fs-5 p-0 m-2" onclick="onAddItemButtonClick();">
                    <img src="/assets/img/plus.svg" alt="plus icon" class="mh-3rem img-fluid">
                </button>
            </div>
            <div class="col-sm-4 col-12 p-0 d-grid">
                <button type="button" class="btn btn-control btn-success fs-5 m-2" data-bs-toggle="modal" data-bs-target="#confirmationModal" onclick="onConfirmOrderButtonClick();"<?= $disable_confirm_button ?>>Valider</button>
            </div>
        </div>
    </div>
</div>

</div>

<!-- dynamic confirmation modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmation</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0 fs-5">Annuler l'ajout de produits ?</p>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 d-grid">
                            <button type="button" class="btn btn-danger py-4 fs-4" data-bs-dismiss="modal">Annuler</button>
                        </div>
                        <div class="col-6 d-grid">
                            <input type="submit" class="btn btn-success py-4 fs-4" form="form" name="cancel_order" value="OK">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="form" method="POST"></form>

<!-- 🔹 Bootstrap JS -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>

<script>
    "use strict";

    // const form = document.forms[0];
    // console.log(form);

    /* pseudocode :
    on cancel order button click :
        change confirmation modal text to "Annuler la commande ?"
        change confirmation modal "OK" input button name to "cancel_order"
    on confirm order button click :
        change confirmation modal text to "Valider la commande ?"
        change confirmation modal "OK" input button name to "confirm_order"
    on add item button click :
        add an input with the name "add_item" and the value "" to the form
        send the form
    on delete item button click :
        change confirmation modal text to "Supprimer le produit ?"
        change confirmation modal "OK" input button name to "${itemIndex}"
    */

    const form = document.forms[0];

    function onConfirmOrderButtonClick() {
        document.querySelector("#confirmationModal p").textContent = "Valider la commande ?";
        document.querySelector("#confirmationModal input").setAttribute("name", "confirm_order");
    }

    function onCancelOrderButtonClick() {
        document.querySelector("#confirmationModal p").textContent = "Annuler la commande ?";
        document.querySelector("#confirmationModal input").setAttribute("name", "cancel_order");
    }

    function onDeleteItemButtonClick(itemIndex) {
        document.querySelector("#confirmationModal p").textContent = "Supprimer le produit ?";
        document.querySelector("#confirmationModal input").setAttribute("name", itemIndex);
    }

    function onAddItemButtonClick() {
        form.innerHTML = '<input class="d-none" name="add_item" value="">';
        form.submit();
    }
</script>

</body>
</html>
