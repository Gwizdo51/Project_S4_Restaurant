<!-- <tr>
    <td>1</td>
    <td>2</td>
    <td>3 €</td>
    <td>4 €</td>
</tr>
<tr>
    <td>1</td>
    <td>2</td>
    <td>3 €</td>
    <td>4 €</td>
</tr>
<tr>
    <td>1</td>
    <td>2</td>
    <td>3 €</td>
    <td>4 €</td>
</tr>
<tr>
    <td>1</td>
    <td>2</td>
    <td>3 €</td>
    <td>4 €</td>
</tr>
<tr>
    <td>1</td>
    <td>2</td>
    <td>3 €</td>
    <td>4 €</td>
</tr>
<tr>
    <td>1</td>
    <td>2</td>
    <td>3 €</td>
    <td>4 €</td>
</tr>
<tr>
    <td>1</td>
    <td>2</td>
    <td>3 €</td>
    <td>4 €</td>
</tr>
<tr>
    <td>1</td>
    <td>2</td>
    <td>3 €</td>
    <td>4 €</td>
</tr>
<tr>
    <td>1</td>
    <td>2</td>
    <td>3 €</td>
    <td>4 €</td>
</tr>
<tr>
    <td>1</td>
    <td>2</td>
    <td>3 €</td>
    <td>4 €</td>
</tr>
<tr>
    <td>1</td>
    <td>2</td>
    <td>3 €</td>
    <td>4 €</td>
</tr>
<tr>
    <td>1</td>
    <td>2</td>
    <td>3 €</td>
    <td>4 €</td>
</tr>
<tr>
    <td>1</td>
    <td>2</td>
    <td>3 €</td>
    <td>4 €</td>
</tr> -->
</tbody>
<tfoot class="table-group-divider text-secondary fs-5">
    <tr>
        <td class="text-secondary-emphasis">Remise</td>
        <td class="text-secondary-emphasis">-</td>
        <td class="text-secondary-emphasis">-</td>
        <td class="text-secondary-emphasis"><?= $discount ?> €</td>
    </tr>
</tfoot>
</table>
</div>

<!-- controls -->
<div class="row m-0 px-3 pb-3 sticky-bottom">
    <!-- <div class="col-12 bg-body-tertiary border border-secondary rounded p-2 m-0" style="max-height: 25vh"> -->
    <div class="col-12 bg-body-tertiary border border-secondary rounded p-2 m-0">
        <div class="row m-0">
            <div class="col-5 p-2 d-grid">
                <a href="/fixe/bons/<?= $id_receipt ?>/ajouter-produits-avec-commande" type="button" class="btn btn-warning fs-4 py-4 d-flex justify-content-center align-items-center<?= $disable_add_products_with_order_button ?>"><?= $add_products_with_order_button_text ?></a>
            </div>
            <div class="col-3 p-2 d-grid">
                <a href="/fixe/bons/<?= $id_receipt ?>/modifier-total" type="button" class="btn btn-secondary fs-4 py-4 d-flex justify-content-center align-items-center">Modifier le total</a>
            </div>
            <div class="col-4 p-2 d-grid">
                <div class="border border-info-subtle rounded d-flex flex-column justify-content-center align-items-center">
                    <div>Total à payer</div>
                    <strong class="total fs-2"><?= $receipt_total ?> €</strong>
                </div>
            </div>
        </div>
        <div class="row m-0">
            <div class="col-5 p-2 d-grid">
                <a href="/fixe/bons/<?= $id_receipt ?>/ajouter-produits-sans-commande" type="button" class="btn btn-warning py-4 fs-4 d-flex justify-content-center align-items-center<?= $disable_add_products_no_order_button ?>"><?= $add_products_no_order_button_text ?></a>
            </div>
            <div class="col-3 p-2 d-grid">
                <a href="/fixe/bons" type="button" class="btn btn-danger py-4 fs-4 d-flex justify-content-center align-items-center">Retour</a>
            </div>
            <div class="col-4 p-2 d-grid">
                <button type="button" class="btn btn-success py-4 fs-4 d-flex justify-content-center align-items-center" data-bs-toggle="modal" data-bs-target="#confirmation-modal">Valider le paiement</button>
            </div>
        </div>
    </div>
</div>

</main>
<!-- end of page content -->

</div>

</div>

</div>

<!-- modal to confirm a receipt has been payed -->
<div class="modal fade" id="confirmation-modal" tabindex="-1" aria-labelledby="confirmation-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmation</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0 fs-5">Valider le paiement ?</p>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 d-grid">
                            <button type="button" class="btn btn-danger py-5 fs-4" data-bs-dismiss="modal">Annuler</button>
                        </div>
                        <div class="col-6">
                            <form method="POST" class="d-grid">
                                <input type="submit" class="btn btn-success py-5 fs-4" name="confirm_payment" value="OK">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 🔹 Bootstrap JS -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>
