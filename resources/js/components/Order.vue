<template>
  <layout title="Order">
    <div class="flex items-start max-w-7xl mx-auto py-16">
      <div class="px-8 space-y-6 tracking-wide">
        <div class="">
          <input
            ref="input"
            v-model="search"
            class="form-input"
            type="text"
            placeholder="Search…"
            spellcheck="false"
          />
        </div>
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
              {{ search ? 'Result' : currentCategory.name }}
            </div>
            <hr class="border-b border-gray-400 border-t py-2px" />
          </div>
        </div>
        <div v-if="search" class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-12">
          <div
            v-for="item in searchResult"
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
        <div v-else class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-12">
          <div
            v-for="item in items"
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
import Fuse from 'fuse.js'

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
      items: this.categories[0].items,
      search: '',
      searchResult: null,
      menu: this.categories.map(category => category.items).flat(),
    }
  },
  watch: {
    search() {
      if (this.search) {
        var fuse = new Fuse(this.menu, {
          keys: ['name'],
          includeScore: true,
          tokenize: true,
        })

        this.searchResult = fuse
          .search(this.search)
          .filter(result => result.score < 0.5)
          .map(result => result.item)
      }
    },
  },
  mounted() {
    this.$refs.input.focus()
  },
  methods: {
    select(selected) {
      this.search = null

      let category = this.categories.find(category => category.id === selected)

      this.currentCategory.id = category.id
      this.currentCategory.name = category.name

      this.items = category.items
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
