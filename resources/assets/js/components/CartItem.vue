<template>
	<li class="cartItem"  :class="{ 'even': count % 2 }">
		<div class="row"> 
			<div class="cartSection col-8">
				<h3>{{ name }}</h3>
				<p> <input type="text" class="inputQuantity" @change="onQuantityChanged" v-model.number="newQuantity"> x ${{ price }}</p>
			</div>  
			<div class="cartSection prodTotal col-3">
				<p>${{ itemPrice }}</p>
			</div>
			<div class="cartSection removeWrap col-1">
				<a href="javascript:void(0)" class="remove" @click="onRemoveOrder">x</a>
			</div>
		</div>
	</li>
</template>

<script>
export default {
	props: [ 'name', 'price', 'quantity', 'count' ],

	data() {
		return {
			newQuantity: 0
		}
	},

	created() {
		this.newQuantity = this.quantity;
	},

	methods: {
		onRemoveOrder() {
			this.$emit('appliedremove', {
				count: this.count,
			});			
		},

		onQuantityChanged() {
			this.$emit('appliedquantity', {
				quantity: this.newQuantity,
				count: this.count,
			});			
		}
	},

	computed: {
		itemPrice() {
			return (this.quantity * this.price).toFixed(2);
		}

	}
}
</script>

<style>

.cartItem {
	display: block;
	width: 100%;
	vertical-align: middle;
	padding: 1.5em;
	border-bottom: 1px solid #fafafa;
}
.even {
	background: #fafafa;
}

.cartSection {
	vertical-align: middle;
}

.cartSection h3 {
	font-size: 1em;
	font-family: "Montserrat", sans-serif;
	font-weight: bold;
	text-transform: uppercase;
	letter-spacing: .025em;
}
.cartSection p {
	display: inline-block;
	font-size: .85em;
	color: #777777;
	font-family: "Montserrat", sans-serif;
}

.prodTotal {
	text-align: center;
}
.prodTotal p {
	font-weight: 500;
	font-size: 1.25em;
}
.inputQuantity {
	width: 2em;
	text-align: center;
	font-size: 1em;
	padding: .25em;
	margin: 1em .5em 0 0;
}


</style>