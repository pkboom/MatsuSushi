<template>
  <div>
    <div
      v-show="show && level === 'success'"
      class="fixed bottom-6 right-6 rounded-md bg-green-50 p-4"
    >
      <div class="flex">
        <div class="flex-shrink-0">
          <svg
            class="h-5 w-5 text-green-400"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
              clip-rule="evenodd"
            />
          </svg>
        </div>
        <div class="ml-3">
          <p class="text-sm leading-5 font-medium text-green-800">
            {{ body }}
          </p>
        </div>
      </div>
    </div>
    <div
      v-show="show && level === 'error'"
      class="fixed bottom-6 right-6 rounded-md bg-red-50 p-4"
    >
      <div class="flex">
        <div class="flex-shrink-0">
          <svg
            class="h-5 w-5 text-red-400"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
              clip-rule="evenodd"
            />
          </svg>
        </div>
        <div class="ml-3">
          <p class="text-sm leading-5 font-medium text-red-800">
            {{ body }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    message: String,
    ttl: {
      type: Number,
      default: 5,
    },
  },
  data() {
    return {
      body: this.message,
      level: 'success',
      show: false,
      timeout: null,
      messageTtl: this.ttl,
    }
  },
  created() {
    if (this.message) {
      this.flash()
    }

    events.$on('flash', data => this.flash(data))
  },
  methods: {
    flash(data) {
      if (!data.message) return

      this.body = data.message
      this.level = data.level
      this.messageTtl = data.ttl

      this.show = true

      clearTimeout(this.timeout)
      this.timeout = null

      this.hide()
    },
    hide() {
      this.timeout = setTimeout(() => {
        this.show = false
      }, this.messageTtl * 1000)
    },
  },
}
</script>
