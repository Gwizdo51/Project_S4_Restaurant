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
<div class="row m-3 border border-secondary rounded">
    <div class="col-12">
        <div class="row p-3">
            <div class="col-5 p-0 d-grid">
                <a href="#" type="button" class="btn btn-warning py-4 fs-4">Ajouter produits avec commande</a>
            </div>
            <div class="col-3 p-0 d-grid">
                <a href="#" type="button" class="btn btn-secondary py-4 ms-3 fs-4">Modifier le total</a>
            </div>
            <div class="col-4 p-0 d-grid">
                <div class="border border-info-subtle rounded ms-3 d-flex flex-column justify-content-center align-items-center">
                    <div>Total à payer</div>
                    <strong class="total fs-2"><?= $receipt_total ?> €</strong>
                </div>
            </div>
        </div>
        <div class="row px-3 pb-3">
            <div class="col-5 p-0 d-grid">
                <a href="#" type="button" class="btn btn-warning py-4 fs-4">Ajouter produits sans commande</a>
            </div>
            <div class="col-3 p-0 d-grid">
                <a href="/fixe/bons" type="button" class="btn btn-danger py-4 ms-3 fs-4">Retour</a>
            </div>
            <div class="col-4 p-0 d-grid">
                <a href="#" type="button" class="btn btn-success py-4 ms-3 fs-4">Valider le paiement</a>
            </div>
        </div>
    </div>
</div>

</div>
<!-- end of page content -->

</div>

</div>

</main>

</body>
</html>
