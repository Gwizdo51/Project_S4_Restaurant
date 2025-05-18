</div>
</main>

<!-- controls -->
<div class="row rounded justify-content-center px-3 pb-3 pe-none invisible">
    <div class="col-sm-4 col-8 bg-body-tertiary border border-secondary rounded d-grid pe-auto">
        <div class="row p-2 d-grid">
            <div class="col-12 p-0 d-grid">
                <input type="submit" class="btn btn-control btn-danger fs-5 p-0 m-2" form="form" name="back" value="Retour">
            </div>
        </div>
    </div>
</div>
<div class="row rounded position-fixed w-100 bottom-0 justify-content-center px-3 pb-3 pe-none">
    <div class="col-sm-4 col-8 bg-body-tertiary border border-secondary rounded d-grid pe-auto">
        <div class="row p-2 d-grid">
            <div class="col-12 p-0 d-grid">
                <input type="submit" class="btn btn-control btn-danger fs-5 p-0 m-2" form="form" name="back" value="Retour">
            </div>
        </div>
    </div>
</div>

</div>

<form id="form" method="POST"></form>

<!-- 🔹 Bootstrap JS -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>

<script>
    "use strict";

    const form = document.forms[0];

    function onProductClick(indexProduct) {
        form.innerHTML = `<input class="d-none" name="${indexProduct}" value="">`;
        form.submit();
    }
</script>

</body>
</html>
