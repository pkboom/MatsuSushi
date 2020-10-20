<template>
  <admin-layout title="Categories">
    <div class="mb-8">
      <breadcrumb name="Categories" />
    </div>
    <div class="mb-6 flex justify-between items-center">
      <search-filter
        v-model="form.search"
        class="w-full max-w-lg mr-4"
        :filter-show="false"
        @reset="reset"
      />
      <inertia-link class="btn" :href="$route('admin.categories.create')">
        <span>Create</span>
        <span class="hidden md:inline">Category</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded shadow overflow-x-auto">
      <table class="w-full">
        <tr>
          <th class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap">
            Name
          </th>
          <th
            class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap"
            colspan="2"
          >
            Priority
          </th>
        </tr>
        <tr
          v-for="category in categories.data"
          :key="category.id"
          class="hover:bg-gray-100 focus:bg-gray-100 cursor-pointer"
          @click="$inertia.visit($route('admin.categories.edit', category.id))"
        >
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            {{ category.name }}
          </td>
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            {{ category.priority }}
          </td>
          <td class="border-t px-4 align-middle w-min">
            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
          </td>
        </tr>
        <tr v-if="categories.data.length === 0">
          <td class="border-t px-6 py-4" colspan="3">No categories found.</td>
        </tr>
      </table>
    </div>
    <pagination :links="categories.links" />
  </admin-layout>
</template>

<script>
export default {
  props: {
    categories: Object,
    filters: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
      },
    }
  },
  watch: {
    form: {
      handler: _.throttle(function() {
        let query = _.pickBy(this.form)

        let url = this.$route(
          'admin.categories',
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
