<template>
  <div>
    <div class="flex justify-between items-center bg-gray-900 py-6 px-16">
      <div class="">
        <a
          href="/"
          class="font-bold font-serif text-lg text-white tracking-widest"
        >
          Matsu Sushi
        </a>
      </div>
      <div class="text-white px-8 flex">
        <div class="flex space-x-6">
          <div
            class="text-md hover:text-gray-400 font-medium"
            :class="isUrl('') ? 'border-b-2 pb-1' : null"
          >
            <a href="/">Home</a>
          </div>
          <div
            class="text-md hover:text-gray-400 font-medium"
            :class="isUrl('menu') ? 'border-b-2 pb-1' : null"
          >
            <a href="/menu">Menu</a>
          </div>
          <div
            class="text-md hover:text-gray-400 font-medium"
            :class="isUrl('order') ? 'border-b-2 pb-1' : null"
          >
            <a href="/order">Order</a>
          </div>
          <div
            class="text-md hover:text-gray-400 font-medium"
            :class="isUrl('gallery') ? 'border-b-2 pb-1' : null"
          >
            <a href="/gallery">Gallery</a>
          </div>
          <div
            class="text-md hover:text-gray-400 font-medium"
            :class="isUrl('contact') ? 'border-b-2 pb-1' : null"
          >
            <a href="/contact">Contact</a>
          </div>
          <div
            class="text-md hover:text-gray-400 font-medium"
            :class="isUrl('cart') ? 'border-b-2 pb-1' : null"
          >
            <a href="/cart">Cart</a>
          </div>
        </div>
        <a href="/cart" class="relative ml-2">
          <icon
            class="w-4 h-4 fill-white focus:fill-gray-400 hover:fill-gray-400"
            name="shopping-cart"
          />
          <span
            class="absolute bg-gray-500 bottom-2 flex h-5 items-center justify-center rounded-full text-white w-5 text-sm"
            :class="count > 0 ? 'flex' : 'hidden'"
            :style="{ bottom: '16px', right: '-13px' }"
          >
            <span v-if="count < 10">{{ count }}</span>
            <span v-else>+</span>
          </span>
        </a>
      </div>
    </div>
    <slot />
  </div>
</template>

<script>
import { isUrl } from '@/Utils/Helpers'

export default {
  props: {
    title: String,
  },
  data() {
    return {
      count: 0,
    }
  },
  mounted() {
    document.title = this.title + ' | Matsu Sushi'
    let orders = localStorage.getItem('orders')

    if (orders) {
      this.count = JSON.parse(orders).length
    }

    events.$on('orders', data => this.cart(data))
  },
  methods: {
    isUrl,
    updatePageTitle(title) {
      document.title = title
        ? `${title} | ${this.$page.app.name}`
        : this.$page.app.name
    },
    cart(data) {
      this.count = data.count
    },
  },
}
</script>
