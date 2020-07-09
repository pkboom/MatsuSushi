<template>
  <ul>
    <li class="totalRow">
      <span class="label">Subtotal</span>
      <span class="value">${{ subtotal }}</span>
    </li>
    <li class="totalRow">
      <span class="label">Tax</span>
      <span class="value">${{ taxBeforeTotal }}</span>
    </li>
    <li class="totalRow final">
      <span class="label">Total</span>
      <span class="value">${{ totalPrice }}</span>
    </li>

    <li class="totalRow">
      <a href="/cart/payment" class="checkout payment">Pay with Card</a>
    </li>
  </ul>
</template>

<script>
export default {
  props: ['subtotal'],

  data() {
    return {
      quantity: 1,
      tax: 0.13,
    }
  },

  computed: {
    taxBeforeTotal() {
      return (this.subtotal * this.tax).toFixed(2)
    },

    totalPrice() {
      return (this.subtotal * 1 + this.taxBeforeTotal * 1).toFixed(2)
    },
  },
  methods: {
    payWithCard() {
      this.$emit('paywithcard', {
        subtotal: this.subtotal,
        tax: this.taxBeforeTotal,
        total: this.totalPrice,
      })
    },
  },
}
</script>

<style>
.totalRow {
  padding: 0.5rem;
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
  font-family: 'Montserrat', sans-serif;
  font-size: 0.85rem;
  text-transform: uppercase;
  color: #777;
  width: 100px;
}
.totalRow .value {
  width: 100px;
}

.checkout:link,
.checkout:visited {
  text-decoration: none;
  font-family: 'Montserrat', sans-serif;
  font-size: 1rem;
  padding: 0.5rem 2rem;
  margin-bottom: 1rem;
  color: #fff;
  background: dodgerblue;
  font-weight: bold;
  border-radius: 5px;
  float: right;
  text-align: right;
  -webkit-transition: all 0.3s;
  -moz-transition: all 0.3s;
  -ms-transition: all 0.3s;
  -o-transition: all 0.3s;
  transition: all 0.3s;
}

.checkout:hover,
.checkout:focus,
.checkout:active {
  background: #0066cc;
}

.payment:link,
.payment:visited {
  background: tomato;
}

.payment:hover,
.payment:focus,
.payment:active {
  background: #e62200;
}
</style>
