<div class="col-12 fs-5 p-2">
    <div class="sector row bg-body border border-secondary border-2 rounded m-0" style="transition: 0.1s;">
        <a href="/fixe/configuration/secteurs/<?= $sector_id ?>" class="col-10 p-0 link-underline link-underline-opacity-0 text-body text-center d-flex flex-column">
            <div class="row m-0 flex-grow-1">
                <div class="col-6 p-3 d-flex flex-column justify-content-center">
                    <?= $sector_name ?>
                </div>
                <div class="col-6 p-3 border-start border-end border-secondary border-2 d-flex flex-column justify-content-center">
                    <?= $tables_assigned ?>
                </div>
            </div>
        </a>
        <div class="col-2 p-3 d-grid">
            <button type="button" class="btn btn-outline-danger fs-4" data-bs-toggle="modal"
            data-bs-target="#confirmationModal" onclick="onDeleteSectorClick(<?= $sector_id ?>);">X</button>
        </div>
    </div>
</div>
