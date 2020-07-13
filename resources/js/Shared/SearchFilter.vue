<template>
  <div class="flex items-center">
    <div class="flex w-full bg-white shadow rounded">
      <dropdown
        v-if="filterShow"
        class="px-4 md:px-6 rounded-l border-r flex items-center hover:bg-gray-100 focus:border-white focus:shadow-outline focus:z-10"
        placement="bottom-start"
      >
        <span class="text-gray-800 hidden md:block">Filter</span>
        <svg
          class="w-2 h-2 fill-gray-700 md:ml-2"
          viewBox="0 0 961.243 599.998"
        >
          <path
            d="M239.998 239.999L0 0h961.243L721.246 240c-131.999 132-240.28 240-240.624 239.999-.345-.001-108.625-108.001-240.624-240z"
          />
        </svg>
        <template v-slot:dropdown>
          <div
            class="mt-2 px-4 py-6 w-screen shadow-lg bg-white rounded"
            :style="{ maxWidth: `${maxWidth}px` }"
          >
            <slot />
          </div>
        </template>
      </dropdown>
      <input
        class="relative w-full leading-normal px-6 py-3 rounded-r focus:shadow-outline"
        :class="{ rounded: !filterShow }"
        autocomplete="off"
        type="text"
        name="search"
        placeholder="Search…"
        :value="value"
        @input="$emit('input', $event.target.value)"
      />
    </div>
    <button
      class="ml-3 text-sm text-gray-600 hover:text-gray-700"
      type="button"
      @click="$emit('reset')"
    >
      Reset
    </button>
  </div>
</template>

<script>
export default {
  props: {
    value: String,
    maxWidth: {
      type: Number,
      default: 300,
    },
    filterShow: {
      type: Boolean,
      default: true,
    },
  },
}
</script>
