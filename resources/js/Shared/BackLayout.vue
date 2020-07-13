<template>
  <div>
    <portal-target name="dropdown" slim />
    <div class="flex flex-col">
      <div class="min-h-screen flex flex-col">
        <div class="md:flex">
          <div class="bg-gray-900 md:flex-shrink-0 md:w-56 px-6 py-4 flex items-center justify-between">
            <inertia-link :href="$route('dashboard')">
              <logo name="touchstone" class="fill-white block" width="176" height="46.23" />
            </inertia-link>
            <div
              class="hamburger hamburger--squeeze inline-block md:hidden "
              :class="{ 'is-active': open }"
              style="z-index: 99999;"
              @click="open = !open"
            >
              <div class="hamburger-box">
                <div class="hamburger-inner" />
              </div>
            </div>
            <div class="absolute top-0 inset-x-0 bg-gray-800" :class="{ hidden: !open }" style="z-index: 99998;">
              <div class="flex flex-col items-center my-16">
                <main-menu />
              </div>
            </div>
          </div>
          <div
            class="hidden bg-white border-b w-full p-4 md:py-0 md:px-12 text-sm md:text-base md:flex justify-between items-center"
          >
            <dropdown
              v-if="$page.auth.user.is_support || $page.auth.user.is_super"
              class="mt-1 mr-4"
              placement="bottom-start"
              :before-toggle="loadAccounts"
            >
              <div class="flex items-center cursor-pointer select-none group">
                <div class="text-gray-800 group-hover:text-blue-700 focus:text-blue-700 mr-1 whitespace-no-wrap">
                  {{ $page.auth.account.name }}
                </div>
                <icon
                  class="w-5 h-5 group-hover:fill-blue-700 fill-gray-800 focus:fill-blue-700"
                  name="cheveron-down"
                />
              </div>
              <template v-slot:dropdown>
                <div class="mt-2 py-2 shadow-lg bg-white rounded text-sm max-h-xxs overflow-y-auto">
                  <inertia-link
                    v-for="account in accounts"
                    :key="account.id"
                    class="block pl-4 pr-8 py-2 hover:bg-gray-200 hover:text-gray-700"
                    :href="$route('accounts.login', account.id)"
                  >
                    {{ account.name }}
                  </inertia-link>
                </div>
              </template>
            </dropdown>
            <div v-else class="mt-1 mr-4">{{ $page.auth.account.name }}</div>
            <dropdown class="mt-1" placement="bottom-end">
              <div class="flex items-center cursor-pointer select-none group">
                <div class="text-gray-800 group-hover:text-blue-700 focus:text-blue-700 mr-1 whitespace-no-wrap">
                  <span>{{ $page.auth.user.first_name }}</span>
                  <span class="hidden md:inline">{{ $page.auth.user.last_name }}</span>
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
                    :href="$route('profile.edit')"
                  >
                    My Profile
                  </inertia-link>
                  <inertia-link
                    v-if="$page.auth.user.is_super"
                    class="block px-4 py-2 hover:bg-gray-200 hover:text-gray-700"
                    :href="$route('accounts')"
                  >
                    Manage Accounts
                  </inertia-link>
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
          <div class="ts-bg flex-shrink-0 w-56 p-12 hidden md:block">
            <main-menu />
          </div>
          <div class="w-full overflow-hidden px-4 py-8 md:p-12">
            <div
              v-if="$page.flash.success && showFlash"
              class="mb-8 flex items-center justify-between bg-green-400 rounded max-w-lg"
            >
              <div class="flex items-center">
                <icon name="checkmark" class="ml-4 flex-shrink-0 w-4 h-4 fill-white mr-2" />
                <div class="py-4 text-white text-sm font-medium">{{ $page.flash.success }}</div>
              </div>
              <button type="button" class="group mr-2 p-2" @click="showFlash = false">
                <icon class="block w-3 h-3 fill-green-300 group-hover:fill-green-100" name="close" />
              </button>
            </div>
            <div
              v-if="$page.flash.error && showFlash"
              class="mb-8 flex items-center justify-between bg-red-400 rounded max-w-lg"
            >
              <div class="flex items-center">
                <icon name="close-outline" class="ml-4 flex-shrink-0 w-4 h-4 fill-white mr-2" />
                <div class="py-4 text-white text-sm font-medium">{{ $page.flash.error }}</div>
              </div>
              <button type="button" class="group mr-2 p-2" @click="showFlash = false">
                <icon class="block w-3 h-3 fill-red-300 group-hover:fill-red-100" name="close" />
              </button>
            </div>
            <div
              v-if="$page.errors.any() && showFlash"
              class="mb-8 flex items-center justify-between bg-red-400 rounded max-w-lg"
            >
              <div class="flex items-center">
                <icon name="close-outline" class="ml-4 flex-shrink-0 w-4 h-4 fill-white mr-2" />
                <div class="py-4 text-white text-sm font-medium">
                  <span v-if="$page.errors.count() === 1">There is one form error.</span>
                  <span v-else>There are {{ $page.errors.count() }} form errors.</span>
                </div>
              </div>
              <button type="button" class="group mr-2 p-2" @click="showFlash = false">
                <icon class="block w-3 h-3 fill-red-300 group-hover:fill-red-100" name="close" />
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
import Http from '@/Utils/Http'

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
      document.title = title ? `${title} | ${this.$page.app.name}` : this.$page.app.name
    },
    loadAccounts() {
      if (!this.accounts) {
        return Http.get(this.$route('accounts')).then(response => {
          this.accounts = response.data.filter(account => {
            return account.id !== this.$page.auth.account.id
          })
        })
      }
    },
  },
}
</script>
