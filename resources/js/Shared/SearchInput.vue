<template>
  <div v-click-outside="close">
    <label v-if="label" class="form-label" @click="open">{{ label }}:</label>
    <div class="relative">
      <div
        ref="input"
        :class="{ focus: show, error: error }"
        class="form-input pr-8"
        :tabindex="show ? -1 : 0"
        @click="open"
        @focus="open"
        @keydown.down.prevent="open"
        @keydown.up.prevent="open"
      >
        <slot v-if="value" />
        <div v-else-if="data.length === 0" class="text-gray-600">
          No options found
        </div>
        <div v-else class="text-gray-600">Click to choose…</div>
      </div>
      <button
        v-if="value"
        type="button"
        tabindex="-1"
        class="absolute inset-y-0 right-0 px-4 block group"
        @click.stop="clear"
      >
        <svg
          class="fill-gray-600 group-hover:fill-red-500 w-2 h-2"
          viewBox="278.046 126.846 235.908 235.908"
        >
          <path
            d="M506.784 134.017c-9.56-9.56-25.06-9.56-34.62 0L396 210.18l-76.164-76.164c-9.56-9.56-25.06-9.56-34.62 0-9.56 9.56-9.56 25.06 0 34.62L361.38 244.8l-76.164 76.165c-9.56 9.56-9.56 25.06 0 34.62 9.56 9.56 25.06 9.56 34.62 0L396 279.42l76.164 76.165c9.56 9.56 25.06 9.56 34.62 0 9.56-9.56 9.56-25.06 0-34.62L430.62 244.8l76.164-76.163c9.56-9.56 9.56-25.06 0-34.62z"
          />
        </svg>
      </button>
    </div>
    <div v-if="error" class="form-error">{{ error }}</div>
    <div
      v-if="show"
      ref="dropdown"
      class="absolute top-0 left-0 my-1 shadow-lg rounded bg-white overflow-hidden"
      :style="{ width: inputWidth + 'px', zIndex: 2000 }"
    >
      <div class="p-2 bg-gray-100">
        <input
          ref="search"
          v-model="search"
          class="w-full px-3 py-2 text-sm leading-normal bg-white rounded text-gray-800 focus:outline-none"
          tabindex="-1"
          type="text"
          placeholder="Search…"
          spellcheck="false"
          @keydown.enter.prevent="chooseSelected"
          @keydown.down.prevent="move(1)"
          @keydown.up.prevent="move(-1)"
        />
      </div>
      <div
        ref="container"
        class="relative overflow-y-auto overscroll-contain scrolling-touch text-sm leading-tight"
        tabindex="-1"
        style="max-height: 240px;"
      >
        <div
          v-for="(option, index) in filtered"
          :key="getTrackedByKey(option)"
          :ref="index === selected ? 'selected' : null"
          class="px-4 py-2 cursor-pointer"
          :class="{
            'hover:bg-gray-100 text-gray-700': index !== selected,
            'bg-blue-500 hover:bg-blue-600 text-white': index === selected,
          }"
          @click="choose(option)"
        >
          <slot name="option" :option="option" :selected="index === selected" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Fuse from 'fuse.js'
import Popper from 'popper.js'

export default {
  inheritAttrs: false,
  props: {
    value: Object,
    data: Array,
    trackBy: String,
    searchBy: [String, Array],
    label: String,
    error: String,
    boundary: {
      type: String,
      default: 'scrollParent',
      validator: value =>
        ['scrollParent', 'viewport', 'window'].indexOf(value) !== -1,
    },
  },
  data() {
    return {
      show: false,
      search: '',
      selected: 0,
      popper: null,
      inputWidth: null,
    }
  },
  computed: {
    filtered() {
      if (this.search) {
        let searchBy = !_.isArray(this.searchBy)
          ? [this.searchBy]
          : this.searchBy

        var fuse = new Fuse(this.data, {
          keys: searchBy,
          includeScore: true,
          tokenize: true,
        })

        return fuse
          .search(this.search)
          .filter(result => result.score < 0.75)
          .map(result => result.item)
      }

      return this.data
    },
  },
  watch: {
    search() {
      this.selected = 0
      this.$refs.container.scrollTop = 0
    },
    show(show) {
      if (show) {
        let selected = _.findIndex(this.data, [
          this.trackBy,
          _.get(this.value, this.trackBy),
        ])
        if (selected !== -1) this.selected = selected
        this.inputWidth = this.$refs.input.offsetWidth

        this.$nextTick(() => {
          const vm = this

          this.popper = new Popper(this.$refs.input, this.$refs.dropdown, {
            placement: 'bottom-start',
            onCreate() {
              vm.$refs.container.scrollTop = vm.$refs.container.scrollHeight
              vm.updateScrollPosition()
              vm.$refs.search.focus()
            },
            modifiers: {
              preventOverflow: { boundariesElement: this.boundary },
            },
          })
        })
      } else {
        this.search = ''
        if (this.popper) this.popper.destroy()
      }
    },
  },
  mounted() {
    document.addEventListener('keydown', e => {
      if (this.show && (e.keyCode == 9 || e.keyCode == 27)) {
        setTimeout(() => this.close(), 50)
      }
    })
  },
  methods: {
    getTrackedByKey(option) {
      return _.get(option, this.trackBy)
    },
    open() {
      if (this.data.length) {
        this.show = true
      }
    },
    close() {
      this.show = false
    },
    clear() {
      this.$emit('input', null)
    },
    move(offset) {
      let newIndex = this.selected + offset

      if (newIndex >= 0 && newIndex < this.filtered.length) {
        this.selected = newIndex
        this.updateScrollPosition()
      }
    },
    updateScrollPosition() {
      this.$nextTick(() => {
        if (
          this.$refs.selected[0].offsetTop >
          this.$refs.container.scrollTop +
            this.$refs.container.clientHeight -
            this.$refs.selected[0].clientHeight
        ) {
          this.$refs.container.scrollTop =
            this.$refs.selected[0].offsetTop +
            this.$refs.selected[0].clientHeight -
            this.$refs.container.clientHeight
        }

        if (this.$refs.selected[0].offsetTop < this.$refs.container.scrollTop) {
          this.$refs.container.scrollTop = this.$refs.selected[0].offsetTop
        }
      })
    },
    chooseSelected() {
      if (this.filtered[this.selected] !== undefined) {
        this.$emit('input', this.filtered[this.selected])
        this.$refs.input.focus()
        this.$nextTick(() => this.close())
      }
    },
    choose(option) {
      this.selected = _.findIndex(this.data, [
        this.trackBy,
        _.get(option, this.trackBy),
      ])
      this.$emit('input', option)
      this.$refs.input.focus()
      this.$nextTick(() => this.close())
    },
    focus() {
      this.$refs.input.focus()
    },
  },
}
</script>
