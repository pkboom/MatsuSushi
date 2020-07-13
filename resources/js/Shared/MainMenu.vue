<template>
  <div class="font-heading font-semibold">
    <div class="mb-4">
      <menu-item
        name="Home"
        url="admin/dashboard"
        :link="$route('admin.dashboard')"
        icon="store-front"
      />
    </div>
    <div class="mb-4">
      <menu-item
        name="Categories"
        url="admin/categories*"
        :link="$route('admin.categories')"
        icon="apple"
      />
    </div>
    <div class="mb-4">
      <menu-item
        name="Items"
        url="admin/items*"
        :link="$route('admin.items')"
        icon="coffee"
      />
    </div>
  </div>
</template>

<script>
import { isUrl } from '@/Utils/Helpers'

export default {
  data() {
    return {}
  },
  methods: {
    isUrl,
  },
}
</script>
