<template>
  <div class="p-6 admin-bg min-h-screen flex justify-center items-center">
    <div class="w-full max-w-md">
      <form
        class="mt-8 bg-white rounded-lg shadow-lg overflow-hidden"
        @submit.prevent="submit"
      >
        <div class="px-10 py-12">
          <h1 class="text-center font-bold text-2xl">Reset Password</h1>
          <div class="mx-auto mt-6 w-24 border-b-2" />
          <text-input
            v-model="form.email"
            :error="$page.errors.email"
            class="mt-10"
            label="Email"
            type="email"
            autofocus
            autocapitalize="off"
          />
          <div
            v-if="success"
            class="mt-8 flex items-center bg-green-500 rounded max-w-xl"
          >
            <icon
              name="checkmark"
              class="ml-4 flex-shrink-0 w-4 h-4 fill-white mr-2"
            />
            <div class="py-4 text-white text-sm font-medium">{{ success }}</div>
          </div>
        </div>
        <div
          class="px-10 py-4 bg-gray-100 border-t border-gray-100 flex justify-between items-center"
        >
          <inertia-link
            class="text-gray-700 hover:underline"
            :href="$route('login')"
          >
            Cancel
          </inertia-link>
          <loading-button :loading="sending" class="btn" type="submit">
            Send Password Reset Link
          </loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    success: String,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        email: null,
        password: null,
        remember: null,
      },
    }
  },
  mounted() {
    document.title = `Reset Password | ${this.$page.app.name}`
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.$route('password.email'), this.form, {
        onFinish: () => (this.sending = false),
      })
    },
  },
}
</script>
