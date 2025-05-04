<div class="row border border-secondary border-2 rounded m-0 mb-3 bg-body" data-receipt-id="<?= $receipt_id ?>">
    <div class="col-3 p-3 d-flex flex-column justify-content-center align-items-center">
        <div>Bon n°</div>
        <strong class="receipt-id fs-2"><?= $receipt_id ?></strong>
    </div>
    <div class="col-3 p-3 border-start border-end border-secondary border-2 d-flex flex-column justify-content-center align-items-center">
        <div>Table n°</div>
        <strong class="table-id fs-2"><?= $table_id ?></strong>
    </div>
    <div class="col-4 p-3 border-end border-secondary border-2 d-flex flex-column justify-content-center align-items-center">
        <div>Total</div>
        <strong class="total fs-2"><?= $total ?> €</strong>
    </div>
    <div class="col-2 p-3 d-grid">
        <a href="/fixe/bons/<?= $receipt_id ?>" type="button" class="btn btn-primary py-5 fs-4">Détails</a>
    </div>
</div>
