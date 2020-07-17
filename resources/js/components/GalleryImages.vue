<template>
  <layout title="Gallery">
    <div class="p-4">
      <gallery url="/gallery" @hit="showModal" />
    </div>
    <div
      ref="gallery-modal"
      class="fixed h-full hidden left-0 overflow-auto py-20 top-0 w-full z-20"
      :style="{ 'background-color': 'rgba(0, 0, 0, 0.7)' }"
      @click="closeModal"
    >
      <span
        class="absolute cursor-pointer duration-150 focus:text-gray-300 hover:text-gray-300 pr-5 pt-3 right-0 text-3xl text-white top-0 transition"
        @click="closeModal"
      >
        &times;
      </span>
      <img ref="modal-image" class="mx-auto block w-full lg:w-4/5" />
    </div>
  </layout>
</template>

<script>
export default {
  methods: {
    showModal(image) {
      this.$refs['gallery-modal'].style.display = 'block'
      this.$refs['modal-image'].src = image.path
    },
    closeModal() {
      this.$refs['gallery-modal'].style.display = 'none'
    },
  },
}
</script>
