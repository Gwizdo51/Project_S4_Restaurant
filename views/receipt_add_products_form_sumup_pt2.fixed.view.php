<!-- controls -->
<div class="row mb-0 mx-0 px-3 pb-3 sticky-bottom justify-content-center pe-none mt-auto">
    <div class="col-9 bg-body-tertiary border border-secondary rounded pe-auto">
        <div class="row p-3">
            <div class="col-4 p-0 d-grid">
                <button type="button" class="btn btn-danger fs-4 py-4 me-2" data-bs-toggle="modal" data-bs-target="#confirmation-modal-cancel">Annuler</button>
            </div>
            <div class="col-4 p-0 d-grid">
                <input type="submit" class="btn btn-primary fs-4 py-4 ms-2 me-2 text-wrap" form="form" name="add_product" value="Ajouter produit">
            </div>
            <div class="col-4 p-0 d-grid">
                <button type="button" class="btn btn-success fs-4 py-4 ms-2" data-bs-toggle="modal" data-bs-target="#confirmation-modal-confirm"<?= $disable_confirm_button ?>>Valider</button>
            </div>
        </div>
    </div>
</div>

<!-- confirmation modal to cancel the order -->
<div class="modal fade" id="confirmation-modal-cancel" tabindex="-1" aria-labelledby="confirmation-modal-cancel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmation</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0 fs-5">Annuler l'ajout de produits ?</p>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 d-grid">
                            <button type="button" class="btn btn-danger py-5 fs-4" data-bs-dismiss="modal">Annuler</button>
                        </div>
                        <div class="col-6 d-grid">
                            <input type="submit" class="btn btn-success py-5 fs-4" form="form" name="cancel_order" value="OK">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- confirmation modal to confirm the order -->
<div class="modal fade" id="confirmation-modal-confirm" tabindex="-1" aria-labelledby="confirmation-modal-confirm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmation</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0 fs-5">Valider l'ajout de produits ?</p>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 d-grid">
                            <button type="button" class="btn btn-danger py-5 fs-4" data-bs-dismiss="modal">Annuler</button>
                        </div>
                        <div class="col-6 d-grid">
                            <input type="submit" class="btn btn-success py-5 fs-4" form="form" name="confirm_order" value="OK">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="form" method="POST"></form>

</main>
<!-- end of page content -->

</div>

</div>

</div>

<!-- 🔹 Bootstrap JS -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>
