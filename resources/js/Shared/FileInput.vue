<template>
  <div>
    <div class="relative">
      <input
        :id="id"
        type="file"
        v-bind="$attrs"
        class="absolute w-full h-full opacity-0 cursor-pointer"
        @change="changed"
      />
      <slot>
        <label :for="id" class="flex justify-center">
          <div v-if="!file" class="py-16 w-full bg-gray-400">
            <icon name="drag-and-drop" class="flex-shrink-0 w-8 h-8 fill-white mb-4 mx-auto" />
            <div class="text-gray-900 mx-auto text-center">
              <span class="font-bold">Choose a file</span>
              or drag it here.
            </div>
          </div>
          <img v-else-if="imageUrl" :src="imageUrl" alt="Image preview..." />
          <div v-else class="py-20 w-full bg-gray-400">
            <div class="text-white mx-auto text-center">
              {{ file.name }}
            </div>
          </div>
        </label>
      </slot>
    </div>
    <slot name="remove" />
    <div class="form-error">
      <slot name="error">
        <div class="mb-2">{{ error }}</div>
      </slot>
    </div>
    <slot name="caption" />
  </div>
</template>

<script>
export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `file-input-${this._uid}`
      },
    },
    error: String,
  },
  data() {
    return {
      file: null,
      imageUrl: null,
    }
  },
  methods: {
    changed(event) {
      if (!event.target.files.length) return

      this.imageUrl = null

      this.$emit('input', (this.file = event.target.files[0]))

      if (this.file.type.startsWith('image')) {
        let reader = new FileReader()

        reader.onload = e => (this.imageUrl = e.target.result)

        reader.readAsDataURL(this.file)
      }
    },
  },
}
</script>