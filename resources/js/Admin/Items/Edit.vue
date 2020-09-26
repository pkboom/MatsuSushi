<template>
  <admin-layout :title="form.name">
    <div class="mb-8">
      <breadcrumb
        :previous-url="$route('admin.items')"
        previous-name="Items"
        :name="form.name"
      />
    </div>
    <div class="bg-white max-w-2xl overflow-hidden rounded shadow">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <div class="pr-6 pb-8 w-full">
            <label class="form-label">Category:</label>
            <inertia-link
              :href="'/admin/categories/' + item.category.id + '/edit'"
              class="form-input bg-gray-100"
            >
              {{ form.category }}
            </inertia-link>
          </div>
          <div class="pr-6 pb-8 w-full">
            <text-input
              v-model="form.name"
              :error="$page.errors.first('name')"
              label="Name"
            />
          </div>
          <div class="pr-6 pb-8 w-full">
            <text-input
              v-model="form.price"
              :error="$page.errors.first('price')"
              label="Price"
            />
          </div>
          <div class="pr-6 pb-8 w-full">
            <textarea-input
              v-model="form.description"
              :error="$page.errors.first('description')"
              rows="2"
              :autosize="true"
              label="Description"
            />
          </div>
        </div>
        <div
          class="px-8 py-4 bg-gray-100 border-t border-gray-100 flex justify-between items-center"
        >
          <div class="flex items-baseline">
            <button
              class="text-red-500 hover:underline"
              tabindex="-1"
              type="button"
              @click="destroy"
            >
              Delete Item
            </button>
          </div>
          <div>
            <loading-button :loading="sending" class="btn ml-3" type="submit">
              Update Item
            </loading-button>
          </div>
        </div>
      </form>
    </div>
  </admin-layout>
</template>

<script>
export default {
  props: {
    item: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: this.item.name,
        price: this.item.price,
        description: this.item.description,
        category: this.item.category.name,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.put(
        this.$route('admin.items.update', this.item.id),
        {
          category_id: this.form.category ? this.form.category.id : null,
          name: this.form.name,
          price: this.form.price,
          description: this.form.description,
        },
        {
          onFinish: () => {
            this.sending = false
          },
        }
      )
    },
    destroy() {
      this.$inertia.delete(this.$route('admin.items.destroy', this.item.id), {
        onStart: () => confirm('Are you sure you want to delete this item?'),
      })
    },
  },
}
</script>
