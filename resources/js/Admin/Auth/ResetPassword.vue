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
          <text-input
            v-model="form.password"
            :error="$page.errors.first('password')"
            type="password"
            autocomplete="new-password"
            label="Password"
            class="mt-6"
          />
          <text-input
            v-model="form.password_confirmation"
            :error="$page.errors.first('password_confirmation')"
            type="password"
            autocomplete="new-password"
            label="Confirm password"
            class="mt-6"
          />
        </div>
        <div
          class="px-10 py-4 bg-gray-100 border-t border-gray-100 flex justify-end items-center"
        >
          <loading-button :loading="sending" class="btn" type="submit">
            Reset Password
          </loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    token: String,
    email: String,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        token: this.token,
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation,
      },
    }
  },
  mounted() {
    document.title = `Reset Password | ${this.$page.app.name}`
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.$route('password.update'), this.form, {
        onFinish: () => {
          this.sending = false
        },
      })
    },
  },
}
</script>
