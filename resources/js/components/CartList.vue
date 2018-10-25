<template>
	<ul class="cartWrap">
		<cartitem v-for="(item, index) in orders" :key="index" :name="item.name" :price="item.price" :quantity="item.quantity" :count="index" @appliedremove="onRemoveOrder" @appliedquantity="onQuantityChanged"></cartitem>
	</ul>
</template>

<script>
import cartitem from './CartItem.vue';

export default {
	props: [ 'orders' ],

	components: {
		cartitem
	},

	methods: {
		onRemoveOrder(count) {
            this.$emit('appliedremove', {
            	count: count.count,
            });
		},

		onQuantityChanged(item) {
            this.$emit('appliedquantity', {
            	count: item.count,
            	quantity: item.quantity,
            });
		}
   }
}
</script>

<style>

.menu-title {
	text-transform: uppercase;
}

.menu-description {
	text-transform: lowercase;
}

.order-button {
	border-radius: 4px !important;
	background-clip: padding-box !important;
	border: 1px solid #cecece !important;
	color: black !important;
	padding: .3rem .5rem;
	text-decoration: none !important;
}

</style>