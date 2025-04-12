<!doctype html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Commandes cuisine</title>
    <!-- 🔹 Bootstrap CSS -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <main class="container-xxl">
        <!-- <h1>Hello world !</h1> -->

        <div class="row">

            <!-- side navigation bar -->
            <div class="col-2 vh-100 sticky-top overflow-y-auto p-3 bg-body-tertiary">
                <div class="fs-4 px-3">Navigation</div>
                <hr>
                <ul class="nav nav-pills flex-column">
                    <li>
                        <a href="#" class="nav-link link-body-emphasis" aria-current="page">
                            Accueil
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link link-body-emphasis">
                            Bar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link active">
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
                    <hr />
                </header>

                <!-- page content -->
                <div class="container-xxl bg-body-tertiary px-3 pt-3 mb-3 rounded d-flex flex-column">

                    <!-- an order -->
                    <div class="row border border-success rounded m-0 mb-3 bg-body">
                        <div class="col-5 p-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-end w-75">Numéro commande :</td>
                                        <th class="">41</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Numéro table :</td>
                                        <th class="">4</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Commande passée il y a :</td>
                                        <th class="text-success-emphasis">16 min</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-5 border-start border-end border-success p-3">
                            <dl class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <dt>Entrecôte</dt>
                                    <dd>Cuisson : Saignant</dd>
                                </div>
                                <div class="list-group-item">
                                    <dt>Salade verte</dt>
                                </div>
                            </ul>
                        </div>
                        <div class="col-2 p-3 d-grid">
                            <button type="button" class="btn btn-primary">Prête</button>
                        </div>
                    </div>

                    <!-- an order -->
                    <div class="row border border-warning rounded m-0 mb-3 bg-body">
                        <div class="col-5 p-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-end w-75">Numéro commande :</td>
                                        <th class="">42</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Numéro table :</td>
                                        <th class="">16</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Commande passée il y a :</td>
                                        <th class="text-warning-emphasis">22 min</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-5 border-start border-end border-warning p-3">
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
                            </ul>
                        </div>
                        <div class="col-2 p-3 d-grid">
                            <button type="button" class="btn btn-primary">Prête</button>
                        </div>
                    </div>

                    <!-- an order -->
                    <div class="row border border-danger rounded m-0 mb-3 bg-body">
                        <div class="col-5 p-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-end w-75">Numéro commande :</td>
                                        <th class="">43</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Numéro table :</td>
                                        <th class="">8</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Commande passée il y a :</td>
                                        <th class="text-danger-emphasis">34 min</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-5 border-start border-end border-danger p-3">
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
                            </ul>
                        </div>
                        <div class="col-2 p-3 d-grid">
                            <button type="button" class="btn btn-primary">Prête</button>
                        </div>
                    </div>

                    <!-- an order -->
                    <div class="row border border-success rounded m-0 mb-3 bg-body">
                        <div class="col-5 p-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-end w-75">Numéro commande :</td>
                                        <th class="">41</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Numéro table :</td>
                                        <th class="">4</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Commande passée il y a :</td>
                                        <th class="text-success-emphasis">16 min</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-5 border-start border-end border-success p-3">
                            <dl class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <dt>Entrecôte</dt>
                                    <dd>Cuisson : Saignant</dd>
                                </div>
                                <div class="list-group-item">
                                    <dt>Salade verte</dt>
                                </div>
                            </ul>
                        </div>
                        <div class="col-2 p-3 d-grid">
                            <button type="button" class="btn btn-primary">Prête</button>
                        </div>
                    </div>

                    <!-- an order -->
                    <div class="row border border-warning rounded m-0 mb-3 bg-body">
                        <div class="col-5 p-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-end w-75">Numéro commande :</td>
                                        <th class="">42</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Numéro table :</td>
                                        <th class="">16</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Commande passée il y a :</td>
                                        <th class="text-warning-emphasis">22 min</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-5 border-start border-end border-warning p-3">
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
                            </ul>
                        </div>
                        <div class="col-2 p-3 d-grid">
                            <button type="button" class="btn btn-primary">Prête</button>
                        </div>
                    </div>

                    <!-- an order -->
                    <div class="row border border-danger rounded m-0 mb-3 bg-body">
                        <div class="col-5 p-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-end w-75">Numéro commande :</td>
                                        <th class="">43</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Numéro table :</td>
                                        <th class="">8</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Commande passée il y a :</td>
                                        <th class="text-danger-emphasis">34 min</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-5 border-start border-end border-danger p-3">
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
                            </ul>
                        </div>
                        <div class="col-2 p-3 d-grid">
                            <button type="button" class="btn btn-primary">Prête</button>
                        </div>
                    </div>

                    <!-- an order -->
                    <div class="row border border-success rounded m-0 mb-3 bg-body">
                        <div class="col-5 p-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-end w-75">Numéro commande :</td>
                                        <th class="">41</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Numéro table :</td>
                                        <th class="">4</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Commande passée il y a :</td>
                                        <th class="text-success-emphasis">16 min</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-5 border-start border-end border-success p-3">
                            <dl class="list-group list-group-flush">
                                <div class="list-group-item">
                                    <dt>Entrecôte</dt>
                                    <dd>Cuisson : Saignant</dd>
                                </div>
                                <div class="list-group-item">
                                    <dt>Salade verte</dt>
                                </div>
                            </ul>
                        </div>
                        <div class="col-2 p-3 d-grid">
                            <button type="button" class="btn btn-primary">Prête</button>
                        </div>
                    </div>

                    <!-- an order -->
                    <div class="row border border-warning rounded m-0 mb-3 bg-body">
                        <div class="col-5 p-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-end w-75">Numéro commande :</td>
                                        <th class="">42</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Numéro table :</td>
                                        <th class="">16</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Commande passée il y a :</td>
                                        <th class="text-warning-emphasis">22 min</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-5 border-start border-end border-warning p-3">
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
                            </ul>
                        </div>
                        <div class="col-2 p-3 d-grid">
                            <button type="button" class="btn btn-primary">Prête</button>
                        </div>
                    </div>

                    <!-- an order -->
                    <div class="row border border-danger rounded m-0 mb-3 bg-body">
                        <div class="col-5 p-3">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-end w-75">Numéro commande :</td>
                                        <th class="">43</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Numéro table :</td>
                                        <th class="">8</th>
                                    </tr>
                                    <tr>
                                        <td class="text-end">Commande passée il y a :</td>
                                        <th class="text-danger-emphasis">34 min</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-5 border-start border-end border-danger p-3">
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
                            </ul>
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
