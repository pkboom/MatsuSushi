<template>
  <div>
    <div id="container" class="gallery-grid" />
    <div ref="bottom" />
  </div>
</template>

<script>
export default {
  props: {
    url: String,
  },
  mounted() {
    this.fetchImages()
  },
  methods: {
    fetchImages() {
      let bottom = this.$refs.bottom
      let fetchUrl = this.url

      let imageObserver = new IntersectionObserver((entries, observer) => {
        let currentBottomOffset = bottom.offsetTop < 300 ? 0 : bottom.offsetTop

        entries.forEach(entry => {
          if (entry.isIntersecting && fetchUrl !== null) {
            axios.get(fetchUrl).then(response => {
              response.data.images.data.forEach(image => {
                let div = document.createElement('div')

                if (image.id % 4 === 0) {
                  div.classList.add('gallery-item-wide')
                } else if (image.id % 4 === 1) {
                  div.classList.add('gallery-item-tall')
                } else if (image.id % 4 === 2) {
                  div.classList.add('gallery-item-wide', 'gallery-item-tall')
                }

                let img = document.createElement('img')
                img.setAttribute('src', image.path)
                img.classList.add('grid-image')
                img.addEventListener('click', () => {
                  this.$emit('hit', image)
                })
                div.appendChild(img)

                document.getElementById('container').appendChild(div)
              })

              window.scrollTo(0, currentBottomOffset)

              fetchUrl =
                response.data.images.links[
                  response.data.images.links.length - 1
                ].url
            })
          }
        })
      })

      imageObserver.observe(bottom)
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
