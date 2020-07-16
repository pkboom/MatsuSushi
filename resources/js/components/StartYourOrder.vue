<template>
  <layout title="Start Your Order">
    <div class="p-8 max-w-3xl mx-auto">
      <div class="font-semibold text-xl py-4 border-b">
        Start Your Order
      </div>
      <div v-if="onlineOrder" class="bg-white overflow-hidden w-full">
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
        type: 'delivery',
        first_name: null,
        last_name: null,
        phone: null,
        address: null,
        takeout_time: null,
        message: null,
        orders: JSON.parse(localStorage.getItem('orders')).map(
          order => order.id
        ),
        tip: localStorage.getItem('tipPercentage'),
      },
      errors: new Errors(),
    }
  },
  mounted() {
    // this.form.name = localStorage.getItem('name')
    // this.form.phone = localStorage.getItem('phone')
    // this.form.address = localStorage.getItem('address')
  },
  methods: {
    submit() {
      this.sending = true
      axios
        .post('/start-your-order', this.form)
        .then(response => {
          console.log(response.data)
          this.sending = false

          // localStorage.setItem('name', this.form.name)
          // localStorage.setItem('phone', this.form.phone)
          // localStorage.setItem('address', this.form.address)

          // location.href = '/checkout'
        })
        .catch(error => {
          this.sending = false

          this.errors.record(error.response.data.errors)
        })
    },
  },
}
</script>
