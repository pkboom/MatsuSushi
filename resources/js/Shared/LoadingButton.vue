<template>
  <button :disabled="loading" class="flex items-center">
    <div v-if="loading" class="spinner mr-2" />
    <slot />
  </button>
</template>

<script>
export default {
  props: {
    color: String,
    loading: Boolean,
  },
}
</script>
