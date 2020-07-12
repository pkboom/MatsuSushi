<template>
  <layout title="Cart">
    <div class="p-8 max-w-3xl mx-auto">
      <div class="font-semibold text-xl py-4 border-b">
        Order Summary
      </div>
      <div class="bg-white rounded overflow-x-auto border-b">
        <table class="w-full">
          <tr v-for="(order, key) in orders" :key="key">
            <td class="py-4 whitespace-no-wrap">
              <div>
                {{ order.name }}
                <button
                  class="underline text-blue-600 text-xs ml-2"
                  @click="destroy(key)"
                >
                  delete
                </button>
              </div>
              <div class="text-xs text-gray-400 mt-2">
                {{ order.description }}
              </div>
            </td>
            <td class="py-4 whitespace-no-wrap text-right">
              $ {{ order.price }}
            </td>
          </tr>
        </table>
      </div>
      <div class="flex justify-end py-4">
        <div class="flex items-center">
          <span class="mr-2 whitespace-no-wrap">Tip Percentage:</span>
          <select v-model="tipPercentage" class="mt-1 w-full form-select py-1">
            <option value="0" />
            <option value="0.05">5%</option>
            <option value="0.10">10%</option>
            <option value="0.15">15%</option>
            <option value="0.20">20%</option>
            <option value="0.25">25%</option>
            <option value="0.30">30%</option>
          </select>
        </div>
      </div>
      <div class="flex flex-col items-end py-4 space-y-4">
        <div>
          <span class="text-gray-500">Subtotal:</span>
          $ {{ subtotal }}
        </div>
        <div>
          <span class="text-gray-500">GST/HST:</span>
          $ {{ tax }}
        </div>
        <div>
          <span class="text-gray-500">Tip:</span>
          $ {{ tip }}
        </div>
        <div>
          <span class="text-gray-500">Total:</span>
          <span class="text-red-600 font-bold">$ {{ total }}</span>
        </div>
      </div>
      <div class="flex justify-end mt-2">
        <a href="/checkout" class="btn">Confirm Order</a>
      </div>
    </div>
  </layout>
</template>

<script>
export default {
  data() {
    return {
      orders: null,
      subtotal: null,
      tax: null,
      tipPercentage: null,
      tip: 0,
      total: null,
    }
  },
  watch: {
    tipPercentage() {
      this.calculate()
    },
    orders() {
      this.calculate()
    },
  },
  mounted() {
    if (localStorage.getItem('orders')) {
      this.orders = JSON.parse(localStorage.getItem('orders'))
    }

    this.calculate()
  },
  methods: {
    calculate() {
      this.subtotal = this.orders
        .map(order => Number(order.price))
        .reduce((total, price) => total + price, 0)
        .toFixed(2)

      this.tax = (Number(this.subtotal) * 0.13).toFixed(2)

      this.tip = (this.subtotal * this.tipPercentage).toFixed(2)

      this.total = (
        Number(this.subtotal) +
        Number(this.tip) +
        Number(this.tax)
      ).toFixed(2)
    },
    destroy(selected) {
      this.orders = this.orders.filter((order, key) => key !== selected)

      localStorage.setItem('orders', JSON.stringify(this.orders))

      events.$emit('orders', {
        count: this.orders.length,
      })
    },
  },
}
</script>
