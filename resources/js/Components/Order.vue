<template>
  <front-layout title="Order">
    <div
      class="flex flex-col items-start max-w-5xl md:flex-row md:py-12 mx-auto py-4 w-full"
    >
      <div
        class="leading-tight md:px-8 md:w-1/3 px-4 space-y-7 text-sm tracking-wide w-full"
      >
        <search-input
          v-model="searchCategory"
          :data="categories"
          track-by="id"
          :search-by="['name']"
          class="block md:hidden"
        >
          <div v-if="searchCategory" class="flex items-center justify-between">
            <div class="truncate uppercase">{{ searchCategory.name }}</div>
          </div>
          <template v-slot:option="{ option }">
            <div class="flex items-center justify-between">
              <div class="uppercase">{{ option.name }}</div>
            </div>
          </template>
        </search-input>
        <div class="hidden md:block">
          <input
            v-model="searchItem"
            class="form-input"
            type="text"
            placeholder="Search in menu"
            spellcheck="false"
          />
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
        <div v-if="searchItem" class="grid grid-cols-1 gap-8 p-8">
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
        <div
          v-else-if="searchCategory"
          class="gap-4 grid grid-cols-1 md:gap-8 md:p-8 p-4"
        >
          <div
            v-for="item in searchCategory.items"
            :key="item.id"
            class="grid grid-cols-1 gap-2 border border-gray-300 rounded px-4 py-6 font-serif hover:cursor-pointer hover:shadow-md"
            @click="place(item)"
          >
            <div
              class="text-gray-700 text-lg md:text-xl text-center uppercase tracking-wide"
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
        <div v-else class="gap-4 grid grid-cols-1 md:gap-8 md:p-8 p-4">
          <div
            v-for="item in currentCategory.items"
            :key="item.id"
            class="grid grid-cols-1 gap-2 border border-gray-300 rounded px-4 py-6 font-serif hover:cursor-pointer hover:shadow-md"
            @click="place(item)"
          >
            <div
              class="text-gray-700 text-lg md:text-xl text-center uppercase tracking-wide"
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
    popular_menu: String,
  },
  data() {
    return {
      currentCategory: this.categories[0],
      searchCategory: null,
      searchItem: null,
      searchResult: null,
      menu: this.categories
        .filter(category => category.name !== this.popular_menu)
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
      }
    },
  },
  methods: {
    select(categoryId) {
      this.searchItem = ''

      this.currentCategory = this.categories.find(
        category => category.id === categoryId
      )
    },
    place(order) {
      let items = []

      if (localStorage.getItem('items')) {
        items = JSON.parse(localStorage.getItem('items'))
      }

      items.push(order)

      localStorage.setItem('items', JSON.stringify(items))

      events.$emit('order-items', {
        count: items.length,
      })

      flash(order.name + ' added to cart')
    },
  },
}
</script>
