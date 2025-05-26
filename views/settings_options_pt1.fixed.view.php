<!-- page content -->
<main id="pageContent" class="bg-body-tertiary rounded mt-3 pt-2 px-0 d-flex flex-column flex-grow-1">

    <!-- display a message when there are no options to display -->
    <div class="row fs-4 justify-content-center my-2 text-secondary<?= $display_no_options_message ?>">
        Aucune option de commande enregistrée.
    </div>

    <!-- columns descriptions -->
    <div class="row border border-2 align-items-center text-center text-secondary mx-3<?= $display_columns_descriptions ?>" style="border-color: #0000 !important;">
        <div class="col-10">
            <div class="row">
                <div class="col-4 p-0">Titre</div>
                <div class="col-4 p-0">Type de choix</div>
                <div class="col-4 p-0">Choix possibles</div>
            </div>
        </div>
        <div class="col-2 p-0">Supprimer l'option de commande</div>
    </div>

    <!-- list of options -->
