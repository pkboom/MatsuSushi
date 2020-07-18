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
            class="bg-gray-900 hidden md:flex md:items-center md:justify-end md:px-10 md:py-0 w-full"
          >
            <front-menu class="flex space-x-6 pt-1 text-white text-base" />
          </div>
        </div>
        <slot />
        <div id="bottom" class="flex flex-col justify-center">
          <div
            class="border-2 flex flex-col items-center mx-auto pb-16 pt-12 px-12 space-y-4 text-white"
          >
            <div class="text-4xl uppercase">
              107 Hunter St. East Suite 102
            </div>
            <div class="text-lg uppercase">
              Peterborough, ON K9H 1G7
            </div>
          </div>
          <div class="-mt-7 bg-white mx-auto px-12 py-4 text-blue-900 text-xl">
            View Map
          </div>
          <div
            class="gap-8 grid grid-cols-1 lg:grid-cols-3 lg:mt-8 p-16 text-white w-full"
          >
            <div class="text-4xl font-serif whitespace-no-wrap mx-auto">
              Matsu Sushi
            </div>
            <div class="space-y-2 lg:space-y-4 mx-auto">
              <div class="text-2xl text-center">
                Contact
              </div>
              <div class="text-lg text-center">
                (705) 760-9484
              </div>
            </div>
            <div class="space-y-2 lg:space-y-4 mx-auto">
              <div class="text-2xl text-center">
                Restaurant Hours
              </div>
              <div class="text-lg text-center">
                <div>
                  Mon-Sun 11:30 AM ~ 10:00 PM
                </div>
                <div>
                  (Tuesdays closed)
                </div>
              </div>
            </div>
          </div>
          <div class="flex font-serif justify-center text-sm text-white w-full">
            Matsu Sushi © 2018. All rights reserved.
          </div>
        </div>
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

<style >
#bottom {
  height: 800px;
  background-image: url('/images/bottom.jpg');
  background-size: 100% 100%;
  background-repeat: no-repeat;
  background-position: center;
}
</style>