<template>
  <back-layout title="Item">
    <div class="mb-8">
      <breadcrumb name="Item" />
    </div>
    <div class="mb-6 flex justify-between items-center">
      <search-filter
        v-model="form.search"
        class="w-full max-w-xl mr-4"
        @reset="reset"
      >
        <label class="block text-gray-800">Category:</label>
        <select v-model="form.category" class="mt-1 w-full form-select">
          <option :value="null" />
          <option
            v-for="category in categories"
            :key="category.id"
            :value="category.id"
          >
            {{ category.name }}
          </option>
        </select>
      </search-filter>
      <inertia-link class="btn" :href="$route('admin.items.create')">
        <span>Create</span>
        <span class="hidden md:inline">Item</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full">
        <tr>
          <th
            class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap"
            colspan="2"
          >
            Name
          </th>
        </tr>
        <tr
          v-for="item in items.data"
          :key="item.id"
          class="hover:bg-gray-100 focus:bg-gray-100 cursor-pointer"
          @click="$inertia.visit($route('admin.items.edit', item.id))"
        >
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            {{ item.name }}
          </td>
          <td class="border-t px-4 align-middle w-min">
            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
          </td>
        </tr>
        <tr v-if="items.data.length === 0">
          <td class="border-t px-6 py-4" colspan="5">No items found.</td>
        </tr>
      </table>
    </div>
    <pagination :links="items.links" />
  </back-layout>
</template>

<script>
export default {
  props: {
    filters: Object,
    items: Object,
    categories: Array,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        category: this.filters.category,
      },
    }
  },
  watch: {
    form: {
      handler: _.throttle(function() {
        let query = _.pickBy(this.form)

        let url = this.$route(
          'admin.items',
          Object.keys(query).length ? query : { remember: 'forget' }
        )
        this.$inertia.replace(url)
      }, 300),
      deep: true,
    },
  },
  methods: {
    reset() {
      this.form = _.mapValues(this.form, () => null)
    },
  },
}
</script>
