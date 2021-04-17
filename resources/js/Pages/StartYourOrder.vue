<template>
  <front-layout title="Start Your Order">
    <div class="p-8 max-w-3xl mx-auto w-full">
      <div class="font-semibold text-xl py-4 border-b">Start Your Order</div>
      <div
        v-if="online_order_available"
        class="bg-white overflow-hidden w-full"
      >
        <div v-if="false" class="text-gray-600 text-sm leading-5 mt-2">
          <span class="font-bold">&middot;</span>
          Put some
          <span class="text-matsu-blue-600">information</span>
          .
        </div>
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
              <div
                v-if="
                  form.type === type.delivery && takeout_available_after > 30
                "
                class="form-error"
              >
                We are too busy right now. It might take more than
                {{ takeout_available_after + 35 }} mins to get your order
                delivered. You might get your order sooner with `takeout`. Sorry
                for the inconvenience.
              </div>
            </div>
            <div class="pr-6 pb-8 w-full lg:w-1/2">
              <text-input
                v-model="form.email"
                :error="errors.first('email')"
                label="Email"
                type="email"
                autofocus
                autocomplete="email"
              />
            </div>
            <div class="pr-6 pb-8 w-full lg:w-1/2">
              <text-input
                v-model="form.phone"
                :error="errors.first('phone')"
                label="Phone"
                type="tel"
                autocomplete="tel"
              />
            </div>
            <div class="pr-6 pb-8 w-full lg:w-1/2">
              <text-input
                v-model="form.first_name"
                :error="errors.first('first_name')"
                label="First name"
                autocomplete="given-name"
              />
            </div>
            <div class="pr-6 pb-8 w-full lg:w-1/2">
              <text-input
                v-model="form.last_name"
                :error="errors.first('last_name')"
                label="Last name"
                autocomplete="family-name"
              />
            </div>
            <div v-if="form.type === type.delivery" class="pr-6 pb-8 w-full">
              <text-input
                v-model="form.address"
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
                inputmode="none"
              />
            </div>
            <div class="pr-6 pb-8 w-full">
              <textarea-input
                v-model="form.message"
                :error="errors.first('message')"
                label="Message"
              />
            </div>
            <div v-if="code" class="pr-6 pb-8 w-full lg:w-1/2">
              <text-input
                v-model="form.code"
                :error="errors.first('code')"
                label="Promotion code"
                type="text"
              />
            </div>
          </div>
          <div class="px-8 py-4 border-gray-100 flex justify-end items-center">
            <loading-button :loading="sending" class="btn" type="submit">
              Proceed to checkout
            </loading-button>
          </div>
          <div class="px-8">
            <div class="border-t-2">
              <div class="pt-4 text-gray-600 leading-5">
                &#10003; If you have any trouble ordering, call us at
                <a href="tel:7057609484" class="inline-flex">
                  <span
                    class="whitespace-no-wrap underline text-matsu-blue-600 font-bold"
                  >
                    705-760-9484
                  </span>
                  .
                </a>
              </div>
            </div>
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
    code: String,
    type: Object,
    takeout_available_after: Number,
    opening_hours_from: String,
    opening_hours_to: String,
  },
  data() {
    return {
      sending: false,
      from: moment().isAfter(moment(this.opening_hours_from, 'h:mma'))
        ? moment()
            .add(this.takeout_available_after, 'minutes')
            .format('h:mma')
        : this.opening_hours_from,
      to: this.opening_hours_to,
      form: {
        type: this.type.delivery,
        first_name: null,
        last_name: null,
        email: null,
        phone: null,
        address: null,
        takeout_time: null,
        message: null,
        code: null,
        items: [],
        tip_percentage: localStorage.getItem('tip_percentage') || 0,
        delivery_tip: localStorage.getItem('delivery_tip') || 0,
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
