<template>
  <front-layout title="Cart">
    <div class="max-w-3xl md:px-16 mx-auto p-8 px-4 w-full">
      <div class="font-semibold text-xl py-4 border-b">
        Order Summary
      </div>
      <div class="bg-white rounded overflow-x-auto border-b">
        <table class="w-full">
          <tr v-for="(order, key) in items" :key="key">
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
      <div class="flex justify-end pt-4">
        <div class="flex items-center">
          <span class="mr-2 whitespace-no-wrap text-green-500">
            Tip percentage:
          </span>
          <select v-model="tip_percentage" class="w-full form-select py-1 pr-7">
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
        <button class="btn" @click="confirm">Confirm Order</button>
      </div>
    </div>
  </front-layout>
</template>

<script>
export default {
  data() {
    return {
      items: null,
      subtotal: null,
      tax: null,
      tip_percentage: localStorage.getItem('tip_percentage') ?? 0,
      tip: null,
      total: null,
    }
  },
  watch: {
    tip_percentage() {
      localStorage.setItem('tip_percentage', this.tip_percentage)

      this.calculate()
    },
  },
  mounted() {
    localStorage.setItem('tip_percentage', this.tip_percentage)

    if (localStorage.getItem('items')) {
      this.items = JSON.parse(localStorage.getItem('items')).sort(
        (a, b) => a.id - b.id
      )
    }

    this.tip_percentage = localStorage.getItem('tip_percentage')

    this.calculate()
  },
  methods: {
    calculate() {
      this.subtotal = this.items
        ? this.items
            .map(order => Number(order.price))
            .reduce((total, price) => total + price, 0)
            .toFixed(2)
        : '0.00'

      this.tax = (Number(this.subtotal) * 0.13).toFixed(2)

      this.tip = (this.subtotal * this.tip_percentage).toFixed(2)

      this.total = (
        Number(this.subtotal) +
        Number(this.tip) +
        Number(this.tax)
      ).toFixed(2)
    },
    destroy(selected) {
      this.items = this.items.filter((order, key) => key !== selected)

      localStorage.setItem('items', JSON.stringify(this.items))

      events.$emit('order-items', {
        count: this.items.length,
      })

      this.calculate()
    },
    confirm() {
      if (this.subtotal >= 1) {
        location.href = '/start/your/order'
      }
    },
  },
}
</script>
