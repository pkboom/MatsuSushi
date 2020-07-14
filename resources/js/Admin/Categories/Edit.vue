<template>
  <admin-layout :title="form.name">
    <div class="mb-8">
      <breadcrumb
        :previous-url="$route('admin.categories')"
        previous-name="Category"
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
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia
        .put(
          this.$route('admin.categories.update', this.category.id),
          this.form
        )
        .then(() => (this.sending = false))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this category?')) {
        this.$inertia.delete(
          this.$route('admin.categories.destroy', this.category.id)
        )
      }
    },
  },
}
</script>
