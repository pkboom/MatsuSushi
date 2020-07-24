<template>
  <front-layout title="Order">
    <div
      class="flex flex-col items-start max-w-5xl md:flex-row mx-auto py-12 w-full"
    >
      <div class="leading-tight md:w-1/3 px-8 space-y-7 text-sm tracking-wide">
        <div>
          <input
            ref="input"
            v-model="search"
            class="form-input"
            type="text"
            placeholder="Search…"
            spellcheck="false"
          />
        </div>
        <div
          v-for="category in categories"
          :key="category.id"
          class="hidden md:block"
        >
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
        <div class="hidden md:flex flex-col items-center">
          <div class="text-3xl text-gray-800 space-y-2">
            <div class="px-8 uppercase">
              {{ search ? 'Result' : currentCategory.name }}
            </div>
            <hr class="border-b border-gray-400 border-t py-2px" />
          </div>
        </div>
        <div v-if="search" class="grid grid-cols-1 gap-8 p-8">
          <div
            v-for="item in searchResult"
            :key="item.id"
            class="grid grid-cols-1 gap-2 border border-gray-300 rounded px-4 py-6 font-serif hover:cursor-pointer hover:shadow-md"
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
            <div class="font-sans self-end text-center text-gray-600 text-md">
              $ {{ item.price }}
            </div>
          </div>
        </div>
        <div v-else class="grid grid-cols-1 gap-8 p-8">
          <div
            v-for="item in categoryItems"
            :key="item.id"
            class="grid grid-cols-1 gap-2 border border-gray-300 rounded px-4 py-6 font-serif hover:cursor-pointer hover:shadow-md"
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
            <div class="font-sans self-end text-center text-gray-600 text-md">
              $ {{ item.price }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </front-layout>
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
      categoryItems: this.categories[0].items,
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

      this.categoryItems = category.items
    },
    place(order) {
      let items = []

      if (localStorage.getItem('items')) {
        items = JSON.parse(localStorage.getItem('items'))
      }

      items.push(order)

      events.$emit('order-items', {
        count: items.length,
      })

      localStorage.setItem('items', JSON.stringify(items))

      flash(order.name + ' added to cart')
    },
  },
}
</script>
