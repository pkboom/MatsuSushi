<template>
  <layout title="Start Your Order">
    <div class="p-8 max-w-3xl mx-auto">
      <div class="font-semibold text-xl py-4 border-b">
        Start Your Order
      </div>
      <div v-if="online_order_enabled" class="bg-white overflow-hidden w-full">
        <form @submit.prevent="submit">
          <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
            <div class="pr-6 pb-8 w-full">
              <div>Type:</div>
              <div class="flex items-center mt-4">
                <label class="inline-flex items-center mr-6">
                  <input
                    v-model="form.type"
                    type="radio"
                    class="form-radio"
                    name="option"
                    value="delivery"
                  />
                  <span class="ml-2">Delivery</span>
                </label>
                <label class="inline-flex items-center mr-6">
                  <input
                    v-model="form.type"
                    type="radio"
                    class="form-radio"
                    value="takeout"
                  />
                  <span class="ml-2">Takeout</span>
                </label>
              </div>
            </div>
            <div class="pr-6 pb-8 w-full lg:w-1/2">
              <text-input
                v-model="form.first_name"
                :error="errors.first('first_name')"
                label="First name"
              />
            </div>
            <div class="pr-6 pb-8 w-full lg:w-1/2">
              <text-input
                v-model="form.last_name"
                :error="errors.first('last_name')"
                label="Last name"
              />
            </div>
            <div class="pr-6 pb-8 w-full lg:w-1/2">
              <text-input
                v-model="form.phone"
                :error="errors.first('phone')"
                label="Phone"
              />
            </div>
            <div v-if="form.type === 'delivery'" class="pr-6 pb-8 w-full">
              <text-input
                v-model="form.address"
                :error="errors.first('address')"
                label="Address"
              />
            </div>
            <div v-else class="pr-6 pb-8 w-full lg:w-1/2">
              <time-input
                v-model="form.takeout_time"
                :error="errors.first('takeout_time')"
                label="Takeout time"
              />
            </div>
            <div class="pr-6 pb-8 w-full">
              <textarea-input
                v-model="form.message"
                :error="errors.first('message')"
                label="Message"
              />
            </div>
          </div>
          <div
            class="px-8 py-4 border-t border-gray-100 flex justify-end items-center"
          >
            <loading-button :loading="sending" class="btn" type="submit">
              Proceed to checkout
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
    online_order_enabled: Number,
  },
  data() {
    return {
      sending: false,
      form: {
        type: 'delivery',
        first_name: localStorage.getItem('first_name'),
        last_name: localStorage.getItem('last_name'),
        phone: localStorage.getItem('phone'),
        address: localStorage.getItem('address'),
        takeout_time: '12:00pm',
        message: null,
        items: [],
        tip_percentage: localStorage.getItem('tip_percentage'),
      },
      errors: new Errors(),
    }
  },
  mounted() {
    if (localStorage.getItem('items')) {
      this.form.items = JSON.parse(localStorage.getItem('items')).map(
        item => item.id
      )
    }
  },
  methods: {
    submit() {
      this.sending = true
      axios
        .post('/start-your-order', this.form)
        .then(response => {
          localStorage.setItem('first_name', this.form.first_name)
          localStorage.setItem('last_name', this.form.last_name)
          localStorage.setItem('phone', this.form.phone)
          localStorage.setItem('address', this.form.address)

          localStorage.setItem('last_name', this.form.last_name)

          location.href = '/checkout'
        })
        .catch(error => {
          this.sending = false

          this.errors.record(error.response.data.errors)
        })
    },
  },
}
</script>
