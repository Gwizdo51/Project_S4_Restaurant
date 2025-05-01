<!-- <div class="row border border-secondary border-2 rounded m-0 mb-3 bg-body">
    <div class="col-3 p-3 d-flex flex-column justify-content-center align-items-center">
        <div>Bon n°</div>
        <strong class="fs-2">15</strong>
    </div>
    <div class="col-3 p-3 border-start border-end border-secondary border-2 d-flex flex-column justify-content-center align-items-center">
        <div>Table n°</div>
        <strong class="fs-2">8</strong>
    </div>
    <div class="col-4 p-3 border-end border-secondary border-2 d-flex flex-column justify-content-center align-items-center">
        <div>Total</div>
        <strong class="total fs-2">33,40 €</strong>
    </div>
    <div class="col-2 p-3 d-grid">
        <a href="/fixe/bons/123" type="button" class="btn btn-primary py-5">Détails</a>
    </div>
</div> -->

</div>
<!-- end of page content -->

</div>

</div>

</main>

<script>
    "use strict";

    /* pseudocode :
    every 5 seconds :
        request the list of all current receipts
        if the list is empty :
            remove all displayed receipts
            display the "no receipts" message
        else :
            hide the "no receipts" message
            for each displayed receipt :
                if the receipt is not in the received list :
                    remove it
                else :
                    update its total
            for each received receipt, if it is not in the list of displayed receipts, display it
    */

    function generateReceiptElement(receiptID, JSONResponse) {
        // get the receipt with the specified ID from the JSON
        const currentReceipt = JSONResponse[receiptID];
        // clone the content from the receipt template
        const receiptElement = document.querySelector("#template-receipt").content.cloneNode(true);
        const mainDiv = receiptElement.querySelector("div.row");
        // add the order ID
        mainDiv.dataset.receiptId = receiptID;
        mainDiv.querySelector("strong.receipt-id").textContent = receiptID;
        mainDiv.querySelector("a.btn").href = `/fixe/bons/${receiptID}`;
        // add the table number
        mainDiv.querySelector("strong.table-id").textContent = currentReceipt.numero_table;
        // add the total
        mainDiv.querySelector("strong.total").textContent = `${currentReceipt.total} €`;
        return receiptElement;
    }

    function updateDisplayedReceipts(JSONResponse) {
        const receiptsContainer = document.querySelector("#page-content");
        const noReceiptsMessageDiv = receiptsContainer.querySelector("#no-receipts-message");
        // get the list of all receipts displayed on the page
        const displayedReceiptsList = receiptsContainer.querySelectorAll("div.row");
        // if the list of receipts to prepare is empty ...
        if (Object.keys(JSONResponse).length === 0) {
            // remove all displayed receipts
            displayedReceiptsList.forEach((value) => {
                value.remove();
            })
            // display the "no receipts" message
            noReceiptsMessageDiv.classList.remove("d-none");
        }
        else {
            // hide the "no receipts" message
            noReceiptsMessageDiv.classList.add("d-none");
            const displayedReceiptsIDList = [];
            // for each receipt displayed ...
            displayedReceiptsList.forEach((displayedReceipt) => {
                let displayedReceiptID = displayedReceipt.dataset.receiptId;
                // if the receipt is not in the JSON response ...
                if (!Object.keys(JSONResponse).includes(displayedReceiptID)) {
                    // remove it from the document
                    displayedReceipt.remove();
                }
                else {
                    // update its total
                    displayedReceipt.querySelector("strong.total").textContent = `${JSONResponse[displayedReceiptID].total} €`;
                    // add it to the list of displayed receipts IDs
                    displayedReceiptsIDList.push(displayedReceiptID);
                }
            });
            // for each receipt in the JSON response ...
            for (let receiptID in JSONResponse) {
                // if the receipt is not displayed, display it
                if (!displayedReceiptsIDList.includes(receiptID)) {
                    receiptsContainer.append(generateReceiptElement(receiptID, JSONResponse));
                }
            }
        }
    }

    async function updateReceipts() {
        const response = await fetch("/api/get-current-receipts");
        if (response.ok) {
            updateDisplayedReceipts(await response.json());
        }
    }
    setInterval(updateReceipts, 5000);
</script>

</body>
</html>
