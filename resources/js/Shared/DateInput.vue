<template>
  <div>
    <label v-if="label" class="form-label" :for="`date-input-${_uid}`">{{ label }}:</label>
    <input
      :id="`date-input-${_uid}`"
      ref="input"
      v-bind="$attrs"
      autocomplete="off"
      class="form-input"
      :class="{ error: error }"
      type="text"
      :value="value"
      @change="change"
      @keyup="change"
    />
    <div v-if="error" class="form-error">{{ error }}</div>
  </div>
</template>

<script>
import pikaday from 'pikaday'
import moment from 'moment'

export default {
  inheritAttrs: false,
  props: {
    value: String,
    label: String,
    error: String,
    format: {
      type: String,
      default: 'MMMM D, YYYY',
    },
    minYear: {
      type: Number,
      default: 2019,
    },
    maxYear: {
      type: Number,
      default: new Date(new Date().getFullYear() + 1, 0, 1).getFullYear(),
    },
    defaultYear: {
      type: Number,
      default: new Date().getFullYear(),
    },
    defaultMonth: {
      type: Number,
      default: new Date().getMonth() + 1,
    },
  },
  mounted() {
    let picker = new pikaday({
      format: this.format,
      reposition: false,
      position: 'bottom left',
      field: this.$refs.input,
      yearRange: [this.minYear, this.maxYear],
      theme: 'date-input',
      keyboardInput: false,
      i18n: {
        previousMonth: 'Prev',
        nextMonth: 'Next',
        months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        weekdays: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
      },
    })

    if (this.value) {
      picker.gotoYear(moment(this.value, this.format).year())
      picker.gotoMonth(moment(this.value, this.format).month())
    }
  },
  methods: {
    focus() {
      this.$refs.input.focus()
    },
    select() {
      this.$refs.input.select()
    },
    change(e) {
      this.$emit('input', e.target.value)
    },
  },
}
</script>