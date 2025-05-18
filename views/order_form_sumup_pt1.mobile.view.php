<div class="container-fluid min-vh-100 d-flex flex-column">

<!-- title bar -->
<div class="row text-center bg-body-tertiary position-sticky top-0">
    <div class="display-5 pt-2 pb-3">Nouvelle commande - Table <?= $table_number ?></div>
    <hr class="mb-0">
</div>

<!-- step title -->
<div class="row text-center">
    <h3 class="m-0 py-2">Résumé</h3>
</div>
<hr class="row m-0">

<!-- page content -->
<main class="row flex-grow-1 d-flex flex-column justify-content-center text-center py-2">

<!-- display a message when there are no items to display -->
<div class="fs-4 text-center mb-3 text-secondary<?= $display_no_items_message ?>">
    Aucun produit.
</div>

<!-- columns description -->
<div class="col-12 p-0 text-secondary<?= $display_columns_descriptions ?>">
    <div class="row mx-3 my-2">
        <div class="col-4 px-3">Label du produit</div>
        <div class="col-5 px-3">Détails</div>
    </div>
</div>

<!-- list of items -->
<!-- <div class="col-12 p-0 text-start">
    <div class="row bg-body-secondary border border-secondary border-2 rounded mx-3 my-2">
        <div class="col-4 py-3 d-flex flex-column justify-content-center">
            Entrecôte
        </div>
        <div class="col-5 py-3 d-flex flex-column justify-content-center border-start border-end border-secondary border-2">
            Cuisson : A point
            <br>
            Sauces : -
        </div>
        <div class="col-3 p-3 d-grid">
            <button type="button" class="btn btn-danger fs-4" data-bs-toggle="modal" data-bs-target="#confirmationModal" onclick="onDeleteItemButtonClick(0);">X</button>
        </div>
    </div>
</div>
<div class="col-12 p-0 text-start">
    <div class="row bg-body-secondary border border-secondary border-2 rounded mx-3 my-2">
        <div class="col-4 py-3 d-flex flex-column justify-content-center">
            Evian
        </div>
        <div class="col-5 py-3 d-flex flex-column justify-content-center border-start border-end border-secondary border-2">
            Avec une paille
        </div>
        <div class="col-3 p-3 d-grid">
            <button type="button" class="btn btn-danger fs-4" data-bs-toggle="modal" data-bs-target="#confirmationModal" onclick="onDeleteItemButtonClick(1);">X</button>
        </div>
    </div>
</div>
<div class="col-12 p-0 text-start">
    <div class="row bg-body-secondary border border-secondary border-2 rounded mx-3 my-2">
        <div class="col-4 py-3 d-flex flex-column justify-content-center">
            Grenadine
        </div>
        <div class="col-5 py-3 d-flex flex-column justify-content-center border-start border-end border-secondary border-2">
            Glaçons : Sans
        </div>
        <div class="col-3 p-3 d-grid">
            <button type="button" class="btn btn-danger fs-4" data-bs-toggle="modal" data-bs-target="#confirmationModal" onclick="onDeleteItemButtonClick(2);">X</button>
        </div>
    </div>
</div> -->
