<!-- page content -->
<main id="page-content" class="bg-body-tertiary rounded mt-3 pt-2 px-0 d-flex flex-column flex-grow-1">

<!-- sector name -->
<div class="row align-items-center m-2">
    <label class="col-3 py-0 px-2 col-form-label col-form-label-lg" for="inputName">Nom du secteur</label>
    <div class="col-9 py-0 px-2">
        <input type="text" class="form-control form-control-lg<?= $name_sector_is_valid_input_class ?>" form="form" id="inputName" name="name" placeholder="Secteur X" value="<?= $sector->get_input_name_sector() ?>" required>
    </div>
    <div class="col-9 offset-3 pt-1<?= $name_sector_is_valid_message_class ?>">
        <div class="invalid-feedback d-inline px-3">
            Le secteur doit avoir un nom
        </div>
    </div>
</div>

<!-- list of free and assigned tables -->
<div class="row align-items-center m-2">
    <label class="col-3 py-0 px-2 col-form-label col-form-label-lg">Tables assignées</label>
    <div class="col-9 py-0 px-2">
        <div class="row border rounded m-0 p-2 fs-4">

            <!-- display a message when there are no assignable table -->
            <div class="col-12 fs-4 text-center my-2 text-secondary<?= $display_no_tables_message ?>">
                Aucune table disponible.
            </div>
