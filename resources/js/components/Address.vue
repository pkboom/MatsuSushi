<template>
  <layout title="Cart">
    <div class="p-8 max-w-3xl mx-auto">
      <div class="font-semibold text-xl py-4 border-b">
        Checkout
      </div>
      <div v-if="onlineOrder" class="bg-white overflow-hidden w-full">
        <form @submit.prevent="submit">
          <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
            <div class="pr-6 pb-8 lg:w-1/2">
              <text-input
                v-model="form.name"
                :error="errors.first('name')"
                label="Name"
              />
            </div>
            <div class="pr-6 pb-8 lg:w-1/2">
              <text-input
                v-model="form.phone"
                :error="errors.first('phone')"
                label="Phone"
              />
            </div>
            <div class="pr-6 pb-8 w-full">
              <text-input
                v-model="form.address"
                :error="errors.first('address')"
                label="Address"
              />
            </div>
            <div class="pr-6 pb-8 w-full">
              <textarea-input
                v-model="form.request"
                :error="errors.first('request')"
                label="Request"
              />
            </div>
          </div>
          <div
            class="px-8 py-4 border-t border-gray-100 flex justify-end items-center"
          >
            <loading-button :loading="sending" class="btn" type="submit">
              Create Address
            </loading-button>
          </div>
        </form>
      </div>
      <div v-else class="bg-white overflow-hidden pt-2 text-lg w-full">
        Sorry, online order is temporarily unavailable.
      </div>
    </div>
  </layout>
</template>

<script>
import Errors from '@/Utils/Errors'

export default {
  props: {
    onlineOrder: Number,
  },
  data() {
    return {
      sending: false,
      form: {
        name: null,
        phone: null,
        address: null,
        request: null,
      },
      errors: new Errors(),
    }
  },
  mounted() {
    this.form.name = localStorage.getItem('name')
    this.form.phone = localStorage.getItem('phone')
    this.form.address = localStorage.getItem('address')
  },
  methods: {
    submit() {
      this.sending = true
      axios
        .post('/checkout', this.form)
        .then(response => {
          this.sending = false

          localStorage.setItem('name', this.form.name)
          localStorage.setItem('phone', this.form.phone)
          localStorage.setItem('address', this.form.address)

          location.href = '/thankyou/' + response.data.transaction.id
        })
        .catch(error => {
          this.sending = false

          this.errors.record(error.response.data.errors)
        })
    },
  },
}
</script>
