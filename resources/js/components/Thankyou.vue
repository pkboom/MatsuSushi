<template>
  <layout title="Thank you">
    <div class="p-8 max-w-3xl mx-auto">
      <div class="font-semibold text-xl py-4 border-b">
        Thank you, your order has been placed. Please check your email for order
        receipt.
        <div>Order Number: {{ transaction.id }}</div>
      </div>
    </div>
  </layout>
</template>

<script>
export default {
  props: {
    transaction: Object,
  },
  data() {
    return {
      sending: false,
    }
  },
  mounted() {
    localStorage.removeItem('orders')
    localStorage.removeItem('subtotal')
    localStorage.removeItem('tax')
    localStorage.removeItem('tipPercentage')
    localStorage.removeItem('tip')
    localStorage.removeItem('total')

    events.$emit('orders', {
      count: 0,
    })
  },
  methods: {},
}
</script>
