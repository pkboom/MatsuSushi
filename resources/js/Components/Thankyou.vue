<template>
  <front-layout title="Thank you">
    <div class="mt-8 p-8 max-w-2xl mx-auto space-y-4 rounded bg-gray-100">
      <div class="text-xl border-b-2 border-gray-400">
        Thank you!
      </div>
      <div>You will receive an email receipt shortly.</div>
      <div>
        If you have any questions, call us at
        <a
          href="tel:7057609484"
          class="inline-block underline text-blue-600 font-bold"
        >
          705-760-9484
        </a>
        .
      </div>
      <div class="space-y-4">
        <div>
          <span class="text-gray-500">Order number:</span>
          {{ transaction.id }}
        </div>
        <div><span class="text-gray-500">Items:</span></div>
        <div class="space-y-3">
          <div
            v-for="(item, key) in transaction.items"
            :key="'item' + key"
            class="space-y-1"
          >
            <div>{{ item.name }}</div>
            <div class="hidden sm:block text-gray-400 text-sm">
              {{ item.description }}
            </div>
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
