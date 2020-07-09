<template>
  <div class="py-3">
    <div class="flex justify-between">
      <div v-text="data.name" class="text-base"></div>
      <button
        class="border-green-500 border-2 py-2 px-3 rounded float-right	"
        @click="ordered"
      >
        <span class="text-green-500">{{ data.price }}</span>
      </button>
    </div>

    <div v-text="descriptToLowerCase"></div>
  </div>
</template>

<script>
export default {
  props: ['data'],

  methods: {
    ordered() {
      this.$emit('order', {
        name: this.data.name,
        price: this.data.price,
        quantity: 1,
      })
    },
  },

  computed: {
    descriptToLowerCase() {
      let lowerCaseDescript = this.data.descript.toLowerCase()
      return lowerCaseDescript.replace('california', 'California')
    },
  },
}
</script>
