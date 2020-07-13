<template>
  <div>
    <label
      v-if="label"
      class="form-label"
      :for="id ? id : `text-input-${_uid}`"
    >
      {{ label }}:
    </label>
    <input
      :id="id ? id : `text-input-${_uid}`"
      ref="input"
      v-bind="$attrs"
      class="form-input"
      :class="{ error: error }"
      :type="type ? type : 'text'"
      :value="value"
      @input="$emit('input', $event.target.value)"
    />
    <div v-if="error" class="form-error">{{ error }}</div>
  </div>
</template>

<script>
export default {
  inheritAttrs: false,
  props: {
    id: String,
    value: [String, Number],
    label: String,
    error: String,
    type: String,
  },
  methods: {
    focus() {
      this.$refs.input.focus()
    },
    select() {
      this.$refs.input.select()
    },
    setSelectionRange(start, end) {
      this.$refs.input.setSelectionRange(start, end)
    },
  },
}
</script>
