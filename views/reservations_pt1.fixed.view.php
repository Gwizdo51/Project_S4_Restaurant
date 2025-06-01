<!-- page content -->
<main id="page-content" class="bg-body-tertiary rounded mt-3 pt-3 d-flex flex-column flex-grow-1">

<!-- display a message when there are no reservation to display -->
<div id="no-reservations-message" class="fs-4 text-center mb-3 text-secondary<?= $display_no_reservations_message ?>">
    Aucune réservation.
</div>

<!-- columns description -->
<!-- $0.getBoundingClientRect() to get the position of a selected element -->
<div id="columns-description" class="row mb-3 mx-3 text-secondary sticky-top sticky-top-below-title bg-body-tertiary<?= $display_columns_descriptions ?>">
    <div class="col-12 p-0 bg-body-tertiary border border-secondary rounded">
        <div class="row m-0">
            <div class="col-10 p-0">
                <div class="row m-0">
                    <div class="col-4 py-3 d-flex flex-column justify-content-center text-center">Date et heure</div>
                    <div class="col-4 py-3 d-flex flex-column justify-content-center text-center">Nom du client</div>
                    <div class="col-2 py-3 d-flex flex-column justify-content-center text-center">Nombre de personnes</div>
                    <div class="col-2 py-3 d-flex flex-column justify-content-center text-center">Table(s) réservée(s)</div>
                </div>
            </div>
            <div class="col-2 p-0 d-flex flex-column justify-content-center text-center">Annuler ou valider</div>
        </div>
    </div>
</div>

<!-- list of reservations -->
