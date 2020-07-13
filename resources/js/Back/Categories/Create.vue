<template>
  <layout title="Create Category">
    <div class="mb-8">
      <breadcrumb
        :previous-url="$route('categories')"
        previous-name="Category"
        name="Create"
      />
    </div>
    <div class="bg-white rounded shadow overflow-hidden max-w-md">
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
          class="px-8 py-4 bg-gray-100 border-t border-gray-100 flex justify-end items-center"
        >
          <loading-button :loading="sending" class="btn-blue" type="submit">
            Create Category
          </loading-button>
        </div>
      </form>
    </div>
  </layout>
</template>

<script>
export default {
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: null,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia
        .post(this.$route('categories.store'), this.form)
        .then(() => (this.sending = false))
    },
  },
}
</script>
