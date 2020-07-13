<template>
  <inertia-link class="flex items-center group py-3" :href="link">
    <slot>
      <icon
        :name="icon"
        class="w-4 h-4 mr-2"
        :class="
          isUrl(url)
            ? 'fill-gray-100'
            : 'fill-gray-400 group-hover:fill-gray-100'
        "
      />
    </slot>
    <div
      :class="
        isUrl(url) ? 'text-white' : 'text-gray-300 group-hover:text-white'
      "
    >
      {{ name }}
    </div>
  </inertia-link>
</template>

<script>
import { isUrl } from '@/Utils/Helpers'

export default {
  props: {
    name: String,
    url: String,
    link: String,
    icon: String,
  },

  methods: {
    isUrl,
  },
}
</script>
