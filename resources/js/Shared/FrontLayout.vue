<template>
  <div>
    <div class="flex flex-col">
      <div class="min-h-screen flex flex-col">
        <div class="md:flex z-10">
          <div
            class="bg-gray-900 flex items-center justify-between md:flex-shrink-0 md:w-56 px-6"
          >
            <div class="md:w-full flex justify-center">
              <inertia-link
                :href="$route('home')"
                class="font-semibold font-serif py-2 text-white text-xl tracking-wide"
              >
                Matsu Sushi
              </inertia-link>
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
                  class="flex flex-col items-center my-16 space-y-8 pt-1 text-white text-base"
                />
              </div>
            </div>
          </div>
          <div
            class="bg-gray-900 hidden md:flex md:items-center md:justify-end md:px-10 py-5 w-full"
          >
            <front-menu class="flex space-x-7 pt-1 text-white text-base" />
          </div>
        </div>
        <slot />
      </div>
    </div>
    <flash />
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
  watch: {
    title(title) {
      this.updatePageTitle(title)
    },
  },
  mounted() {
    this.updatePageTitle(this.title)
  },
  methods: {
    updatePageTitle(title) {
      document.title = title ? `${title} | Matsu Sushi` : 'Matsu Sushi'
    },
  },
}
</script>
