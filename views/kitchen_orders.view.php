<h2>Liste des commandes à préparer en cuisine :</h2>

<ul id="list-orders">

    <li class="order-list-item" order-id="4">
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
        <button onclick="onReadyButtonClick(this)">Commande prête</button>
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
    function updateOrders(jsonResponse) {
        const orderList = document.getElementById("list-orders");
        console.log(jsonResponse);
        // let newItem = document.createElement("li");
        // newItem.textContent = "LOL";
        // orderList.appendChild(newItem);
        for (let orderID in jsonResponse) {
            // console.log(orderID);
            // console.log(jsonResponse[orderID]);
            let orderItem = document.createElement("li");
            orderItem.setAttribute("class", "order-list-item");
            orderItem.setAttribute("order-id", orderID);
            let paragraph = document.createElement("p");
            paragraph.innerHTML = `Commande : <b>${orderID}</b>`;
            orderItem.appendChild(paragraph);
            console.log(orderItem);
        }
    }
    const xhttp = new XMLHttpRequest();
    xhttp.open("GET", "/api/get/kitchen-orders", true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
        // console.log(this.readyState);
        // console.log(this.status);
        if (this.readyState === 4 && this.status === 200) {
            // const jsonResponse = JSON.parse(this.responseText);
            // console.log(json_response[1].date_creation);
            // console.log(Object.keys(json_response));
            updateOrders(JSON.parse(this.responseText));
        }
    };

    // set an order to "ready" state
    function onReadyButtonClick(button) {
        console.log(button);
        console.log(button.parentElement);
        console.log(button.parentElement.getAttribute("order-id"));
        button.parentElement.remove();
        // ...
    }
</script>
