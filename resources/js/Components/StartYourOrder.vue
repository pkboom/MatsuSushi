<template>
  <front-layout title="Start Your Order">
    <div class="p-8 max-w-3xl mx-auto">
      <div class="font-semibold text-xl py-4 border-b">Start Your Order</div>
      <div
        v-if="online_order.available"
        class="bg-white overflow-hidden w-full"
      >
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
                v-model="form.email"
                :error="errors.first('email')"
                label="Email"
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
                :from="from"
                :to="to"
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
          <div class="leading-tight px-8 text-gray-600">
            * If you have any trouble ordering, call us at
            <a href="tel:7057609484" class="inline-flex">
              <span class="inline-block underline text-blue-600 font-bold">
                705-760-9484
              </span>
              .
            </a>
          </div>
        </form>
      </div>
      <div v-else class="bg-white overflow-hidden pt-2 text-lg w-full">
        Sorry, online order is temporarily unavailable.
      </div>
    </div>
  </front-layout>
</template>

<script>
import Errors from '@/Utils/Errors'
import moment from 'moment'

export default {
  props: {
    online_order: Object,
  },
  data() {
    return {
      sending: false,
      from: moment().isAfter(moment('11:00am', 'h:mma'))
        ? moment()
            .add(25, 'minutes')
            .format('h:mma')
        : '11:00am',
      to: '9:35pm',
      form: {
        type: localStorage.getItem('type') ?? 'delivery',
        first_name: localStorage.getItem('first_name'),
        last_name: localStorage.getItem('last_name'),
        email: localStorage.getItem('email'),
        phone: localStorage.getItem('phone'),
        address: localStorage.getItem('address'),
        takeout_time: null,
        message: null,
        items: [],
        tip_percentage: localStorage.getItem('tip_percentage'),
      },
      errors: new Errors(),
    }
  },
  watch: {
    'form.type'() {
      this.form.type === 'takeout'
        ? (this.form.address = null)
        : (this.form.address = localStorage.getItem('address'))

      this.form.takeout_time = null
    },
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
        .post('/start/your/order', this.form)
        .then(response => {
          localStorage.setItem('type', this.form.type)
          localStorage.setItem('first_name', this.form.first_name)
          localStorage.setItem('last_name', this.form.last_name)
          localStorage.setItem('email', this.form.email)
          localStorage.setItem('phone', this.form.phone)
          localStorage.setItem('address', this.form.address ?? '')

          Stripe(response.data.key)
            .redirectToCheckout({
              sessionId: response.data.session,
            })
            .then(result => {
              this.sending = false

              flash(result.error.message, 'error')
            })
        })
        .catch(error => {
          this.sending = false

          if (error.response) {
            this.errors.record(error.response.data.errors)
          }

          flash(this.errors.first('items*'), 'error')
        })
    },
  },
}
</script>
