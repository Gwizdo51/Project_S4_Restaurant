<div class="option row bg-body border border-secondary border-2 rounded fs-5 mx-3 my-2" style="transition: 0.1s;">
    <a href="/fixe/configuration/carte/options/<?= $option_id ?>" class="col-10 p-0 link-underline link-underline-opacity-0 text-body text-center d-flex flex-column">
        <div class="row m-0 flex-grow-1">
            <div class="col-4 p-3 d-flex flex-column justify-content-center">
                <?= $option_label ?>
            </div>
            <div class="col-4 p-3 border-start border-end border-secondary border-2 d-flex flex-column justify-content-center">
                <?= $option_choice_type ?>
            </div>
            <div class="col-4 p-3 border-end border-secondary border-2 d-flex flex-column justify-content-center">
                <ul class="m-0 text-start">
                    <?= $option_choices ?>
                </ul>
            </div>
        </div>
    </a>
    <div class="col-2 p-3 d-grid">
        <button type="button" class="btn btn-outline-danger fs-4" data-bs-toggle="modal"
        data-bs-target="#confirmationModal" onclick="onDeleteOptionButtonClick(<?= $option_id ?>);">X</button>
    </div>
</div>
