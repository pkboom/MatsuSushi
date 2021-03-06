<template>
  <admin-layout :title="form.name">
    <div class="mb-8">
      <breadcrumb
        :previous-url="$route('admin.categories')"
        previous-name="Categories"
        :name="form.name"
      />
    </div>
    <div class="bg-white max-w-2xl overflow-hidden rounded shadow">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <div class="pr-6 pb-8 w-full">
            <text-input
              v-model="form.name"
              :error="$page.errors.first('name')"
              label="Name"
            />
          </div>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <div class="flex justify-between">
              <label class="form-label" for="priority">Priority:</label>
              <div class="text-gray-600 text-sm">
                <span>Highest: 999</span>
                <span class="ml-2">
                  Lowest: 1
                </span>
              </div>
            </div>
            <text-input
              id="priority"
              v-model="form.priority"
              :error="$page.errors.first('priority')"
              type="number"
            />
          </div>
        </div>
        <div
          class="px-8 py-4 bg-gray-100 border-t border-gray-100 flex justify-between items-center"
        >
          <div class="flex items-baseline">
            <button
              class="text-red-500 hover:underline"
              tabindex="-1"
              type="button"
              @click="destroy"
            >
              Delete Category
            </button>
          </div>
          <div>
            <loading-button :loading="sending" class="btn ml-3" type="submit">
              Update Category
            </loading-button>
          </div>
        </div>
      </form>
    </div>
    <div class="flex justify-between items-end mt-12 ">
      <h2 class="text-lg">Items</h2>
      <inertia-link
        :href="$route('admin.items.create', { category: category.id })"
        class="btn"
      >
        Create Item
      </inertia-link>
    </div>
    <div class="mt-6 bg-white rounded shadow overflow-x-auto">
      <table class="w-full">
        <tr>
          <th class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap">
            name
          </th>
          <th class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap">
            Price
          </th>
          <th
            class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap"
            colspan="2"
          >
            Description
          </th>
        </tr>
        <tr
          v-for="(item, key) in category.items"
          :key="'item' + key"
          class="hover:bg-gray-100 focus:bg-gray-100 cursor-pointer"
          @click="$inertia.visit($route('admin.items.edit', item.id))"
        >
          <td class="border-t px-6 py-4 whitespace-no-wrap">{{ item.name }}</td>
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            $ {{ item.price }}
          </td>
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            {{ item.description }}
          </td>
          <td class="border-t px-4 align-middle w-min">
            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
          </td>
        </tr>
        <tr v-if="category.items.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No items found.</td>
        </tr>
      </table>
    </div>
  </admin-layout>
</template>

<script>
export default {
  props: {
    category: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: this.category.name,
        priority: this.category.priority,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.put(
        this.$route('admin.categories.update', this.category.id),
        this.form,
        { onFinish: () => (this.sending = false) },
      )
    },
    destroy() {
      this.$inertia.delete(
        this.$route('admin.categories.destroy', this.category.id),
        {
          onStart: () =>
            confirm(
              'Are you sure you want to delete this category?\nItems of this category will be deleted, too.',
            ),
        },
      )
    },
  },
}
</script>
