<template>
  <front-layout title="Start Your Order">
    <div class="p-8 max-w-3xl mx-auto w-full">
      <div class="font-semibold text-xl py-4 border-b">Start Your Order</div>
      <div
        v-if="online_order_available"
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
                    :value="type.delivery"
                  />
                  <span class="ml-2">Delivery</span>
                </label>
                <label class="inline-flex items-center mr-6">
                  <input
                    v-model="form.type"
                    type="radio"
                    class="form-radio"
                    :value="type.takeout"
                  />
                  <span class="ml-2">Takeout</span>
                </label>
              </div>
            </div>
            <div class="pr-6 pb-8 w-full lg:w-1/2">
              <text-input
                v-model="form.email"
                name="email"
                :error="errors.first('email')"
                label="Email"
                type="email"
                autocomplete="email"
              />
            </div>
            <div class="pr-6 pb-8 w-full lg:w-1/2">
              <text-input
                v-model="form.phone"
                name="tel"
                :error="errors.first('phone')"
                label="Phone"
                autocomplete="tel"
              />
            </div>
            <div class="pr-6 pb-8 w-full lg:w-1/2">
              <text-input
                v-model="form.first_name"
                name="given-name"
                :error="errors.first('first_name')"
                label="First name"
                autocomplete="given-name"
              />
            </div>
            <div class="pr-6 pb-8 w-full lg:w-1/2">
              <text-input
                v-model="form.last_name"
                name="family-name"
                :error="errors.first('last_name')"
                label="Last name"
                autocomplete="family-name"
              />
            </div>
            <div v-if="form.type === type.delivery" class="pr-6 pb-8 w-full">
              <text-input
                v-model="form.address"
                name="address"
                :error="errors.first('address')"
                label="Address"
                autocomplete="street-address"
              />
            </div>
            <div
              v-else-if="form.type === type.takeout"
              class="pr-6 pb-8 w-full lg:w-1/2"
            >
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
import Http from '@/Utils/Http'
import '@/Utils/Stripe'

export default {
  props: {
    online_order_available: Boolean,
    type: Object,
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
        type: this.type.delivery,
        first_name: null,
        last_name: null,
        email: null,
        phone: null,
        address: null,
        takeout_time: null,
        message: null,
        items: [],
        tip_percentage: localStorage.getItem('tip_percentage') ?? 0,
      },
      errors: new Errors(),
    }
  },
  watch: {
    'form.type'() {
      this.form.address = null
      this.form.takeout_time = null
    },
  },
  mounted() {
    if (localStorage.getItem('items')) {
      this.form.items = JSON.parse(localStorage.getItem('items')).map(
        item => item.id,
      )
    }
  },
  methods: {
    submit() {
      this.sending = true
      Http.post(this.$route('start-your-order.store'), this.form)
        .then(response => {
          Stripe(response.data.key)
            .redirectToCheckout({
              sessionId: response.data.session,
            })
            .then(result => {
              this.sending = false

              this.$page.flash = {
                error: result.error.message,
              }
            })
        })
        .catch(error => {
          this.sending = false

          if (error.response) {
            this.errors.record(error.response.data.errors)
          }

          this.$page.flash = {
            error: this.errors.first('items*'),
          }
        })
    },
  },
}
</script>