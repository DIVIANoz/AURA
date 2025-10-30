const cartContainer = document.getElementById("cart-container");
const totalPriceEl = document.getElementById("totalPrice");
const checkoutBtn = document.getElementById("checkoutBtn");

function updateTotal() {
    let total = 0;
    let selectedCount = 0;
    document.querySelectorAll(".cart-item").forEach(item => {
        const chk = item.querySelector(".item-check");
        const qty = parseInt(item.querySelector(".qty-input").value);
        const price = parseFloat(item.dataset.price);
        if (chk.checked) {
            total += qty * price;
            selectedCount++;
        }
    });
    totalPriceEl.textContent = `₱ ${total.toLocaleString()}`;
    checkoutBtn.textContent = `Check Out (${selectedCount})`;
}

// Quantity plus/minus and input changes
cartContainer.addEventListener("input", e => {
    if (e.target.classList.contains("qty-input")) {
        if (isNaN(e.target.value) || e.target.value < 1) e.target.value = 1;
        updateTotal();
    }
});

cartContainer.addEventListener("click", e => {
    const target = e.target;

    if (target.classList.contains("plus") || target.classList.contains("minus")) {
        const input = target.parentElement.querySelector(".qty-input");
        let val = parseInt(input.value);
        if (target.classList.contains("plus")) val++;
        if (target.classList.contains("minus") && val > 1) val--;
        input.value = val;
        updateTotal();
    }

    if (target.classList.contains("remove-btn") || target.closest(".remove-btn")) {
        const btn = target.classList.contains("remove-btn") ? target : target.closest(".remove-btn");
        const cartId = btn.dataset.cartid;
        if (confirm("Remove this item?")) {
            fetch(`cart_remove.php?id=${cartId}`)
                .then(res => res.text())
                .then(() => {
                    btn.closest(".cart-item").remove();
                    updateTotal();
                });
        }
    }
});

// Checkbox selection
cartContainer.addEventListener("change", e => {
    if (e.target.classList.contains("item-check")) updateTotal();
});

updateTotal();
