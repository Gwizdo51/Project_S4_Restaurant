<!-- page content -->
<main id="page-content" class="bg-body-tertiary rounded mt-3 d-flex flex-column">

<h3 class="m-3 pb-1 text-center"><?= $product_label ?></h3>
<hr class="mx-3 mt-0">

<form method="POST">

<!-- details textarea -->
<div class="mb-3 text-center fs-4">Détails</div>
<!-- <div class="row mb-3 mx-3 justify-content-center">
    <div class="col-10 p-0 d-grid">
        <textarea class="p-3" name="details" rows="5" placeholder="Entrez des détails"></textarea>
    </div>
</div> -->
<div class="mb-3 mx-3 p-0 d-grid">
    <textarea class="p-3" name="details" rows="5" placeholder="Entrez des détails"></textarea>
</div>

<!-- order options -->
<div class="mb-3 text-center fs-4">Options de commande</div>

<!-- display a message when there are no order options to display -->
<div class="fs-4 text-center mb-3 text-secondary<?= $display_no_options_message ?>">Aucune option de commande.</div>

<!-- <div class="row mx-3 mb-3 border border-2 border-secondary rounded fs-5">
    <div class="col-3 p-3 border-end border-2 border-secondary d-flex align-items-center justify-content-center">Cuisson</div>
    <div class="col-9 align-self-center">
        <div class="row p-2">
            <div class="col-4 p-2">
                <div class="form-check">
                    <input class="form-check-input" id="0" type="radio" name="0" value="0" checked>
                    <label class="form-check-label" for="0">
                        Bleu
                    </label>
                </div>
            </div>
            <div class="col-4 p-2">
                <div class="form-check">
                    <input class="form-check-input" id="1" type="radio" name="0" value="1">
                    <label class="form-check-label" for="1">
                        Saignant
                    </label>
                </div>
            </div>
            <div class="col-4 p-2">
            <div class="form-check">
                    <input class="form-check-input" id="2" type="radio" name="0" value="2">
                    <label class="form-check-label" for="2">
                        bleu
                    </label>
                </div>
            </div>
            <div class="col-4 p-2">
                <div class="form-check">
                    <input class="form-check-input" id="3" type="radio" name="0" value="3">
                    <label class="form-check-label" for="3">
                        bleu
                    </label>
                </div>
            </div>
            <div class="col-4 p-2">
                <div class="form-check">
                    <input class="form-check-input" id="4" type="radio" name="0" value="4">
                    <label class="form-check-label" for="4">
                        bleu
                    </label>
                </div>
            </div>
            <div class="col-4 p-2">
            <div class="form-check">
                    <input class="form-check-input" id="5" type="radio" name="0" value="5">
                    <label class="form-check-label" for="5">
                        bleu
                    </label>
                </div>
            </div>
            <div class="col-4 p-2">
                <div class="form-check">
                    <input class="form-check-input" id="6" type="radio" name="0" value="6">
                    <label class="form-check-label" for="6">
                        bleu
                    </label>
                </div>
            </div>
            <div class="col-4 p-2">
                <div class="form-check">
                    <input class="form-check-input" id="7" type="radio" name="0" value="7">
                    <label class="form-check-label" for="7">
                        bleu
                    </label>
                </div>
            </div>
            <div class="col-4 p-2">
            <div class="form-check">
                    <input class="form-check-input" id="8" type="radio" name="0" value="8">
                    <label class="form-check-label" for="8">
                        bleu
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mx-3 mb-3 border border-2 border-secondary rounded fs-5">
    <div class="col-3 p-3 border-end border-2 border-secondary d-flex align-items-center justify-content-center">Sauces</div>
    <div class="col-9 align-self-center">
        <div class="row p-2">
            <div class="col-4 p-2">
                <div class="form-check">
                    <input class="form-check-input" id="9" type="checkbox" name="1_0" value="">
                    <label class="form-check-label" for="9">
                        Ketchup
                    </label>
                </div>
            </div>
            <div class="col-4 p-2">
                <div class="form-check">
                    <input class="form-check-input" id="10" type="checkbox" name="1_1" value="">
                    <label class="form-check-label" for="10">
                        Ketchup
                    </label>
                </div>
            </div>
            <div class="col-4 p-2">
                <div class="form-check">
                    <input class="form-check-input" id="11" type="checkbox" name="1_2" value="">
                    <label class="form-check-label" for="11">
                        Ketchup
                    </label>
                </div>
            </div>
            <div class="col-4 p-2">
                <div class="form-check">
                    <input class="form-check-input" id="12" type="checkbox" name="1_3" value="">
                    <label class="form-check-label" for="12">
                        Ketchup
                    </label>
                </div>
            </div>
            <div class="col-4 p-2">
                <div class="form-check">
                    <input class="form-check-input" id="13" type="checkbox" name="1_4" value="">
                    <label class="form-check-label" for="13">
                        Ketchup
                    </label>
                </div>
            </div>
        </div>
    </div>
</div> -->
