<template>
  <layout :title="form.name">
    <div class="mb-8">
      <breadcrumb
        :previous-url="$route('categories')"
        previous-name="Category"
        :name="form.name"
      />
    </div>
    <div class="bg-white rounded shadow overflow-hidden max-w-lg">
      <form @submit.prevent="submit">
        <div class="p-8 -mb-8">
          <div class="pb-8">
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
            <loading-button
              :loading="sending"
              class="btn-blue ml-3"
              type="submit"
            >
              Update Category
            </loading-button>
          </div>
        </div>
      </form>
    </div>
  </layout>
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
        domain: this.category.domain,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia
        .put(this.$route('categories.update', this.category.id), this.form)
        .then(() => (this.sending = false))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this category?')) {
        this.$inertia.delete(
          this.$route('categories.destroy', this.category.id)
        )
      }
    },
  },
}
</script>
