<template>
  <div>
    <div v-if="label" class="form-label">{{ label }}:</div>
    <div
      ref="input"
      v-bind="$attrs"
      :class="{ error: error }"
      class="border flex p-3 rounded space-x-6 border-gray-300"
    >
      <label v-for="(radioValue, key) in data" :key="key" class="inline-flex">
        <input
          v-model="picked"
          type="radio"
          v-bind="$attrs"
          class="form-radio"
          :name="`radio-input-${_uid}`"
          :value="radioValue"
          @input="$emit('input', resolve($event.target.value))"
        />
        <span class="ml-2">{{ key }}</span>
      </label>
    </div>
    <div v-if="error" class="form-error">{{ error }}</div>
  </div>
</template>

<script>
export default {
  inheritAttrs: false,
  props: {
    id: String,
    data: {
      type: Object,
      default: () => ({ Yes: true, No: false }),
    },
    resolve: {
      type: Function,
      default: value => value === 'true',
    },
    value: [Boolean, String],
    label: String,
    error: String,
  },
  data() {
    return {
      picked: this.value,
    }
  },
  methods: {
    focus() {
      this.$refs.input.focus()
    },
  },
}
</script>
