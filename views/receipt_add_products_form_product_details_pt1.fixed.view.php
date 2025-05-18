<!-- page content -->
<main id="page-content" class="bg-body-tertiary rounded mt-3 pt-3 d-flex flex-column flex-grow-1">

<h3 class="mb-3 pb-1 text-center"><?= $product_label ?></h3>
<hr class="mx-3 mt-0">

<!-- details textarea -->
<label class="row mx-3 mb-3 mb-3 justify-content-center fs-4" for="inputDetails">Détails</label>
<div class="mb-3 mx-3 p-0">
    <textarea id="inputDetails" class="p-3 form-control form-control-lg" form="form" name="details" rows="5" placeholder="Entrez des détails ..."></textarea>
</div>

<!-- order options -->
<div class="mb-3 text-center fs-4">Options de commande</div>

<!-- display a message when there are no order options to display -->
<div class="fs-4 text-center mb-3 text-secondary<?= $display_no_options_message ?>">Aucune option de commande.</div>
