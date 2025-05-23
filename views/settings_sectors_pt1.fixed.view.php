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
    <!-- <div class="col-12 fs-5 p-2" data-reservation-id="">
        <div class="sector row bg-body border border-secondary border-2 rounded m-0" style="transition: 0.1s;">
            <a href="/fixe/configuration/secteurs/1" class="col-10 p-0 link-underline link-underline-opacity-0 text-body text-center d-flex flex-column">
                <div class="row m-0 flex-grow-1">
                    <div class="col-6 p-3 d-flex flex-column justify-content-center">
                        Salle 1
                    </div>
                    <div class="col-6 p-3 border-start border-end border-secondary border-2 d-flex flex-column justify-content-center">
                        1, 2, 3, 4, 5
                    </div>
                </div>
            </a>
            <div class="col-2 p-3 d-grid">
                <button type="button" class="btn btn-outline-danger d-flex flex-column justify-content-center fs-4" data-bs-toggle="modal"
                data-bs-target="#confirmationModal" onclick="onDeleteSectorClick(1);">X</button>
            </div>
        </div>
    </div>
    <div class="col-12 fs-5 p-2" data-reservation-id="">
        <div class="sector row bg-body border border-secondary border-2 rounded m-0" style="transition: 0.1s;">
            <a href="/fixe/configuration/secteurs/2" class="col-10 p-0 link-underline link-underline-opacity-0 text-body text-center d-flex flex-column">
                <div class="row m-0 flex-grow-1">
                    <div class="col-6 p-3 d-flex flex-column justify-content-center">
                        Salle 2
                    </div>
                    <div class="col-6 p-3 border-start border-end border-secondary border-2 d-flex flex-column justify-content-center">
                        6, 7, 8, 9, 10
                    </div>
                </div>
            </a>
            <div class="col-2 p-3 d-grid">
                <button type="button" class="btn btn-outline-danger d-flex flex-column justify-content-center fs-4" data-bs-toggle="modal"
                data-bs-target="#confirmationModal" onclick="onDeleteSectorClick(2);">X</button>
            </div>
        </div>
    </div>
    <div class="col-12 fs-5 p-2" data-reservation-id="">
        <div class="sector row bg-body border border-secondary border-2 rounded m-0" style="transition: 0.1s;">
            <a href="/fixe/configuration/secteurs/3" class="col-10 p-0 link-underline link-underline-opacity-0 text-body text-center d-flex flex-column">
                <div class="row m-0 flex-grow-1">
                    <div class="col-6 p-3 d-flex flex-column justify-content-center">
                        Etage
                    </div>
                    <div class="col-6 p-3 border-start border-end border-secondary border-2 d-flex flex-column justify-content-center">
                        11, 12, 13, 14, 15
                    </div>
                </div>
            </a>
            <div class="col-2 p-3 d-grid">
                <button type="button" class="btn btn-outline-danger d-flex flex-column justify-content-center fs-4" data-bs-toggle="modal"
                data-bs-target="#confirmationModal" onclick="onDeleteSectorClick(3);">X</button>
            </div>
        </div>
    </div>
    <div class="col-12 fs-5 p-2" data-reservation-id="">
        <div class="sector row bg-body border border-secondary border-2 rounded m-0">
            <a href="/fixe/configuration/secteurs/4" class="col-10 p-0 link-underline link-underline-opacity-0 text-body text-center d-flex flex-column" style="transition: 0.1s;">
                <div class="row m-0 flex-grow-1">
                    <div class="col-6 p-3 d-flex flex-column justify-content-center">
                        Terrasse
                    </div>
                    <div class="col-6 p-3 border-start border-end border-secondary border-2 d-flex flex-column justify-content-center">
                        16, 17, 18, 19, 20
                    </div>
                </div>
            </a>
            <div class="col-2 p-3 d-grid">
                <button type="button" class="btn btn-outline-danger d-flex flex-column justify-content-center fs-4" data-bs-toggle="modal"
                data-bs-target="#confirmationModal" onclick="onDeleteSectorClick(4);">X</button>
            </div>
        </div>
    </div> -->
