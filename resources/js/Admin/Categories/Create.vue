<template>
  <admin-layout title="Create Category">
    <div class="mb-8">
      <breadcrumb
        :previous-url="$route('admin.categories')"
        previous-name="Categories"
        name="Create"
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
          class="px-8 py-4 bg-gray-100 border-t border-gray-100 flex justify-end items-center"
        >
          <loading-button :loading="sending" class="btn" type="submit">
            Create Category
          </loading-button>
        </div>
      </form>
    </div>
  </admin-layout>
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
        .post(this.$route('admin.categories.store'), this.form)
        .then(() => (this.sending = false))
    },
  },
}
</script>
