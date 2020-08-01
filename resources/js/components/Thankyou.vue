<template>
  <front-layout title="Thank you">
    <div class="mt-8 p-8 max-w-2xl mx-auto space-y-4 rounded bg-gray-100">
      <div class="text-xl border-b-2 border-gray-400">
        Thank you!
      </div>
      <div>
        Please, give us a call at
        <a href="tel:7057609484" class="underline text-blue-600 font-bold">
          705-760-9484
        </a>
        to confirm your order.
      </div>
      <div>You will receive an email for an order receipt.</div>
      <div class="space-y-4">
        <div>
          <span class="text-gray-500">Order number:</span>
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
        <div v-if="transaction.takeout_time">
          <span class="text-gray-500">Takeout time:</span>
          {{ transaction.takeout_time }}
        </div>
        <div v-if="transaction.address">
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
        <div v-if="transaction.type === 'delivery'">
          <span class="text-gray-500">Delivery fee:</span>
          $ {{ transaction.fee }}
        </div>
        <div>
          <span class="text-gray-500">Total:</span>
          $ {{ transaction.total }}
        </div>
        <div v-if="transaction.message">
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
  </front-layout>
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

    events.$emit('order-items', {
      count: 0,
    })
  },
}
</script>
