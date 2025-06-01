</div>

<!-- controls -->
<div class="row mx-3 pb-3 pt-2 mt-auto sticky-bottom justify-content-center pe-none">
    <div class="col-6 p-0 bg-body-tertiary border border-secondary rounded pe-auto">
        <div class="row m-2">
            <div class="col-6 p-2 d-grid">
                <a href="/fixe/configuration" type="button" class="btn btn-danger btn-control-big fs-4 d-flex justify-content-center align-items-center">Retour</a>
            </div>
            <div class="col-6 p-2 d-grid">
                <a href="/fixe/configuration/secteurs/nouveau-secteur" role="button" class="btn btn-primary btn-control-big p-0 fs-4 d-flex justify-content-center align-items-center">
                    <img src="/assets/img/plus.svg" alt="plus icon" class="mh-3rem">
                </a>
            </div>
        </div>
    </div>
</div>

</main>
<!-- end of page content -->

<!-- confirmation modal -->
<div id="confirmationModal" class="modal fade" tabindex="-1" aria-labelledby="confirmationModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmation</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modalTextContent" class="mb-0 fs-5">Supprimer le secteur ?</p>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 d-grid">
                            <button type="button" class="btn btn-danger py-5 fs-4" data-bs-dismiss="modal">Annuler</button>
                        </div>
                        <div class="col-6 d-grid">
                            <button id="confirmModalButton" type="submit" class="btn btn-success py-5 fs-4" form="deleteSectorForm" name="deleteSector" value="2">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="POST" id="updateTableNumberForm" name="updateTableNumberForm"></form>
<form method="POST" id="deleteSectorForm"></form>

</div>

</div>

</div>

<!-- 🔹 Bootstrap JS -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>

<script>
    "use strict";

    const confirmModalButton = document.querySelector("#confirmModalButton");
    const modalTextContent = document.querySelector("#modalTextContent");
    const inputNumberTables = document.querySelector("#inputNumberTables");

    function onChangeNumberTablesClick(originalNumber) {
        // if the number of tables would not change ...
        if (inputNumberTables.value == originalNumber) {
            // stop here
            return;
        }
        confirmModalButton.setAttribute("form", "updateTableNumberForm");
        confirmModalButton.setAttribute("name", "updateTableNumber");
        confirmModalButton.setAttribute("value", "");
        if (document.forms.updateTableNumberForm.reportValidity()) {
            modalTextContent.textContent = "Mettre à jour le nombre de tables ?";
            // show the modal
            (new bootstrap.Modal("#confirmationModal")).show();
        }
    }

    function onDeleteSectorClick(sectorId) {
        confirmModalButton.setAttribute("form", "deleteSectorForm");
        confirmModalButton.setAttribute("name", "deleteSector");
        confirmModalButton.setAttribute("value", sectorId);
        modalTextContent.textContent = "Supprimer le secteur ?";
    }

    // change the color of the background of the sectors on mouse hover
    document.querySelectorAll(".hoverable").forEach((sectorElement) => {
        sectorElement.addEventListener("mouseenter", (event) => {
            sectorElement.classList.remove("bg-body");
            sectorElement.classList.add("bg-secondary-subtle");
        });
        sectorElement.addEventListener("mouseleave", (event) => {
            sectorElement.classList.add("bg-body");
            sectorElement.classList.remove("bg-secondary-subtle");
        });
    });
</script>

</body>
</html>
