<template>
  <div
    v-if="images.length"
    class="bg-white rounded border border-gray-400 mx-4"
  >
    <div class="flex flex-wrap">
      <div v-for="(image, index) in images" :key="image.id" class="mr-2">
        <matsu-image :data="image" @remove="remove(index)" />
      </div>
    </div>
  </div>
</template>

<script>
import MatsuImage from '../Pages/MatsuImage.vue'
import collection from '../mixins/collection'

export default {
  components: { MatsuImage },
  mixins: [collection],
  created() {
    this.fetch()
  },
  methods: {
    fetch() {
      axios
        .get('/upload/images')
        .then(response => (this.images = response.data.images))
    },
  },
}
</script>