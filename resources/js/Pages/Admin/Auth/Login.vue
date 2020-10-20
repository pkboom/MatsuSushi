<template>
  <div class="p-6 admin-bg min-h-screen flex justify-center items-center">
    <div class="w-full max-w-md">
      <form
        class="mt-8 bg-white rounded-lg shadow-lg overflow-hidden"
        @submit.prevent="submit"
      >
        <div class="px-10 py-12">
          <h1 class="text-center font-bold text-2xl">Welcome Back!</h1>
          <div class="mx-auto mt-6 w-24 border-b-2" />
          <text-input
            v-model="form.email"
            :error="$page.errors.email"
            class="mt-10"
            label="Email"
            type="email"
            autofocus
            autocapitalize="off"
            autocomplete="username"
          />
          <text-input
            v-model="form.password"
            :error="$page.errors.password"
            class="mt-6"
            label="Password"
            type="password"
            autocomplete="current-password"
          />
          <label class="mt-6 select-none flex" for="remember">
            <input
              id="remember"
              v-model="form.remember"
              class="form-checkbox mr-2"
              type="checkbox"
            />
            <span class="text-sm">Remember Me</span>
          </label>
        </div>
        <div
          class="px-10 py-4 bg-gray-100 border-t border-gray-100 flex justify-end items-center"
        >
          <loading-button :loading="sending" class="btn" type="submit">
            Log in
          </loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
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
    document.title = `Log in | ${this.$page.app.name}`
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.$route('login.attempt'), this.form, {
        onFinish: () => (this.sending = false),
      })
    },
  },
}
</script>
