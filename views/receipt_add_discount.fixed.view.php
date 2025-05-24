<!-- page content -->
<main id="page-content" class="bg-body-tertiary rounded mt-3 pt-2 d-flex flex-column flex-grow-1">

    <!-- discount form -->
    <div class="row my-2 mx-0 align-items-center">
        <div class="col-2 offset-4 fs-5">
            <div class="row pb-2">
                <div class="form-check">
                    <input class="form-check-input" form="form" id="radioRemove" type="radio" name="addOrRemove" value="remove" checked>
                    <label class="form-check-label" for="radioRemove">
                        Enlever
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="form-check">
                    <input class="form-check-input" form="form" id="radioAdd" type="radio" name="addOrRemove" value="add">
                    <label class="form-check-label" for="radioAdd">
                        Ajouter
                    </label>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="input-group input-group-lg">
                <input type="number" class="form-control" form="form" name="amount" placeholder="00.00" min="0" step=".01" required>
                <span class="input-group-text">€</span>
            </div>
        </div>
    </div>

    <!-- controls -->
    <div class="row mx-3 pb-3 pt-2 mt-auto justify-content-center pe-none">
        <div class="col-6 p-0 bg-body-tertiary border border-secondary rounded pe-auto">
            <div class="row m-2">
                <div class="col-6 p-2 d-grid">
                    <a href="/fixe/bons/<?= $id_receipt ?>" type="button" class="btn btn-danger btn-control-big fs-4 d-flex justify-content-center align-items-center">Annuler</a>
                </div>
                <div class="col-6 p-2 d-grid">
                    <button type="submit" form="form" class="btn btn-success btn-control-big fs-4 d-flex justify-content-center align-items-center">Valider</button>
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
