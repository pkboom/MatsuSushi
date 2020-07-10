<template>
  <div class="bg-white rounded border border-gray-400 mx-4" v-if="items.length">
    <div class="flex flex-wrap">
      <div v-for="(image, index) in items" :key="image.id" class="mr-2">
        <matsu-image :data="image" @remove="remove(index)" />
      </div>
    </div>
  </div>
</template>

<script>
import MatsuImage from '../components/MatsuImage.vue'
import collection from '../mixins/collection'

export default {
  components: { MatsuImage },

  mixins: [collection],

  created() {
    this.fetch()
  },

  methods: {
    fetch() {
      axios.get('/gallery').then(this.refresh)
    },
    refresh(response) {
      this.items = response.data
    },
  },
}
</script>

<style>
.flex {
  display: flex;
}
</style>