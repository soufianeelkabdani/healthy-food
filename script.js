function calculateTotal() {
    var quantityInput = document.getElementById("quantity-input");
    var quantity = parseInt(quantityInput.value);
    var prix = parseInt(quantityInput.getAttribute("data-prix"));
    var totalAmount = document.getElementById("total-amount");

    if (isNaN(quantity) || quantity === 0) {
        totalAmount.textContent = "Remplir le nombre de réservations";
    } else {
        var totalPrice = quantity * prix;
        totalAmount.textContent = "Montant total: " + totalPrice + " DH";
    }
}

function confirmReservation(Id_nourriture) {
    var quantityInput = document.getElementById("quantity-input");
    var quantity = parseInt(quantityInput.value);
    var prix = parseInt(quantityInput.getAttribute("data-prix"));
    var totalPrice = quantity * prix;

    $.ajax({
        url: "includes/envoie-rese.inc.php",
        method: "POST",
        data: {
            quantity: quantity,
            totalPrice: totalPrice,
            foodId: Id_nourriture
        },
        success: function(response) {
            console.log(response);
            // Masquer le modal
            $('#reservationModal' + Id_nourriture).modal('hide');

            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
            document.getElementById('total-amount').textContent = "";
            document.getElementById('quantity-input').textContent = 0;
            document.location.href = "status.php"
        },                    
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}