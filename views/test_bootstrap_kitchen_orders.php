<!doctype html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cuisine</title>
    <!-- 🔹 Bootstrap CSS -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <main class="container-xxl">

        <div class="row">

            <!-- side navigation bar -->
            <div class="col-2 vh-100 sticky-top overflow-y-auto p-3 bg-body-tertiary">
                <div class="fs-4 px-3">Navigation</div>
                <hr>
                <ul class="nav nav-pills flex-column">
                    <li>
                        <a href="#" class="nav-link link-body-emphasis">
                            Accueil
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-body-emphasis">
                            Bar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link active" aria-current="page">
                            Cuisine
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-body-emphasis">
                            Bons
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-body-emphasis">
                            Réservations
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-body-emphasis">
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-body-emphasis">
                            Administration
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-10">

                <!-- page title -->
                <header class="sticky-top bg-body-tertiary mb-3">
                    <div class="text-center display-5 py-2">Commandes cuisine</div>
                    <hr>
                </header>

                <!-- confirmation modal -->
                <div class="modal fade" id="confirmation-modal" tabindex="-1" aria-labelledby="confirmation-modal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Confirmation</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="mb-0 fs-5">La commande est-elle prête ?</p>
                            </div>
                            <div class="modal-footer">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-6 d-grid">
                                            <button type="button" class="btn btn-danger py-5 fs-4" data-bs-dismiss="modal">Annuler</button>
                                        </div>
                                        <div class="col-6 d-grid">
                                            <button type="button" class="btn btn-success py-5 fs-4" data-bs-dismiss="modal">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- page content -->
                <div class="bg-body-tertiary px-3 pt-3 mb-3 rounded d-flex flex-column">

                    <!-- an order -->
                    <div class="row border border-success border-2 rounded m-0 mb-3 bg-body">
                        <div class="col-4 p-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-end w-75">Numéro commande :</td>
                                        <th>41</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Numéro table :</td>
                                        <th>4</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Commande passée il y a :</td>
                                        <th class="text-success-emphasis">16 min</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6 border-start border-end border-success border-2 p-3">
                            <dl class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <dt>Entrecôte</dt>
                                    <dd>Cuisson : Saignant</dd>
                                </div>
                                <div class="list-group-item">
                                    <dt>Salade verte</dt>
                                </div>
                            </dl>
                        </div>
                        <div class="col-2 p-3 d-grid">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmation-modal">Prête</button>
                        </div>
                    </div>

                    <!-- an order -->
                    <div class="row border border-warning border-2 rounded m-0 mb-3 bg-body">
                        <div class="col-4 p-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-end w-75">Numéro commande :</td>
                                        <th>42</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Numéro table :</td>
                                        <th>16</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Commande passée il y a :</td>
                                        <th class="text-warning-emphasis">22 min</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6 border-start border-end border-warning border-2 p-3">
                            <dl class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <dt>Entrecôte</dt>
                                    <dd>Cuisson : Saignant</dd>
                                </div>
                                <div class="list-group-item">
                                    <dt>Entrecôte</dt>
                                    <dd>Cuisson : A point</dd>
                                </div>
                                <div class="list-group-item">
                                    <dt>Flan</dt>
                                </div>
                            </dl>
                        </div>
                        <div class="col-2 p-3 d-grid">
                            <button type="button" class="btn btn-primary">Prête</button>
                        </div>
                    </div>

                    <!-- an order -->
                    <div class="row border border-danger border-2 rounded m-0 mb-3 bg-body">
                        <div class="col-4 p-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-end w-75">Numéro commande :</td>
                                        <th>43</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Numéro table :</td>
                                        <th>8</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Commande passée il y a :</td>
                                        <th class="text-danger-emphasis">34 min</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6 border-start border-end border-danger border-2 p-3">
                            <dl class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <dt>Frites</dt>
                                    <dd>Sauces : Mayonnaise, Ketchup</dd>
                                </div>
                                <div class="list-group-item">
                                    <dt>Salade verte</dt>
                                </div>
                                <div class="list-group-item">
                                    <dt>Entrecôte</dt>
                                    <dd>Cuisson : Cuit</dd>
                                </div>
                                <div class="list-group-item">
                                    <dt>Entrecôte</dt>
                                    <dd>Cuisson : Bleu</dd>
                                </div>
                            </dl>
                        </div>
                        <div class="col-2 p-3 d-grid">
                            <button type="button" class="btn btn-primary">Prête</button>
                        </div>
                    </div>

                    <!-- an order -->
                    <div class="row border border-success border-2 rounded m-0 mb-3 bg-body">
                        <div class="col-4 p-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-end w-75">Numéro commande :</td>
                                        <th>41</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Numéro table :</td>
                                        <th>4</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Commande passée il y a :</td>
                                        <th class="text-success-emphasis">16 min</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6 border-start border-end border-success border-2 p-3">
                            <dl class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <dt>Entrecôte</dt>
                                    <dd>Cuisson : Saignant</dd>
                                </div>
                                <div class="list-group-item">
                                    <dt>Salade verte</dt>
                                </div>
                            </dl>
                        </div>
                        <div class="col-2 p-3 d-grid">
                            <button type="button" class="btn btn-primary">Prête</button>
                        </div>
                    </div>

                    <!-- an order -->
                    <div class="row border border-warning border-2 rounded m-0 mb-3 bg-body">
                        <div class="col-4 p-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-end w-75">Numéro commande :</td>
                                        <th>42</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Numéro table :</td>
                                        <th>16</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Commande passée il y a :</td>
                                        <th class="text-warning-emphasis">22 min</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6 border-start border-end border-warning border-2 p-3">
                            <dl class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <dt>Entrecôte</dt>
                                    <dd>Cuisson : Saignant</dd>
                                </div>
                                <div class="list-group-item">
                                    <dt>Entrecôte</dt>
                                    <dd>Cuisson : A point</dd>
                                </div>
                                <div class="list-group-item">
                                    <dt>Flan</dt>
                                </div>
                            </dl>
                        </div>
                        <div class="col-2 p-3 d-grid">
                            <button type="button" class="btn btn-primary">Prête</button>
                        </div>
                    </div>

                    <!-- an order -->
                    <div class="row border border-danger border-2 rounded m-0 mb-3 bg-body">
                        <div class="col-4 p-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-end w-75">Numéro commande :</td>
                                        <th>43</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Numéro table :</td>
                                        <th>8</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Commande passée il y a :</td>
                                        <th class="text-danger-emphasis">34 min</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6 border-start border-end border-danger border-2 p-3">
                            <dl class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <dt>Frites</dt>
                                    <dd>Sauces : Mayonnaise, Ketchup</dd>
                                </div>
                                <div class="list-group-item">
                                    <dt>Salade verte</dt>
                                </div>
                                <div class="list-group-item">
                                    <dt>Entrecôte</dt>
                                    <dd>Cuisson : Cuit</dd>
                                </div>
                                <div class="list-group-item">
                                    <dt>Entrecôte</dt>
                                    <dd>Cuisson : Bleu</dd>
                                </div>
                            </dl>
                        </div>
                        <div class="col-2 p-3 d-grid">
                            <button type="button" class="btn btn-primary">Prête</button>
                        </div>
                    </div>

                    <!-- an order -->
                    <div class="row border border-success border-2 rounded m-0 mb-3 bg-body">
                        <div class="col-4 p-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-end w-75">Numéro commande :</td>
                                        <th>41</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Numéro table :</td>
                                        <th>4</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Commande passée il y a :</td>
                                        <th class="text-success-emphasis">16 min</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6 border-start border-end border-success border-2 p-3">
                            <dl class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <dt>Entrecôte</dt>
                                    <dd>Cuisson : Saignant</dd>
                                </div>
                                <div class="list-group-item">
                                    <dt>Salade verte</dt>
                                </div>
                            </dl>
                        </div>
                        <div class="col-2 p-3 d-grid">
                            <button type="button" class="btn btn-primary">Prête</button>
                        </div>
                    </div>

                    <!-- an order -->
                    <div class="row border border-warning border-2 rounded m-0 mb-3 bg-body">
                        <div class="col-4 p-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-end w-75">Numéro commande :</td>
                                        <th>42</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Numéro table :</td>
                                        <th>16</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Commande passée il y a :</td>
                                        <th class="text-warning-emphasis">22 min</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6 border-start border-end border-warning border-2 p-3">
                            <dl class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <dt>Entrecôte</dt>
                                    <dd>Cuisson : Saignant</dd>
                                </div>
                                <div class="list-group-item">
                                    <dt>Entrecôte</dt>
                                    <dd>Cuisson : A point</dd>
                                </div>
                                <div class="list-group-item">
                                    <dt>Flan</dt>
                                </div>
                            </dl>
                        </div>
                        <div class="col-2 p-3 d-grid">
                            <button type="button" class="btn btn-primary">Prête</button>
                        </div>
                    </div>

                    <!-- an order -->
                    <div class="row border border-danger border-2 rounded m-0 mb-3 bg-body">
                        <div class="col-4 p-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-end w-75">Numéro commande :</td>
                                        <th>43</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Numéro table :</td>
                                        <th>8</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Commande passée il y a :</td>
                                        <th class="text-danger-emphasis">34 min</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-6 border-start border-end border-danger border-2 p-3">
                            <dl class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <dt>Frites</dt>
                                    <dd>Sauces : Mayonnaise, Ketchup</dd>
                                </div>
                                <div class="list-group-item">
                                    <dt>Salade verte</dt>
                                </div>
                                <div class="list-group-item">
                                    <dt>Entrecôte</dt>
                                    <dd>Cuisson : Cuit</dd>
                                </div>
                                <div class="list-group-item">
                                    <dt>Entrecôte</dt>
                                    <dd>Cuisson : Bleu</dd>
                                </div>
                            </dl>
                        </div>
                        <div class="col-2 p-3 d-grid">
                            <button type="button" class="btn btn-primary">Prête</button>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </main>


    <!-- 🔹 Bootstrap JS -->
    <script src="./assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>
