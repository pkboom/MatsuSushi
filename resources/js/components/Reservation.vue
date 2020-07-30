<template>
  <front-layout title="Reservation">
    <div class="p-8 max-w-3xl mx-auto">
      <div class="font-semibold text-xl py-4 border-b">
        Reservation
      </div>
      <div v-if="reservation_enabled" class="bg-white overflow-hidden w-full">
        <form @submit.prevent="submit">
          <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
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
            <div class="pr-6 pb-8 w-full lg:w-1/2">
              <date-input
                v-model="form.date"
                :error="errors.first('date')"
                label="Date"
              />
            </div>
            <div class="pr-6 pb-8 w-full lg:w-1/2">
              <time-input
                v-model="form.time"
                :error="errors.first('time')"
                label="Time"
                :from="from"
                :to="to"
              />
            </div>
            <div class="pr-6 pb-8 w-full lg:w-1/2">
              <text-input
                v-model="form.people"
                type="number"
                :error="errors.first('people')"
                label="People"
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
              Complete Reservation
            </loading-button>
          </div>
        </form>
      </div>
      <div v-else class="bg-white overflow-hidden pt-2 text-lg w-full">
        Sorry, Reservation is temporarily unavailable.
      </div>
    </div>
  </front-layout>
</template>

<script>
import Errors from '@/Utils/Errors'

export default {
  props: {
    reservation_enabled: Number,
    encrypted_time: String,
  },
  data() {
    return {
      sending: false,
      from: '11:00am',
      to: '9:30pm',
      form: {
        matsu_honeypot: null,
        encrypted_time: this.encrypted_time,
        first_name: localStorage.getItem('first_name'),
        last_name: localStorage.getItem('last_name'),
        phone: localStorage.getItem('phone'),
        date: null,
        time: null,
        people: 2,
        message: null,
      },
      errors: new Errors(),
    }
  },
  methods: {
    submit() {
      this.sending = true
      axios
        .post('/reserve', this.form)
        .then(response => {
          this.sending = false

          this.errors.reset()

          flash(response.data.message, 'success', 20)
        })
        .catch(error => {
          this.sending = false

          if (error.response.status === 400) {
            // spam
          } else if (error.response) {
            this.errors.record(error.response.data.errors)
          }
        })
    },
  },
}
</script>
