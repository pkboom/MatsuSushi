<template>
  <div>
    <div class="gallery-grid">
      <div
        v-for="image in images"
        :key="image.id"
        :class="{
          'gallery-item-wide': image.id % 3 === 1,
          'gallery-item-tall': image.id % 3 === 2,
        }"
        class="relative"
      >
        <canvas :ref="'canvas' + image.id" class="absolute grid-image" />
        <img
          :ref="'image' + image.id"
          :src="image.path"
          class="grid-image opacity-0"
          alt=""
          @load="imageLoaded(image)"
          @click="$emit('hit', image)"
        />
      </div>
    </div>
    <div ref="bottom" />
  </div>
</template>

<script>
import Http from '@/Utils/Http'
import { decode } from 'blurhash'

export default {
  props: {
    url: String,
  },
  data() {
    return {
      images: [],
    }
  },
  mounted() {
    this.fetchImages()
  },
  methods: {
    fetchImages() {
      let bottom = this.$refs.bottom
      let fetchUrl = this.url

      let imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting && fetchUrl !== null) {
            Http.get(fetchUrl).then(response => {
              this.images = [...this.images, ...response.data.images.data]

              fetchUrl =
                response.data.images.links[
                  response.data.images.links.length - 1
                ].url

              response.data.images.data.forEach(image => {
                this.$nextTick(() => {
                  // offsetHeight is zero sometimes.
                  let pixels = decode(
                    image.blurhash,
                    this.$refs['image' + image.id][0].offsetWidth,
                    this.$refs['image' + image.id][0].offsetWidth,
                  )
                  console.log(this.$refs['image' + image.id][0].offsetWidth)
                  console.log(this.$refs['image' + image.id][0].offsetHeight)
                  console.log('computing')

                  let canvas = this.$refs['canvas' + image.id][0]
                  let ctx = canvas.getContext('2d')
                  let imageData = ctx.createImageData(
                    this.$refs['image' + image.id][0].offsetWidth,
                    this.$refs['image' + image.id][0].offsetWidth,
                  )

                  imageData.data.set(pixels)

                  ctx.putImageData(imageData, 0, 0)
                })
              })
            })
          }
        })
      })

      imageObserver.observe(bottom)
    },
    imageLoaded(image) {
      this.$refs['canvas' + image.id][0].classList.add('opacity-0')
      this.$refs['image' + image.id][0].classList.add('opacity-100')
    },
  },
}
</script>

<style>
.gallery-grid {
  display: grid;
  gap: 1rem;
  grid-template-columns: repeat(3, 1fr);
  grid-auto-flow: dense;
}

@media (min-width: 768px) {
  .gallery-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

.gallery-item-wide {
  grid-column: auto/span 2;
}

.gallery-item-tall {
  grid-row: auto/span 2;
}

.grid-image {
  object-fit: cover;
  display: block;
  width: 100%;
  height: 100%;
  transition: 0.1s;
}

.grid-image:hover {
  filter: brightness(90%);
}
</style>
