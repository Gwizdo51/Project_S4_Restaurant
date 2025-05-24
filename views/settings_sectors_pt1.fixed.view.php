<!-- page content -->
<main id="page-content" class="bg-body-tertiary rounded mt-3 pt-2 px-0 d-flex flex-column flex-grow-1">

<!-- number of tables -->
<div class="row mx-3 my-2 p-2 justify-content-center border rounded">
    <label class="p-2 col-3 col-form-label col-form-label-lg text-center align-self-center" for="inputNumberTables">
        Nombre de tables
    </label>
    <div class="col-4 p-2 d-grid">
        <input type="number" class="form-control form-control-lg" form="updateTableNumberForm" id="inputNumberTables" name="numberTables" placeholder="20" value="<?= $original_tables_number ?>" min="0" step="1" required>
    </div>
    <div class="col-2 p-2 d-grid">
        <button class="btn btn-outline-primary fs-4" onclick="onChangeNumberTablesClick(<?= $original_tables_number ?>);">OK</button>
    </div>
</div>

<div class="row mx-3 my-2 p-2 justify-content-center border rounded d-flex flex-column">

    <!-- display a message when there are no sectors to display -->
    <div class="row fs-4 justify-content-center my-2 text-secondary<?= $display_no_sectors_message ?>">
        Aucun secteur enregistré.
    </div>

    <!-- columns descriptions -->
    <div class="col-12 justify-content-center text-secondary<?= $display_columns_descriptions ?>">
        <div class="row border border-2 align-items-center text-center m-0" style="border-color: #0000 !important;">
            <div class="col-5">Nom du secteur</div>
            <div class="col-5">Tables assignées</div>
        </div>
    </div>

    <!-- list of sectors -->
