<template>
  <admin-layout title="Images">
    <div class="mb-6 flex justify-between items-center">
      <breadcrumb name="Images" />
      <inertia-link class="btn" :href="$route('admin.images.create')">
        <span>Create</span>
        <span class="hidden md:inline">Image</span>
      </inertia-link>
    </div>
    <div>
      <gallery :url="$route('admin.images')" @hit="destroy" />
    </div>
  </admin-layout>
</template>

<script>
export default {
  methods: {
    destroy(image) {
      this.$inertia.delete(this.$route('admin.images.destroy', image.id), {
        onStart: () => confirm('Are you sure you want to delete this image?'),
      })
    },
  },
}
</script>
