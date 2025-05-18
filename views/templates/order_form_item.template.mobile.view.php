<div class="col-12 p-0 text-start">
    <div class="row bg-body-secondary border border-secondary border-2 rounded mx-3 my-2">
        <div class="col-4 py-3 d-flex flex-column justify-content-center">
            <?= $product_label ?>
        </div>
        <div class="col-sm-5 col-8 py-3 d-flex flex-column justify-content-center border-start border-secondary border-2">
            <?= $details ?>
        </div>
        <div class="col-sm-3 p-3 d-grid border-up border-sm-up-0 border-sm-left border-secondary border-2">
            <button type="button" class="btn btn-control btn-danger fs-4" data-bs-toggle="modal" data-bs-target="#confirmationModal" onclick="onDeleteItemButtonClick(<?= $item_index ?>);">X</button>
        </div>
    </div>
</div>
