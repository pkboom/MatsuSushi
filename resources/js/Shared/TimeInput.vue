<template>
  <div>
    <label v-if="label" class="form-label" :for="`time-input-${_uid}`">
      {{ label }}:
    </label>
    <div class="relative">
      <input
        :id="`time-input-${_uid}`"
        ref="input"
        v-model="inputTime"
        type="text"
        v-bind="$attrs"
        autocomplete="off"
        class="form-input"
        :class="{ error: error }"
        @input="updated"
        @focus="showMenu"
        @blur="hideMenu"
        @keydown.down="move(1)"
        @keydown.up="move(-1)"
      />
      <div
        v-show="menuVisible"
        ref="container"
        class="absolute overflow-y-auto border-r border-gray-100 shadow-lg rounded bg-white z-50 text-xs"
        :style="{ top: '45px', height: '145px' }"
      >
        <button
          v-for="(time, key) in times"
          :key="key"
          :ref="formattedTime === time ? 'selected' : null"
          tabindex="-1"
          class="block pl-3 pr-6 py-2 w-full text-left"
          :class="
            formattedTime === time
              ? 'bg-orange-400 hover:bg-orange-500 text-white'
              : 'bg-white hover:bg-gray-100 text-gray-800 '
          "
          type="button"
          @mousedown="pick(time)"
        >
          {{ time }}
        </button>
      </div>
    </div>
    <div v-if="error" class="form-error">{{ error }}</div>
  </div>
</template>

<script>
export default {
  inheritAttrs: false,
  props: {
    value: String,
    label: String,
    error: String,
  },
  data() {
    return {
      inputTime: this.value,
      formattedTime: this.value,
      menuVisible: false,
      times: [
        // '12:00am',
        // '12:30am',
        // '1:00am',
        // '1:30am',
        // '2:00am',
        // '2:30am',
        // '3:00am',
        // '3:30am',
        // '4:00am',
        // '4:30am',
        // '5:00am',
        // '5:30am',
        // '6:00am',
        // '6:30am',
        // '7:00am',
        // '7:30am',
        // '8:00am',
        // '8:30am',
        // '9:00am',
        // '9:30am',
        // '10:00am',
        // '10:30am',
        // '11:00am',
        '11:30am',
        '12:00pm',
        '12:30pm',
        '1:00pm',
        '1:30pm',
        '2:00pm',
        '2:30pm',
        '3:00pm',
        '3:30pm',
        '4:00pm',
        '4:30pm',
        '5:00pm',
        '5:30pm',
        '6:00pm',
        '6:30pm',
        '7:00pm',
        '7:30pm',
        '8:00pm',
        '8:30pm',
        '9:00pm',
        '9:30pm',
        // '10:00pm',
        // '10:30pm',
        // '11:00pm',
        // '11:30pm',
      ],
    }
  },
  methods: {
    focus() {
      this.$refs.input.focus()
    },
    select() {
      this.$refs.input.select()
    },
    showMenu() {
      this.menuVisible = true
      this.updateScrollPosition()
    },
    hideMenu() {
      this.inputTime = this.formattedTime
      this.$emit('input', this.inputTime)
      this.menuVisible = false
    },
    updateScrollPosition() {
      this.$nextTick(() => {
        if (!_.isEmpty(this.$refs.selected)) {
          this.$refs.container.scrollTop = this.$refs.selected[0].offsetTop
        }
      })
    },
    move(offset) {
      var index = _.indexOf(this.times, this.formattedTime)

      if ((index === -1 || index === 0) && offset === -1) {
        var newIndex = this.times.length - 1
      } else if (
        (index === -1 || index === this.times.length - 1) &&
        offset === 1
      ) {
        var newIndex = 0
      } else {
        var newIndex = index + offset
      }

      this.inputTime = this.formattedTime = this.times[newIndex]
      this.$emit('input', this.inputTime)
      this.updateScrollPosition()
    },
    pick(time) {
      this.inputTime = this.formattedTime = time
      this.$emit('input', this.inputTime)
      this.updateScrollPosition()
    },
    updated() {
      var match = /^(10|11|12|01|02|03|04|05|06|07|08|09|1|2|3|4|5|6|7|8|9)(:*)(00|01|02|03|04|05|06|07|08|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23|24|25|26|27|28|29|30|31|32|33|34|35|36|37|38|39|40|41|42|43|44|45|46|47|48|49|50|51|52|53|54|55|56|57|58|59)*(am|a|pm|p)*$/gi.exec(
        this.inputTime.replace(/\s/g, '')
      )

      if (match) {
        var hour = parseInt(match[1], 10)
        var minute = _.padEnd(match[3], 2, '0')
        var period = match[4] === undefined ? 'pm' : _.padEnd(match[4], 2, 'm')
        this.formattedTime = `${hour}:${minute}${period}`.toLowerCase()
      } else {
        this.formattedTime = this.inputTime
      }

      this.$emit('input', this.inputTime)
      this.updateScrollPosition()
    },
  },
}
</script>
