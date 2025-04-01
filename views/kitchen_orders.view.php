<h2>Liste des commandes à préparer en cuisine :</h2>

<ul id="list-orders">

    <li class="order-list-item">
        <p>Commande : <b>4</b></p>
        <p>Numero de table : <b>16</b></p>
        <p class="temps">Commande passée il y a : <b>3</b> minutes</p>
        <p>Items :
            <ul class="list-items">
                <li class="item-list-items">
                    <p><b>1</b> Entrecôte</p>
                    <p>Cuisson : Saignant</p>
                </li>
                <li class="item-list-items">
                    <p><b>2</b> Salade verte</p>
                </li>
            </ul>
        </p>
        <!-- <p><form method="POST"><input type="submit" name="18" value="Commande prête"></form></p> -->
        <button order-id="18" onclick="onReadyButtonClick(this)">Commande prête</button>
    </li>

</ul>

<script>
    "use strict";

    console.log("hello world!");

    /* pseudocode :
    on page load :
        request the list of all orders to prepare in the kitchen (API)
        display the list
    every 5 seconds :
        request the list of all orders to prepare in the kitchen (API)
        update the displayed list if it changed
    on "order ready" button click :
        disable the button (to indicate the command is being processed)
        set the related order to "ready" (API)
        on response, remove the order from the list
     */

    // load all orders on page load
    const xhttp_first_load = new XMLHttpRequest();
    xhttp_first_load.open("GET", "/api/get/kitchen-orders", true);
    xhttp_first_load.send();
    xhttp_first_load.onreadystatechange = function () {
        // console.log(this.readyState);
        // console.log(this.status);
        if (this.readyState === 4 && this.status === 200) {
            const json_response = JSON.parse(this.responseText);
            console.log(json_response);
            console.log(json_response[1].date_creation);
            console.log(Object.keys(json_response));
        }
    };

    // set an order to "ready" state
    function onReadyButtonClick(o) {
        console.log(o);
        console.log(o.getAttribute("order-id"));
        console.log(o.parentElement);
        o.parentElement.remove();
        // ...
    }
</script>
