<template>
  <div class="font-heading font-semibold">
    <div
      v-if="showInstructorDashboard"
      class="mb-4 uppercase text-xs text-gray-400"
    >
      Instructor
    </div>
    <div v-if="$page.auth.user.is_instructor" class="mb-4">
      <inertia-link
        class="flex items-center group py-3"
        :href="$route('dashboard.instructors')"
      >
        <icon
          name="dashboard"
          class="w-4 h-4 mr-2"
          :class="
            isUrl(prefix, 'instructor')
              ? 'fill-gray-100'
              : 'fill-gray-400 group-hover:fill-gray-100'
          "
        />
        <div
          :class="
            isUrl(prefix, 'instructor')
              ? 'text-white'
              : 'text-gray-300 group-hover:text-white'
          "
        >
          Dashboard
        </div>
      </inertia-link>
    </div>
    <div v-if="$page.auth.user.is_instructor" class="mb-4">
      <inertia-link
        class="flex items-center group py-3"
        :href="$route('instructor.classes')"
      >
        <icon
          name="apple"
          class="w-4 h-4 mr-2"
          :class="
            isUrl(prefix, 'instructor/classes*')
              ? 'fill-gray-100'
              : 'fill-gray-400 group-hover:fill-gray-100'
          "
        />
        <div
          :class="
            isUrl(prefix, 'instructor/classes*')
              ? 'text-white'
              : 'text-gray-300 group-hover:text-white'
          "
        >
          Classes
        </div>
      </inertia-link>
    </div>

    <div
      v-if="$page.auth.user.is_account_owner || $page.auth.user.is_super"
      class="mb-4"
    >
      <inertia-link
        class="flex items-center group py-3"
        :href="$route('resellers')"
      >
        <icon
          name="dollar"
          class="w-4 h-4 mr-2"
          :class="
            isUrl(prefix, 'resellers*')
              ? 'fill-gray-100'
              : 'fill-gray-400 group-hover:fill-gray-100'
          "
        />
        <div
          :class="
            isUrl(prefix, 'resellers*')
              ? 'text-white'
              : 'text-gray-300 group-hover:text-white'
          "
        >
          Resellers
        </div>
      </inertia-link>
    </div>

    <transition
      enter-active-class="transition duration-200 ease-in-out"
      leave-active-class="transition duration-200 ease-in-out"
      enter-class="opacity-0 transform -translate-y-5"
      enter-to-class="opacity-100 transform translate-y-0"
      leave-class="opacity-100 transform translate-y-0"
      leave-to-class="opacity-0 transform -translate-y-5"
    >
      <div
        v-if="
          showContents ||
            isUrl(prefix, ['quizzes*', 'elearnings*', 'files*', 'links*'])
        "
      >
        <div class="mb-4">
          <inertia-link
            class="flex items-center group py-3 pl-6 -mt-4 text-sm"
            :href="$route('quizzes')"
          >
            <div
              :class="
                isUrl(prefix, 'quizzes*')
                  ? 'text-white'
                  : 'text-gray-300 group-hover:text-white'
              "
            >
              Quizzes
            </div>
          </inertia-link>
        </div>
        <div class="mb-4">
          <inertia-link
            class="flex items-center group py-3 pl-6 -mt-4 text-sm"
            :href="$route('elearnings')"
          >
            <div
              :class="
                isUrl(prefix, 'elearnings*')
                  ? 'text-white'
                  : 'text-gray-300 group-hover:text-white'
              "
            >
              e-Learning
            </div>
          </inertia-link>
        </div>
        <div class="mb-4">
          <inertia-link
            class="flex items-center group py-3 pl-6 -mt-4 text-sm"
            :href="$route('files')"
          >
            <div
              :class="
                isUrl(prefix, 'files*')
                  ? 'text-white'
                  : 'text-gray-300 group-hover:text-white'
              "
            >
              Files
            </div>
          </inertia-link>
        </div>
        <div class="mb-4">
          <inertia-link
            class="flex items-center group py-3 pl-6 -mt-4 text-sm"
            :href="$route('links')"
          >
            <div
              :class="
                isUrl(prefix, 'links*')
                  ? 'text-white'
                  : 'text-gray-300 group-hover:text-white'
              "
            >
              Links
            </div>
          </inertia-link>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import { isUrl } from '@/Utils/Helpers'

export default {
  data() {
    return {
      showContents: false,
    }
  },
  computed: {
    showInstructorDashboard() {
      return this.$page.auth.user.is_instructor
    },
    prefix() {
      return this.$page.locale || ''
    },
  },
  methods: {
    isUrl,
  },
}
</script>
