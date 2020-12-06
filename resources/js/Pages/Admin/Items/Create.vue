<template>
  <admin-layout title="Create Item">
    <div class="mb-8">
      <breadcrumb
        :previous-url="$route('admin.items')"
        previous-name="Items"
        name="Create"
      />
    </div>
    <div class="bg-white max-w-2xl overflow-hidden rounded shadow">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <div class="pr-6 pb-8 w-full">
            <search-input
              v-model="form.category"
              :error="$page.errors.first('category_id')"
              :data="categories"
              track-by="id"
              :search-by="['name']"
              label="Category"
            >
              <div
                v-if="form.category"
                class="flex items-center justify-between"
              >
                <div class="truncate">{{ form.category.name }}</div>
              </div>
              <template v-slot:option="{ option }">
                <div class="flex items-center justify-between">
                  <div>{{ option.name }}</div>
                </div>
              </template>
            </search-input>
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
          class="px-8 py-4 bg-gray-100 border-t border-gray-100 flex justify-end items-center"
        >
          <loading-button :loading="sending" class="btn" type="submit">
            Create Item
          </loading-button>
        </div>
      </form>
    </div>
  </admin-layout>
</template>

<script>
import { getFromUrl } from '@/Utils/Helpers'

export default {
  props: {
    categories: Array,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        category: this.categories.find(
          category => category.id === Number(this.getFromUrl('category')),
        ),
        name: null,
        price: 0,
        description: null,
      },
    }
  },
  methods: {
    getFromUrl,
    submit() {
      this.sending = true
      this.$inertia.post(
        this.$route('admin.items.store'),
        {
          category_id: this.form.category ? this.form.category.id : null,
          name: this.form.name,
          price: this.form.price,
          description: this.form.description,
        },
        { onFinish: () => (this.sending = false) },
      )
    },
  },
}
</script>
