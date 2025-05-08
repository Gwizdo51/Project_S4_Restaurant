</div>
<!-- end of page content -->

</div>

</div>

</main>

<!-- 🔹 Bootstrap JS -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>

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
        const mainDiv = receiptElement.firstElementChild;
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

    // update receipts
    let idTimerUpdateOrders;
    document.onreadystatechange = () => {
        // on DOM content loaded
        if (document.readyState === "interactive") {
            idTimerUpdateOrders = setInterval(updateReceipts, 5000);
        }
    };

    // disable page updates when it is not visible
    document.addEventListener("visibilitychange", () => {
        if (document.hidden) {
            // stop requesting receipts updates
            clearInterval(idTimerUpdateOrders);
        }
        else {
            // restart requesting receipts updates
            updateReceipts();
            idTimerUpdateOrders = setInterval(updateReceipts, 5000);
        }
    });
</script>

</body>
</html>
