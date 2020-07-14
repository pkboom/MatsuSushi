<template>
  <back-layout title="Images">
    <div class="mb-6 flex justify-between items-center">
      <breadcrumb name="Images" />
      <inertia-link class="btn" :href="$route('admin.images.create')">
        <span>Create</span>
        <span class="hidden md:inline">Image</span>
      </inertia-link>
    </div>
    <div>
      <div id="image-container" class="gallery-grid" />
      <div id="bottom" class="-mt-1" />
    </div>
  </back-layout>
</template>

<script>
export default {
  data() {
    return {
      // fetchUrl: '/admin/images',
    }
  },
  mounted() {
    this.fetchImages()
  },
  methods: {
    fetchImages() {
      var bottom = document.getElementById('bottom')
      var url = '/admin/images'

      var imageObserver = new IntersectionObserver(function(entries, observer) {
        let currentBottomOffset = bottom.offsetTop < 100 ? 0 : bottom.offsetTop

        entries.forEach(function(entry) {
          if (entry.isIntersecting && url !== null) {
            fetch(url, {
              headers: {
                Accept: 'application/json',
              },
            })
              .then(response => response.json())
              .then(result => {
                result.images.data.forEach(image => {
                  let div = document.createElement('div')
                  div.classList.add('h-full')

                  if (image.id % 4 === 0) {
                    div.classList.add('gallery-item-wide')
                  } else if (image.id % 4 === 1) {
                    div.classList.add('gallery-item-tall')
                  } else if (image.id % 4 === 2) {
                    div.classList.add('gallery-item-wide', 'gallery-item-tall')
                  }

                  let img = document.createElement('img')
                  img.setAttribute('src', '/storage/' + image.filename)
                  img.classList.add('grid-image')
                  img.addEventListener('click', function(event) {
                    document.getElementById('gallery-modal').style.display =
                      'block'
                    document.getElementById('modal-image').src =
                      event.target.src
                  })
                  div.appendChild(img)

                  document.getElementById('image-container').appendChild(div)
                })

                window.scrollTo(0, currentBottomOffset)

                url = result.images.links[result.images.links.length - 1].url
              })
          }
        })
      })

      imageObserver.observe(bottom)
    },
    destroy() {
      if (confirm('Are you sure you want to delete this category?')) {
        this.$inertia.delete(
          this.$route('admin.categories.destroy', this.category.id)
        )
      }
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

#gallery-modal {
  display: none;
  position: fixed;
  z-index: 20;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgb(0, 0, 0);
  background-color: rgba(0, 0, 0, 0.9);
}

#modal-image {
  margin: auto;
  display: block;
  width: 100%;
}

#close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 30px;
  transition: 0.1s;
}

#close:hover,
#close:focus {
  color: #bbb;
  cursor: pointer;
}

@media (min-width: 768px) {
  #modal-image {
    width: 80%;
  }
}
</style>