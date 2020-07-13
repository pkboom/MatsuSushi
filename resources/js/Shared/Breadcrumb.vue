<template>
  <h1 v-if="previousUrl" class="font-heaidng font-bold text-xl">
    <inertia-link
      v-if="previousUrl"
      class="text-blue-600 hover:text-blue-700"
      :href="previousUrl"
    >
      {{ previousName }}
    </inertia-link>
    <span class="text-blue-600 font-medium">/</span>
    <inertia-link
      v-if="middleUrl"
      class="text-blue-600 hover:text-blue-700"
      :href="middleUrl"
    >
      {{ middleName }}
    </inertia-link>
    <span v-if="middleUrl" class="text-blue-600 font-medium">/</span>
    {{ name }}
  </h1>
  <h1 v-else class="font-heaidng font-bold text-xl">
    {{ name }}
  </h1>
</template>

<script>
export default {
  props: {
    middleUrl: String,
    middleName: String,
    previousUrl: String,
    previousName: String,
    name: String,
  },
}
</script>