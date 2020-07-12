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
      <div class="text-white px-8 flex space-x-6">
        <div class="text-md hover:text-gray-400 font-medium">
          <a href="/">Home</a>
        </div>
        <div class="text-md hover:text-gray-400 font-medium">
          <a href="/menu">Menu</a>
        </div>
        <div class="text-md hover:text-gray-400 font-medium">
          <a href="/order">Order</a>
        </div>
        <div class="text-md hover:text-gray-400 font-medium">
          <a href="/gallery">Gallery</a>
        </div>
        <div class="text-md hover:text-gray-400 font-medium">
          <a href="/contact">Contact</a>
        </div>
        <div class="text-md hover:text-gray-400 font-medium">
          <a href="/contact" class="relative flex">
            <span class="mr-2">Cart</span>
            <icon
              class="w-4 h-4 fill-white focus:fill-gray-400 hover:fill-gray-400"
              name="cart"
            />
            <span
              class="absolute bg-gray-500 bottom-2 flex h-5 items-center justify-center rounded-full text-sm text-white w-5"
              :class="count > 0 ? 'flex' : 'hidden'"
              :style="{ bottom: '9px', right: '-13px' }"
            >
              <span v-if="count < 10">{{ count }}</span>
              <span v-else>+</span>
            </span>
          </a>
        </div>
      </div>
    </div>
    <slot />
  </div>
</template>

<script>
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
    document.title = 'Order | Matsu Sushi'
    let orders = localStorage.getItem('orders')

    if (orders) {
      this.count = JSON.parse(orders).length
    }

    window.events.$on('cart', data => this.cart(data))
  },
  methods: {
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
