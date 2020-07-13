<template>
  <layout title="Gallery">
    <div class="flex justify-center">
      <div>
        <div id="image-container" class="p-4 gallery-grid" />
        <div id="bottom" class="-mt-1" />
      </div>
    </div>
    <div id="gallery-modal" @click="closeImage">
      <span id="close" @click="closeImage">&times;</span>
      <img id="modal-image" />
    </div>
  </layout>
</template>

<script>
import { setUrl, closeImage } from '@/Utils/LazyLoading'

export default {
  mounted() {
    this.setUrl('/gallery')
  },
  methods: {
    setUrl,
    closeImage,
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