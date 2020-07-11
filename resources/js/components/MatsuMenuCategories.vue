<template>
  <div>
    <button
      class="font-semibold text-base"
      v-text="data.name"
      @click="show"
    ></button>
    <div class="panel" ref="panel">
      <div v-for="menu in data.menu">
        <matsu-menu-items :data="menu" @order="ordered"></matsu-menu-items>
      </div>
    </div>
  </div>
</template>

<script>
import MatsuMenuItems from './MatsuMenuItems.vue'

export default {
  props: ['data'],

  data() {
    return {
      isActive: false,
    }
  },

  components: { MatsuMenuItems },

  methods: {
    show(event) {
      this.isActive = !this.isActive

      this.$refs.panel.style.maxHeight = this.$refs.panel.style.maxHeight
        ? null
        : this.$refs.panel.scrollHeight + 'px'
    },

    ordered(item) {
      this.$emit('order', {
        name: item.name,
        price: item.price,
        quantity: 1,
      })
    },
  },
}
</script>
