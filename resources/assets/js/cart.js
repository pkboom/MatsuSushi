cartCounter = () => {
	let cookieValue = JSON.parse(getCookie("ordersInCart"));
	// update cart badges
	if (document.getElementById('cart-badge')) {
		cookieValue ? document.getElementById("cart-badge").textContent = cookieValue.length : "";
	}
}

