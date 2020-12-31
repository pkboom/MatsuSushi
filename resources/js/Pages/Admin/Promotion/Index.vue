<template>
  <admin-layout title="Promotion">
    <div class="flex justify-between items-center">
      <div class="mb-8">
        <breadcrumb name="Promotion" />
      </div>
    </div>
    <div class="bg-white max-w-2xl overflow-hidden rounded shadow">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <div class="pr-6 pb-8 w-full">
            <text-input
              v-model="form.title"
              :error="$page.errors.first('title')"
              label="Title"
            />
          </div>
          <div class="pr-6 pb-8 w-full">
            <textarea-input
              v-model="form.body"
              :error="$page.errors.first('body')"
              label="Body"
              rows="5"
            />
          </div>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <radio-input
              v-model="form.order_now"
              :error="$page.errors.first('order_now')"
              label="Show `order now`"
            />
          </div>
          <div class="pr-6 pb-8 w-full">
            <text-input
              v-model="form.code"
              :error="$page.errors.first('code')"
              label="Code"
            />
          </div>
          <div
            v-for="(promotion, key) in promotions"
            :key="key"
            class="pr-6 pb-8 w-full"
          >
            <select-input
              v-model="form[key]"
              :label="'Promotion over $' + key.substr(4)"
              :error="$page.errors.first(key)"
            >
              <option :value="null" />
              <option v-for="item in items" :key="item.id" :value="item.id">
                {{ item.name }}
              </option>
            </select-input>
          </div>
        </div>
        <div
          class="px-8 py-4 bg-gray-100 border-t border-gray-100 flex justify-end items-center"
        >
          <loading-button :loading="sending" class="btn" type="submit">
            Save Promotion
          </loading-button>
        </div>
      </form>
    </div>
  </admin-layout>
</template>

<script>
export default {
  props: {
    title: String,
    body: String,
    order_now: Boolean,
    code: String,
    promotions: Object,
    items: Array,
  },
  data() {
    return {
      sending: false,
      form: {
        title: this.title,
        body: this.body,
        order_now: this.order_now,
        code: this.code,
        ...this.promotions,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.$route('admin.promotion.store'), this.form, {
        onFinish: () => (this.sending = false),
      })
    },
  },
}
</script>
