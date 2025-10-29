// Payment selection
const paymentImages = document.querySelectorAll('.payment-options img');
paymentImages.forEach(img => {
  img.addEventListener('click', () => {
    // Remove highlight from all
    paymentImages.forEach(i => i.style.border = 'none');
    // Highlight selected
    img.style.border = '3px solid #0d1530';
  });
});

// Place Order button
const placeOrderBtn = document.querySelector('.order-summary button');
placeOrderBtn.addEventListener('click', () => {
  const selectedPayment = document.querySelector('.payment-options img[style*="border"]');
  if (!selectedPayment) {
    alert('Please select a payment method.');
  } else {
    alert('Order placed successfully!');
  }
});