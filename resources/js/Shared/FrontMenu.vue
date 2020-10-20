<template>
  <div>
    <div
      class="text-md hover:text-gray-400 font-medium"
      :class="isUrl('') ? 'border-b-2 pb-1' : null"
    >
      <inertia-link :href="$route('home')">Home</inertia-link>
    </div>
    <div
      class="text-md hover:text-gray-400 font-medium"
      :class="isUrl('menu') ? 'border-b-2 pb-1' : null"
    >
      <inertia-link :href="$route('menu')">Menu</inertia-link>
    </div>
    <div
      class="text-md hover:text-gray-400 font-medium"
      :class="isUrl('gallery') ? 'border-b-2 pb-1' : null"
    >
      <inertia-link :href="$route('gallery')">Gallery</inertia-link>
    </div>
    <div
      class="text-md hover:text-gray-400 font-medium"
      :class="isUrl('reservations*') ? 'border-b-2 pb-1' : null"
    >
      <inertia-link :href="$route('reservations.create')">
        Reservation
      </inertia-link>
    </div>
    <div
      class="text-md hover:text-gray-400 font-medium"
      :class="isUrl('order') ? 'border-b-2 pb-1' : null"
    >
      <inertia-link :href="$route('order')">
        Order
      </inertia-link>
    </div>
    <div
      class="text-md group hover:text-gray-400 font-medium"
      :class="isUrl('cart') ? 'border-b-2 pb-1' : null"
    >
      <inertia-link :href="$route('cart')" class="flex items-center">
        <span class="mr-1">Cart</span>
        <div class="relative">
          <icon
            class="w-4 h-4 fill-white group-hover:fill-gray-400 focus:fill-gray-400 hover:fill-gray-400"
            name="shopping-cart"
          />
          <span
            class="absolute bg-gray-500 bottom-2 flex h-5 items-center justify-center rounded-full text-white w-5 text-sm"
            :class="count > 0 ? 'flex' : 'hidden'"
            :style="{ bottom: '10px', right: '-13px' }"
          >
            <span v-if="count < 10">{{ count }}</span>
            <span v-else>+</span>
          </span>
        </div>
      </inertia-link>
    </div>
  </div>
</template>

<script>
import { isUrl } from '@/Utils/Helpers'

export default {
  props: {},

  data() {
    return {
      count: 0,
    }
  },
  mounted() {
    let items = localStorage.getItem('items')

    if (items) {
      this.count = JSON.parse(items).length
    }

    events.$on('order-items', data => this.cart(data))
  },
  methods: {
    isUrl,
    cart(data) {
      this.count = data.count
    },
  },
}
</script>
