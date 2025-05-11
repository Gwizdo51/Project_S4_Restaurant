<div class="container-fluid min-vh-100 d-flex flex-column">

<!-- title bar -->
<div class="row bg-body-tertiary position-sticky top-0">
    <div class="d-flex justify-content-center display-5 pt-1 pb-2">Sélectionnez votre nom</div>
    <hr class="mb-0">
</div>

<!-- page content -->
<main class="row flex-grow-1 d-flex flex-column justify-content-center fs-4 text-center py-2">

<!-- display a message is there are no active servers in the database -->
<div class="text-center text-secondary<?= $display_no_servers_message ?>">
    Aucun serveur actif.
</div>

<!-- columns descriptions -->
<div class="col-12 text-secondary<?= $display_columns_descriptions ?>">
    <div class="row justify-content-center">
        <div class="col-5 py-2">Nom du serveur</div>
        <div class="col-5 py-2">Secteur assigné</div>
    </div>
</div>

<!-- list of servers -->
