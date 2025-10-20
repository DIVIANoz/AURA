const products = [
    { name: "Velle", price: 8700, quantity: 1, img: "velle.jpg" },
    { name: "Midnight Reverie", price: 7000, quantity: 2, img: "midnight.jpg" },
    { name: "Rose Alchemy", price: 7000, quantity: 2, img: "rose.jpg" },
    { name: "Celestial Oud", price: 4200, quantity: 1, img: "celestial.jpg" },
];

const cartContainer = document.getElementById("cart-container");
const totalPriceEl = document.getElementById("totalPrice");
const checkoutBtn = document.getElementById("checkoutBtn");
const selectAll = document.getElementById("selectAll");

products.forEach((product, index) => {
    const item = document.createElement("div");
    item.classList.add("cart-item");
    item.dataset.index = index;
    item.dataset.price = product.price;

    item.innerHTML = `
        <div class="item-left">
            <input type="checkbox" class="item-check">
            <img src="${product.img}" alt="${product.name}" class="product-img">
            <div class="item-details">
                <div class="item-name">${product.name}</div>
                <div class="price">₱ ${product.price.toLocaleString()}</div>
            </div>
        </div>
        <div class="item-right">
            <div class="quantity">
                <button class="minus">-</button>
                <span class="qty">${product.quantity}</span>
                <button class="plus">+</button>
            </div>
        </div>
    `;
    cartContainer.appendChild(item);
});

function updateTotal() {
    let total = 0;
    let selectedCount = 0;

    document.querySelectorAll(".cart-item").forEach(item => {
        const chk = item.querySelector(".item-check");
        const qty = parseInt(item.querySelector(".qty").textContent);
        const price = parseInt(item.dataset.price);
        if (chk.checked) {
            total += qty * price;
            selectedCount++;
        }
    });

   totalPriceEl.textContent = `₱ ${total.toLocaleString()}`;
checkoutBtn.textContent = `Check Out (${selectedCount})`;

}

document.addEventListener("click", (e) => {
    if (e.target.classList.contains("plus")) {
        const qtyEl = e.target.parentElement.querySelector(".qty");
        qtyEl.textContent = parseInt(qtyEl.textContent) + 1;
        updateTotal();
    }

    if (e.target.classList.contains("minus")) {
        const qtyEl = e.target.parentElement.querySelector(".qty");
        const current = parseInt(qtyEl.textContent);
        if (current > 1) qtyEl.textContent = current - 1;
        updateTotal();
    }
});

document.addEventListener("change", (e) => {
    if (e.target.classList.contains("item-check")) updateTotal();
    if (e.target.id === "selectAll") {
        document.querySelectorAll(".item-check").forEach(chk => chk.checked = e.target.checked);
        updateTotal();
    }
});