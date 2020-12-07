<template>
  <front-layout title="Order">
    <div
      class="flex flex-col items-start max-w-5xl md:flex-row md:py-12 mx-auto py-4 w-full"
    >
      <div
        class="leading-tight md:px-8 md:w-1/3 px-4 space-y-7 text-sm tracking-wide w-full"
      >
        <div class="flex space-x-2 md:space-x-0">
          <div class="block md:hidden w-1/2">
            <select-input
              v-model="category_id"
              :error="$page.errors.first('category')"
            >
              <option :value="null" />
              <option
                v-for="category in categories"
                :key="category.id"
                :value="category.id"
              >
                {{ category.name }}
              </option>
            </select-input>
          </div>
          <div class="w-1/2 md:w-full ">
            <input
              v-model="searchItem"
              type="text"
              placeholder="Search in menu"
              class="form-input"
            />
          </div>
        </div>
        <div
          v-for="category in categories"
          :key="category.id"
          class="hidden md:block"
        >
          <div
            class="cursor-pointer uppercase"
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
              {{ searchItem ? 'Results' : currentCategory.name }}
            </div>
            <hr class="border-b border-gray-400 border-t py-2px" />
          </div>
        </div>
        <div
          v-if="searchItem"
          class="gap-4 grid grid-cols-1 sm:grid-cols-2 md:p-8 p-4"
        >
          <div
            v-for="item in searchResult"
            :key="item.id"
            class="grid grid-cols-1 gap-2 border border-gray-400 rounded px-4 py-6 hover:cursor-pointer hover:shadow-md"
            @click="place(item)"
          >
            <div
              class="text-gray-700 text-xl text-center uppercase tracking-wide"
            >
              {{ item.name }}
            </div>
            <div
              class="text-gray-400 text-md text-center leading-snug font-serif"
            >
              {{ item.description }}
            </div>
            <div class="font-sans self-end text-center text-gray-600 text-md">
              $ {{ item.price }}
            </div>
          </div>
        </div>
        <div
          v-else-if="searchCategory"
          class="gap-4 grid grid-cols-1 sm:grid-cols-2 md:p-8 p-4"
        >
          <div
            v-for="item in searchCategory.items"
            :key="item.id"
            class="grid grid-cols-1 gap-2 border border-gray-400 rounded px-4 py-6 hover:cursor-pointer hover:shadow-md"
            @click="place(item)"
          >
            <div
              class="text-gray-700 text-lg md:text-xl text-center uppercase tracking-wide"
            >
              {{ item.name }}
            </div>
            <div
              class="text-gray-400 text-md text-center leading-snug font-serif"
            >
              {{ item.description }}
            </div>
            <div class="font-sans self-end text-center text-gray-600 text-md">
              $ {{ item.price }}
            </div>
          </div>
        </div>
        <div v-else class="gap-4 grid grid-cols-1 sm:grid-cols-2 md:p-8 p-4">
          <div
            v-for="item in currentCategory.items"
            :key="item.id"
            class="grid grid-cols-1 gap-2 border border-gray-400 rounded px-4 py-6 hover:cursor-pointer hover:shadow-md"
            @click="place(item)"
          >
            <div
              class="text-gray-700 text-lg md:text-xl text-center uppercase tracking-wide"
            >
              {{ item.name }}
            </div>
            <div
              class="text-gray-400 text-md text-center leading-snug font-serif"
            >
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
    popularMenu: String,
    categories: Array,
  },
  data() {
    return {
      currentCategory: this.categories[0],
      category_id: null,
      searchCategory: null,
      searchItem: null,
      searchResult: null,
      menu: this.categories
        .filter(
          category =>
            category.name.toLowerCase() !== this.popularMenu.toLowerCase(),
        )
        .map(category => category.items)
        .flat(),
    }
  },
  watch: {
    searchItem() {
      if (this.searchItem) {
        var fuse = new Fuse(this.menu, {
          keys: ['name'],
          includeScore: true,
          tokenize: true,
        })

        this.searchResult = fuse
          .search(this.searchItem)
          .filter(result => result.score < 0.5)
          .map(result => result.item)

        this.category_id = null
      }
    },
    category_id() {
      if (this.category_id) {
        this.searchCategory = this.categories.find(
          category => category.id === this.category_id,
        )

        this.searchItem = null
      }
    },
  },
  methods: {
    select(categoryId) {
      this.currentCategory = this.categories.find(
        category => category.id === categoryId,
      )

      this.searchItem = null
    },
    place(order) {
      let items = []

      if (localStorage.getItem('items')) {
        items = JSON.parse(localStorage.getItem('items'))
      }

      items.push(order)

      localStorage.setItem('items', JSON.stringify(items))

      this.$page.countInCart = items.length

      this.$page.flash = {
        success: `'${order.name}' added(${items.length})<br /><a href="/cart" class="underline">Go to Cart</a>`,
        ttl: 13,
      }
    },
  },
}
</script>
