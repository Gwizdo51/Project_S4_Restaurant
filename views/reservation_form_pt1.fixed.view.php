<!-- page content -->
<main id="page-content" class="bg-body-tertiary rounded mt-3 pt-3 d-flex flex-column flex-grow-1">

<!-- client name -->
<div class="row mx-3 mb-3">
    <div class="container">
        <div class="row align-items-center">
            <label class="col-3 py-0 col-form-label col-form-label-lg" for="inputName">Nom du client</label>
            <div class="col-8">
                <input type="text" class="form-control form-control-lg<?= $name_client_is_valid_input_class ?>" form="form" id="inputName" name="name" placeholder="Martin" value="<?= $reservation->get_input_name_client() ?>" required>
            </div>
        </div>
        <div class="row<?= $name_client_is_valid_message_class ?>">
            <div class="col-8 offset-3 pt-1">
                <div class="invalid-feedback d-inline px-3">
                    Entrez le nom du client
                </div>
            </div>
        </div>
    </div>
</div>

<!-- date and time -->
<div class="row mx-3 mb-3">
    <div class="container">
        <div class="row align-items-center">
            <label class="col-3 py-0 col-form-label col-form-label-lg" for="inputDateTime">Date et heure</label>
            <div class="col-8">
                <input type="datetime-local" class="form-control form-control-lg<?= $datetime_is_valid_input_class ?>" form="form" id="inputDateTime" name="datetime" value="<?= $reservation->get_input_datetime() ?>" required>
            </div>
        </div>
        <div class="row<?= $datetime_is_valid_message_class ?>">
            <div class="col-8 offset-3 pt-1">
                <div class="invalid-feedback d-inline px-3">
                    Entrez une date et une heure valides (impossible de faire une réservation dans le passé)
                </div>
            </div>
        </div>
    </div>
</div>

<!-- number of people -->
<div class="row mx-3 mb-3">
    <div class="container">
        <div class="row align-items-center">
            <label class="col-3 py-0 col-form-label col-form-label-lg" for="inputNumberPeople">Nombre de personnes</label>
            <div class="col-8">
                <input type="number" class="form-control form-control-lg<?= $number_people_is_valid_input_class ?>" form="form" id="inputNumberPeople" name="number_people" placeholder="2" min="1" step="1" value="<?= $reservation->get_input_number_people() ?>" required>
            </div>
        </div>
        <div class="row<?= $number_people_is_valid_message_class ?>">
            <div class="col-8 offset-3 pt-1">
                <div class="invalid-feedback d-inline px-3">
                    Entrez le nombre de personnes (nombre entier positif)
                </div>
            </div>
        </div>
    </div>
</div>

<!-- details -->
<div class="row mx-3 mb-3 align-items-center">
    <label class="col-3 py-0 col-form-label col-form-label-lg" for="inputDetails">Notes</label>
    <div class="col-8">
        <textarea class="p-3 form-control form-control-lg" form="form" id="inputDetails" name="details" rows="5" placeholder="Notes ..."><?= $reservation->get_input_details() ?></textarea>
    </div>
</div>

<!-- reserved tables -->
<div class="row mx-3 mb-3 align-items-center">
<label class="col-3 py-0 col-form-label col-form-label-lg">Tables réservées</label>
<div class="col-8">
<div class="container border rounded">
<div class="row p-2 fs-4">
