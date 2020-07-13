<template>
  <button type="button" @click="toggle">
    <slot />
    <portal v-if="show" to="dropdown">
      <div>
        <div class="fixed inset-0 bg-black" :class="opacity" style="z-index: 80;" @click="toggle" />
        <div ref="dropdown" style="position: absolute; z-index: 90;" @click.stop>
          <slot name="dropdown" />
        </div>
      </div>
    </portal>
  </button>
</template>

<script>
import Popper from 'popper.js'

export default {
  props: {
    placement: {
      type: String,
      default: 'bottom-end',
    },
    boundary: {
      type: String,
      default: 'scrollParent',
    },
    beforeToggle: {
      type: Function,
      default: () => {},
    },
    opacity: {
      type: String,
      default: 'opacity-25',
    },
  },
  data() {
    return {
      show: false,
    }
  },
  watch: {
    show(show) {
      if (show) {
        this.$nextTick(() => {
          this.popper = new Popper(this.$el, this.$refs.dropdown, {
            placement: this.placement,
            modifiers: {
              preventOverflow: { boundariesElement: this.boundary },
            },
          })
        })
      } else if (this.popper) {
        setTimeout(() => this.popper.destroy(), 100)
      }
    },
  },
  mounted() {
    document.addEventListener('keydown', e => {
      if (e.keyCode === 27) {
        this.close()
      }
    })
  },
  methods: {
    close() {
      this.show = false
    },
    toggle() {
      Promise.resolve(this.beforeToggle()).then(() => (this.show = !this.show))
    },
  },
}
</script>
