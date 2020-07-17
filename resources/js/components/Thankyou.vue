<template>
  <layout title="Thank you">
    <div class="mt-8 p-8 max-w-2xl mx-auto space-y-4 rounded bg-gray-100">
      <div class="text-xl border-b-2 border-gray-400">
        Thank you!
      </div>
      <div>
        Your order has been placed. Please check your email for order receipt.
      </div>
      <div class="space-y-4">
        <div>
          <span class="text-gray-500">Order Number:</span>
          {{ transaction.id }}
        </div>
        <div>
          <span class="text-gray-500">Name:</span>
          {{ transaction.name }}
        </div>
        <div>
          <span class="text-gray-500">Phone:</span>
          {{ transaction.phone }}
        </div>
        <div>
          <span class="text-gray-500">Address:</span>
          {{ transaction.address }}
        </div>
        <div>
          <span class="text-gray-500">Subtotal:</span>
          $ {{ transaction.subtotal }}
        </div>
        <div>
          <span class="text-gray-500">Tax:</span>
          $ {{ transaction.tax }}
        </div>
        <div>
          <span class="text-gray-500">Tip:</span>
          $ {{ transaction.tip }}
        </div>
        <div>
          <span class="text-gray-500">Total:</span>
          $ {{ transaction.total }}
        </div>
        <div>
          <span class="text-gray-500">Message:</span>
          {{ transaction.message }}
        </div>
        <div><span class="text-gray-500">Items:</span></div>
        <div class="space-y-3">
          <div
            v-for="(item, key) in transaction.items"
            :key="'item' + key"
            class="space-y-1"
          >
            <div>{{ item.name }}</div>
            <div class="text-gray-400 text-sm">{{ item.description }}</div>
          </div>
        </div>
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
    localStorage.removeItem('total')
    localStorage.removeItem('tip')
    localStorage.removeItem('subtotal')
    localStorage.removeItem('tax')
    localStorage.removeItem('items')

    if (this.transaction.new) {
      events.$emit('order-items', {
        count: 0,
      })
    }
  },
  methods: {},
}
</script>
