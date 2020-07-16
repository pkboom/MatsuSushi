<template>
  <div>
    <div class="flex flex-col">
      <div class="min-h-screen flex flex-col">
        <div class="md:flex">
          <div
            class="bg-gray-900 flex items-center justify-between md:flex-shrink-0 md:w-56 px-6 py-4"
          >
            <div class="md:w-full flex justify-center">
              <a href="/" class="py-2 text-xl text-white font-serif">
                Matsu Sushi
              </a>
            </div>
            <div
              class="hamburger hamburger--squeeze inline-block md:hidden"
              :class="{ 'is-active': open }"
              style="z-index: 99999;"
              @click="open = !open"
            >
              <div class="hamburger-box">
                <div class="hamburger-inner" />
              </div>
            </div>
            <div
              class="absolute top-0 inset-x-0 bg-gray-800"
              :class="{ hidden: !open }"
              style="z-index: 99998;"
            >
              <div>
                <front-menu
                  class="flex flex-col items-center my-16 space-y-6 pt-1 text-white text-base"
                />
              </div>
            </div>
          </div>
          <div
            class="bg-gray-900 hidden md:flex md:items-center md:justify-end md:px-6 md:py-0 w-full"
          >
            <front-menu class="flex space-x-6 pt-1 text-white text-base" />
          </div>
        </div>
        <slot />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    title: String,
  },
  data() {
    return {
      count: 0,
      open: false,
    }
  },
  mounted() {
    document.title = this.title + ' | Matsu Sushi'
  },
  methods: {
    updatePageTitle(title) {
      document.title = title
        ? `${title} | ${this.$page.app.name}`
        : this.$page.app.name
    },
  },
}
</script>
