<template>
  <layout title="Order">
    <div class="flex items-start max-w-7xl mx-auto py-16">
      <div class="px-8 space-y-6 tracking-wide">
        <div v-for="category in categories" :key="category.id">
          <div
            class="cursor-pointer"
            :class="currentCategory.id === category.id ? 'underline' : null"
            @click="select(category.id)"
          >
            {{ category.name }}
          </div>
        </div>
      </div>
      <div class="w-full">
        <div class="flex flex-col items-center">
          <div class="text-3xl text-gray-800 space-y-2">
            <div class="px-8 uppercase">
              {{ currentCategory.name }}
            </div>
            <hr class="border-b border-gray-400 border-t py-2px" />
          </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-12">
          <div
            v-for="item in menu"
            :key="item.id"
            class="grid grid-cols-1 gap-2 border rounded px-4 py-6 font-serif hover:cursor-pointer hover:shadow-md"
            @click="place(item)"
          >
            <div
              class="text-gray-700 text-xl text-center uppercase tracking-wide"
            >
              {{ item.name }}
            </div>
            <div class="text-gray-400 text-md text-center leading-snug">
              {{ item.description }}
            </div>
            <div class="text-gray600 text-lg text-center self-end">
              $ {{ item.price }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
export default {
  props: {
    categories: Array,
  },
  data() {
    return {
      currentCategory: {
        id: this.categories[0].id,
        name: this.categories[0].name,
      },
      menu: this.categories[0].menu,
    }
  },
  methods: {
    select(menu) {
      let category = this.categories.find(category => category.id === menu)

      this.currentCategory.id = category.id
      this.currentCategory.name = category.name

      this.menu = category.menu
    },
    place(order) {
      let orders = []

      if (localStorage.getItem('orders')) {
        orders = JSON.parse(localStorage.getItem('orders'))
      }

      orders.push(order)

      events.$emit('orders', {
        count: orders.length,
      })

      localStorage.setItem('orders', JSON.stringify(orders))

      flash(order.name + ' added to cart')
    },
  },
}
</script>
