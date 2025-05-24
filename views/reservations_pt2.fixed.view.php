<!-- controls -->
<div class="row pb-3 mx-3 mt-auto sticky-bottom justify-content-center pe-none">
    <div class="col-4 bg-body-tertiary border border-secondary rounded p-3 d-grid pe-auto">
        <a href="/fixe/reservations/nouvelle-reservation" type="button" class="btn btn-secondary fs-4 py-4">Ajouter une réservation</a>
    </div>
</div>

<!-- confirmation modal to cancel the reservation -->
<div class="modal fade" id="confirmation-modal-cancel" tabindex="-1" aria-labelledby="confirmation-modal-cancel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmation</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0 fs-5">Effacer la réservation ?</p>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 d-grid">
                            <button type="button" class="btn btn-danger py-5 fs-4" data-bs-dismiss="modal">Annuler</button>
                        </div>
                        <div class="col-6 d-grid">
                            <button type="button" class="btn btn-success py-5 fs-4" data-bs-dismiss="modal" onclick="onModalConfirmButtonClick();">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</main>
<!-- end of page content -->

</div>

</div>

</div>

<!-- 🔹 Bootstrap JS -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>

<script>
    "use strict";

    /* pseudocode :
    on delete button click :
        remember the ID of the parent reservation
        open the confirmation modal
        if OK button clicked :
            disable every reservation delete buttons
            close the modal
            cancel the reservation at /api/cancel-reservation
            if success :
                remove the reservation from the displayed list
            enable every reservation delete buttons
    */

    let reservationElementToDelete = null;

    async function onModalConfirmButtonClick() {
        // disable every reservation delete buttons
        const deleteButtonsList = document.querySelectorAll("div.reservation button");
        deleteButtonsList.forEach((button) => {
            button.setAttribute("disabled", "");
        });
        // make a FormData object to send to the API via POST
        const formData = new FormData();
        formData.append("reservation_id", reservationElementToDelete.dataset.reservationId);
        const response = await fetch("/api/cancel-reservation", {
            method: "POST",
            body: formData
        });
        if (response.ok) {
            const JSONResponse = await response.json();
            if (JSONResponse.success) {
                // remove the reservation from the list
                reservationElementToDelete.remove();
                // if there are no reservations displayed ...
                if (document.querySelectorAll("div.reservation").length === 0) {
                    // display the "no reservations" message
                    document.querySelector("#no-reservations-message").classList.remove("d-none");
                    // hide the columns descriptions
                    document.querySelector("#columns-description").classList.add("d-none");
                }
            }
            else {
                alert("Une erreur est survenue lors du traitement de la requête");
            }
        }
        else {
            alert("Une erreur est survenue lors de l'envoi de la requête");
        }
        // enable every reservation delete buttons
        deleteButtonsList.forEach((button) => {
            button.removeAttribute("disabled");
        });
    }

    // change the color of the background of the reservations on mouse hover
    document.querySelectorAll("div.reservation").forEach((reservationElement) => {
        reservationElement.addEventListener("mouseenter", (event) => {
            reservationElement.classList.remove("bg-body");
            reservationElement.classList.add("bg-secondary-subtle");
        });
        reservationElement.addEventListener("mouseleave", (event) => {
            reservationElement.classList.add("bg-body");
            reservationElement.classList.remove("bg-secondary-subtle");
        });
    });
</script>

</body>
</html>
