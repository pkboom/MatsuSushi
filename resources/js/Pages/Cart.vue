<template>
  <front-layout title="Cart">
    <div class="max-w-3xl md:px-16 mx-auto p-8 px-4 w-full">
      <div class="font-semibold text-xl py-4 border-b">
        Order Summary
      </div>
      <div class="bg-white rounded overflow-x-auto border-b">
        <table class="w-full">
          <tr v-for="(item, key) in itemsWithCount" :key="key">
            <td class="py-4">
              <div class="whitespace-no-wrap">
                {{ item.item.name }}
                <span v-if="item.count > 1" class="ml-2">
                  &times; {{ item.count }}
                </span>
                <button
                  class="underline text-matsu-blue-600 text-xs ml-2"
                  @click="destroy(item.item)"
                >
                  delete
                </button>
              </div>
              <div class="text-xs text-gray-400 mt-2">
                {{ item.item.description }}
              </div>
            </td>
            <td class="py-4 whitespace-no-wrap text-right">
              $ {{ itemSubTotal(item) }}
            </td>
          </tr>
          <tr
            v-if="subtotal > promotion.over100.value && promotion.over100.name"
          >
            <td class="py-4" colspan="2">
              <div class="whitespace-no-wrap">
                {{ promotion.over100.name }}
              </div>
              <div class="text-xs text-gray-400 mt-2">
                Free item
              </div>
            </td>
          </tr>
          <tr
            v-else-if="
              subtotal > promotion.over50.value && promotion.over50.name
            "
          >
            <td class="py-4" colspan="2">
              <div class="whitespace-no-wrap">
                {{ promotion.over50.name }}
              </div>
              <div class="text-xs text-gray-400 mt-2">
                Free item
              </div>
            </td>
          </tr>
          <tr
            v-else-if="
              subtotal > promotion.over20.value && promotion.over20.name
            "
          >
            <td class="py-4" colspan="2">
              <div class="whitespace-no-wrap">
                {{ promotion.over20.name }}
              </div>
              <div class="text-xs text-gray-400 mt-2">
                Free item
              </div>
            </td>
          </tr>
        </table>
      </div>
      <div class="flex flex-col items-end py-4 space-y-4">
        <div>
          <span class="text-gray-500">Subtotal:</span>
          $ {{ subtotal }}
        </div>
        <div class="flex items-center space-x-4">
          <span class="italic whitespace-no-wrap">
            Tip:
          </span>
          <select v-model="tip_percentage" class="w-full form-select py-0.5">
            <option value="0" />
            <option value="0.05">5%</option>
            <option value="0.10">10%</option>
            <option value="0.15">15%</option>
            <option value="0.20">20%</option>
            <option value="0.25">25%</option>
            <option value="0.30">30%</option>
          </select>
          <span class="whitespace-no-wrap">$ {{ tip }}</span>
        </div>
        <div>
          <span class="text-gray-500">GST/HST:</span>
          $ {{ tax }}
        </div>
        <div>
          <span class="text-gray-500">Total:</span>
          <span class="text-gray-800 font-bold">$ {{ total }}</span>
        </div>
        <div>
          <span class="text-gray-500">(Delivery fee:</span>
          $ {{ fee }})
        </div>
        <div class="leading-5">
          &#10003;
          <span class="underline">Additional fee</span>
          may be added depending on the delivery address.
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
  props: {
    fee: Number,
    promotion: Object,
  },
  data() {
    return {
      items: null,
      itemsWithCount: null,
      subtotal: null,
      tax: null,
      tip_percentage: localStorage.getItem('tip_percentage') ?? 0,
      tip: null,
      total: null,
    }
  },
  watch: {
    tip_percentage() {
      this.storeTipPercentageInLocalStorage()

      this.calculate()
    },
  },
  mounted() {
    if (localStorage.getItem('items')) {
      this.items = JSON.parse(localStorage.getItem('items'))
    }

    this.calculate()
  },
  methods: {
    storeTipPercentageInLocalStorage() {
      localStorage.setItem('tip_percentage', this.tip_percentage)
    },
    itemSubTotal(item) {
      return (Number(item.item.price) * item.count).toFixed(2)
    },
    calculate() {
      this.itemsWithCount = this.groupItems()

      this.subtotal = this.getSubtotal()

      this.tax = (Number(this.subtotal) * 0.13).toFixed(2)

      this.tip = (this.subtotal * this.tip_percentage).toFixed(2)

      this.total = (
        Number(this.subtotal) +
        Number(this.tip) +
        Number(this.tax)
      ).toFixed(2)
    },
    groupItems() {
      return Object.values(
        _.groupBy(this.items, item => item.name + item.description),
      )
        .map(group => ({
          count: group.length,
          item: group[0],
        }))
        .sort((a, b) => a.item.name.localeCompare(b.item.name))
    },
    getSubtotal() {
      return this.items && this.items.length > 0
        ? this.items
            .map(order => Number(order.price))
            .reduce((total, price) => total + price, 0)
            .toFixed(2)
        : '0.00'
    },
    destroy(item) {
      this.items.splice(
        this.items.findIndex(value => value.id === item.id),
        1,
      )

      localStorage.setItem('items', JSON.stringify(this.items))

      this.$page.countInCart = this.items.length

      this.calculate()
    },
    confirm() {
      if (this.subtotal >= 1) {
        this.$inertia.get(this.$route('start-your-order.create'))
      }
    },
  },
}
</script>
