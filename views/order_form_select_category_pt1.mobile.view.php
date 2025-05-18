<div class="container-fluid min-vh-100 d-flex flex-column">

<!-- title bar -->
<div class="row text-center bg-body-tertiary position-sticky top-0 z-1">
    <div class="display-5 pt-2 pb-3">Nouvelle commande - Table <?= $table_number ?></div>
    <hr class="mb-0">
</div>

<!-- step title -->
<div class="row text-center">
    <h3 class="m-0 py-2">Sélectionnez une catégorie</h3>
</div>
<hr class="row m-0">

<!-- page content -->
<main class="row flex-grow-1 d-flex flex-column justify-content-center align-items-center text-center py-2">

<!-- display a message when there are no categories to display -->
<div class="fs-4 text-center mb-3 text-secondary<?= $display_no_categories_message ?>">
    Aucune catégorie de produit.
</div>

<!-- list of categories -->
<!-- <div class="col-10 p-0 fs-5 d-grid">
    <input type="submit" class="btn btn-secondary fs-5 p-3 m-2 text-wrap" form="form" name="1" value="Softs">
</div>
<div class="col-10 p-0 fs-5 d-grid">
    <input type="submit" class="btn btn-secondary fs-5 p-3 m-2 text-wrap" form="form" name="2" value="Entrées">
</div>
<div class="col-10 p-0 fs-5 d-grid">
    <input type="submit" class="btn btn-secondary fs-5 p-3 m-2 text-wrap" form="form" name="3" value="Desserts">
</div> -->
