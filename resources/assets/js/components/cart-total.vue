<template>
	<ul>
		<li class="totalRow"><span class="label">Subtotal</span><span class="value">${{ subtotal }}</span></li>
		<li class="totalRow"><span class="label">Tax</span><span class="value">${{ taxBeforeTotal }}</span></li>
		<li class="totalRow final"><span class="label">Total</span><span class="value">${{ totalPrice }}</span></li>
		<li class="totalRow"><a href="javascript:void(0)" class="checkout" @click="orderViaChat">Order via chat</a></li>
	</ul>
</template>

<script>
export default {
	props: [ 'subtotal' ],

	data() {
		return {
			quantity: 1,
			tax: 0.13
		}
	},			

	methods: {
		orderViaChat() {
			// console.log("orderViaChat");

			this.$emit('appliedorderviachat', {
				subtotal: this.subtotal,
				tax: this.taxBeforeTotal,
				total: this.totalPrice,
			});
		}
	},

	computed: {
		taxBeforeTotal() {
			return (this.subtotal * this.tax).toFixed(2);
		},

		totalPrice() {
			return ((this.subtotal * 1) + (this.taxBeforeTotal * 1)).toFixed(2);
		}

	}
}
</script>

<style>

.totalRow {
	padding: .5rem;
	text-align: right;
}
.totalRow.final {
	font-size: 1.25rem;
	font-weight: 600;
}
.totalRow span {
	display: inline-block;
	padding: 0 0 0 1rem;
	text-align: right;
}
.totalRow .label {
	font-family: "Montserrat", sans-serif;
	font-size: .85rem;
	text-transform: uppercase;
	color: #777;
	width: 100px;
}
.totalRow .value {
	width: 100px;
}

.checkout:link, .checkout:visited {
  text-decoration: none;
  font-family: "Montserrat", sans-serif;
  font-size: 1rem;
  padding: .5rem 2rem;
  color: #fff;
  background: #82ca9c;
  font-weight: bold;
  border-radius: 50px;
  float: right;
  text-align: right;
  -webkit-transition: all 0.25s linear;
  -moz-transition: all 0.25s linear;
  -ms-transition: all 0.25s linear;
  -o-transition: all 0.25s linear;
  transition: all 0.25s linear;
}
.checkout:after {
  content: "\276f";
  padding: .5rem;
  position: relative;
  right: 0;
  -webkit-transition: all 0.15s linear;
  -moz-transition: all 0.15s linear;
  -ms-transition: all 0.15s linear;
  -o-transition: all 0.15s linear;
  transition: all 0.15s linear;
}
.checkout:hover, .checkout:focus, .checkout:active {
  background: #f69679;
}
.checkout:hover:after, .checkout:focus:after, .checkout:active:after {
  right: -10px;
}

</style>