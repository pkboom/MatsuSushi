<template>
    <div>
        <div class="cart">
			<cart-list :orders="ordersInCart" @appliedremove="onRemoveOrder" @appliedquantity="onQuantityChanged"></cart-list>
		</div>
		<div class="subtotal cf">
			<cart-total :subtotal="subtotalInCart" @appliedorderviachat="orderViaChat"></cart-total>
		</div>
    </div>
</template>

<script>
    import CartList from './CartList.vue';
    import CartTotal from './CartTotal.vue';

    export default {
        data() {
            return {
                ordersInCart: Orders.get(), // used in cart component; list of orders
                subtotalInCart: Orders.subTotal(),
            }
        },
        
        components: {CartList, CartTotal},

		methods: {
			onRemoveOrder(count) {
				this.ordersInCart = Orders.remove(count.count);

				document.getElementById("cart-badge").textContent = Orders.count();

				this.subtotalInCart = Orders.subTotal();
			},

			onQuantityChanged(item) {
				Orders.update(item.count, item.quantity);
				
				this.subtotalInCart = Orders.subTotal();
			},

			orderViaChat(value) {
				Event.$emit('applied-order', value);
			},
		}
    }
</script>
