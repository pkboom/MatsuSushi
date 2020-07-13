<template>
  <div>
    <label v-if="label" class="form-label" :for="`textarea-input-${_uid}`">{{ label }}:</label>
    <textarea
      :id="`textarea-input-${_uid}`"
      ref="input"
      v-bind="$attrs"
      class="form-textarea"
      :class="{ error: error }"
      type="text"
      :value="value"
      @input="$emit('input', $event.target.value)"
    />
    <div v-if="error" class="form-error">{{ error }}</div>
  </div>
</template>

<script>
import autosize from 'autosize'

export default {
  inheritAttrs: false,
  props: {
    value: String,
    label: String,
    error: String,
    autosize: Boolean,
  },
  mounted() {
    if (this.autosize) {
      autosize(this.$refs.input)
    }
  },
  methods: {
    focus() {
      this.$refs.input.focus()
    },
    select() {
      this.$refs.input.select()
    },
  },
}
</script>
