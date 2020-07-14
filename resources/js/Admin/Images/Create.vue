<template>
  <admin-layout title="Upload Image">
    <h1 class="mb-8 font-bold text-xl">
      <breadcrumb
        :previous-url="$route('admin.images')"
        previous-name="Images"
        name="Upload"
      />
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-w-xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <div class="pb-8 pr-6 w-full">
            <file-input
              :error="$page.errors.first('file')"
              @input="file = $event"
            />
          </div>
          <div class="pr-6 w-full -mt-8">
            <div v-if="uploadPercentage" class="border rounded-full">
              <div ref="progress" class="w-min h-2 bg-green-500 rounded-full" />
            </div>
          </div>
        </div>
        <div
          class="px-8 py-4 bg-gray-100 border-t border-gray-100 flex justify-end items-center"
        >
          <loading-button :loading="sending" class="btn" type="submit">
            Upload File
          </loading-button>
        </div>
      </form>
    </div>
  </admin-layout>
</template>

<script>
import Http from '@/Utils/Http'
import Errors from '@/Utils/Errors'

export default {
  data() {
    return {
      sending: false,
      file: null,
      uploadPercentage: 0,
    }
  },
  watch: {
    uploadPercentage(progress) {
      this.$nextTick(() => {
        this.$refs.progress &&
          (this.$refs.progress.style.width = progress + '%')
      })
    },
  },
  methods: {
    submit() {
      this.sending = true

      let formData = new FormData()
      formData.append('file', this.file || '')

      Http.post(this.$route('admin.images.store'), formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
        onUploadProgress: progressEvent => {
          this.uploadPercentage = parseInt(
            Math.round((progressEvent.loaded * 100) / progressEvent.total)
          )
        },
      })
        .then(response => {
          this.$inertia
            .replace(this.$route('files'))
            .then(() => (this.$page.flash.success = response.data))
        })
        .catch(error => {
          this.sending = false
          this.$page.errors = new Errors(error.response.data.errors)
          this.uploadPercentage = 0
        })
    },
  },
}
</script>
