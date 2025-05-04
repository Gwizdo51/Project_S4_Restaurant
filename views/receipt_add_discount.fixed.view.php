<!-- page content -->
<div id="page-content" class="bg-body-tertiary rounded mt-3">

    <form method="POST" class="d-flex flex-column">

        <!-- discount form -->
        <div class="row m-3 align-items-center">
            <div class="col-2 offset-4 fs-5">
                <div class="row pb-2">
                    <div class="form-check">
                        <input class="form-check-input" id="radioRemove" type="radio" name="addOrRemove" value="remove" checked>
                        <label class="form-check-label" for="radioRemove">
                            Enlever
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-check">
                        <input class="form-check-input" id="radioAdd" type="radio" name="addOrRemove" value="add">
                        <label class="form-check-label" for="radioAdd">
                            Ajouter
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="input-group input-group-lg">
                    <input type="number" class="form-control" name="amount" placeholder="00.00" min="0" step=".01" required>
                    <span class="input-group-text">€</span>
                </div>
            </div>
        </div>

        <!-- controls -->
        <div class="row m-3 justify-content-center">
            <div class="col-3 p-0 d-grid">
                <a href="/fixe/bons/<?= $id_receipt ?>" type="button" class="btn btn-danger me-2 d-flex justify-content-center align-items-center fs-4 py-4">Annuler</a>
            </div>
            <div class="col-3 p-0 d-grid">
                <button type="submit" class="btn btn-success ms-2 d-flex justify-content-center align-items-center fs-4 py-4">Valider</button>
            </div>
        </div>

    </form>

</div>
<!-- end of page content -->

</div>

</div>

</main>

<!-- 🔹 Bootstrap JS -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>
