<template>
  <div>
    <portal-target name="dropdown" slim />
    <div class="flex flex-col">
      <div class="min-h-screen flex flex-col">
        <div class="md:flex">
          <div
            class="bg-gray-900 flex items-center justify-between md:flex-shrink-0 md:w-56 px-6 py-4"
          >
            <div class="w-full flex justify-center">
              <inertia-link
                :href="$route('admin.dashboard')"
                class="py-2 text-xl text-white font-serif"
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
              <div class="flex flex-col items-center my-16">
                <admin-menu />
              </div>
            </div>
          </div>
          <div
            class="hidden bg-white border-b w-full p-4 md:py-0 md:px-12 text-sm md:text-base md:flex justify-end items-center"
          >
            <dropdown class="mt-1" placement="bottom-end">
              <div class="flex items-center cursor-pointer select-none group">
                <div
                  class="text-gray-800 group-hover:text-blue-700 focus:text-blue-700 mr-1 whitespace-no-wrap"
                >
                  <span>{{ $page.auth.user.first_name }}</span>
                  <span class="hidden md:inline">
                    {{ $page.auth.user.last_name }}
                  </span>
                </div>
                <icon
                  class="w-5 h-5 group-hover:fill-blue-700 fill-gray-800 focus:fill-blue-700"
                  name="cheveron-down"
                />
              </div>
              <template v-slot:dropdown>
                <div class="mt-2 py-2 shadow-lg bg-white rounded text-sm">
                  <inertia-link
                    class="block px-4 py-2 hover:bg-gray-200 hover:text-gray-700"
                    :href="$route('logout')"
                    method="post"
                  >
                    Log out
                  </inertia-link>
                </div>
              </template>
            </dropdown>
          </div>
        </div>
        <div class="flex flex-grow">
          <div class="admin-bg flex-shrink-0 w-56 p-12 hidden md:block">
            <admin-menu />
          </div>
          <div class="w-full overflow-hidden px-4 py-8 md:p-12">
            <div
              v-if="$page.flash.success && showFlash"
              class="mb-8 flex items-center justify-between bg-green-400 rounded max-w-2xl"
            >
              <div class="flex items-center">
                <icon
                  name="checkmark"
                  class="ml-4 flex-shrink-0 w-4 h-4 fill-white mr-2"
                />
                <div class="py-4 text-white text-sm font-medium">
                  {{ $page.flash.success }}
                </div>
              </div>
              <button
                type="button"
                class="group mr-2 p-2"
                @click="showFlash = false"
              >
                <icon
                  class="block w-3 h-3 fill-green-300 group-hover:fill-green-100"
                  name="close"
                />
              </button>
            </div>
            <div
              v-if="$page.flash.error && showFlash"
              class="mb-8 flex items-center justify-between bg-red-400 rounded max-w-2xl"
            >
              <div class="flex items-center">
                <icon
                  name="close-outline"
                  class="ml-4 flex-shrink-0 w-4 h-4 fill-white mr-2"
                />
                <div class="py-4 text-white text-sm font-medium">
                  {{ $page.flash.error }}
                </div>
              </div>
              <button
                type="button"
                class="group mr-2 p-2"
                @click="showFlash = false"
              >
                <icon
                  class="block w-3 h-3 fill-red-300 group-hover:fill-red-100"
                  name="close"
                />
              </button>
            </div>
            <div
              v-if="$page.errors.any() && showFlash"
              class="mb-8 flex items-center justify-between bg-red-400 rounded max-w-2xl"
            >
              <div class="flex items-center">
                <icon
                  name="close-outline"
                  class="ml-4 flex-shrink-0 w-4 h-4 fill-white mr-2"
                />
                <div class="py-4 text-white text-sm font-medium">
                  <span v-if="$page.errors.count() === 1">
                    There is one form error.
                  </span>
                  <span v-else>
                    There are {{ $page.errors.count() }} form errors.
                  </span>
                </div>
              </div>
              <button
                type="button"
                class="group mr-2 p-2"
                @click="showFlash = false"
              >
                <icon
                  class="block w-3 h-3 fill-red-300 group-hover:fill-red-100"
                  name="close"
                />
              </button>
            </div>
            <slot />
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
      accounts: null,
      showFlash: true,
      open: false,
    }
  },
  watch: {
    title(title) {
      this.updatePageTitle(title)
    },
    '$page.flash': {
      handler() {
        this.showFlash = true
      },
      deep: true,
    },
  },
  mounted() {
    this.updatePageTitle(this.title)
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
