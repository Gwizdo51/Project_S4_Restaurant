<div class="reservation row border border-<?= $border_color ?> border-2 rounded mb-3 mx-3 bg-body fs-5" data-reservation-id="<?= $reservation_id ?>" style="transition: 0.1s;">
    <a href="/fixe/reservations/<?= $reservation_id ?>" class="reservation-details col-10 p-0 link-underline link-underline-opacity-0 text-body text-center">
        <div class="row m-0">
            <div class="col-4 p-3 d-flex flex-column justify-content-center<?= $date_text_color ?>">
                <?= $date_time ?>
            </div>
            <div class="col-4 p-3 border-start border-end border-<?= $border_color ?> border-2 d-flex flex-column justify-content-center">
                <?= $client_name ?>
            </div>
            <div class="col-2 p-3 border-end border-<?= $border_color ?> border-2 d-flex flex-column justify-content-center">
                <?= $number_people ?>
            </div>
            <div class="col-2 p-3 border-end border-<?= $border_color ?> border-2 d-flex flex-column justify-content-center">
                <?= $tables_reserved ?>
            </div>
        </div>
    </a>
    <div class="col-2 p-3 d-grid">
        <button type="button" class="btn btn-outline-primary d-flex flex-column justify-content-center fs-4" data-bs-toggle="modal"
         data-bs-target="#confirmation-modal-cancel" onclick="reservationElementToDelete = this.parentElement.parentElement;">X</button>
    </div>
</div>
