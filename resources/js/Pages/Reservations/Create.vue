<template>
  <front-layout title="Reservation">
    <div class="p-8 max-w-3xl mx-auto">
      <div class="font-semibold text-xl py-4 border-b">
        Reservation
      </div>
      <div class="bg-white overflow-hidden w-full">
        <form @submit.prevent="submit">
          <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
            <input v-model="form.matsu_honeypot" type="text" class="hidden" />
            <div class="pr-6 pb-8 w-full lg:w-1/2">
              <text-input
                v-model="form.first_name"
                :error="$page.errors.first('first_name')"
                label="First name"
                autofocus
                autocomplete="given-name"
              />
            </div>
            <div class="pr-6 pb-8 w-full lg:w-1/2">
              <text-input
                v-model="form.last_name"
                :error="$page.errors.first('last_name')"
                label="Last name"
                autocomplete="family-name"
              />
            </div>
            <div class="pr-6 pb-8 w-full lg:w-1/2">
              <text-input
                v-model="form.phone"
                :error="$page.errors.first('phone')"
                label="Phone"
                type="tel"
                autocomplete="tel"
              />
            </div>
            <div class="pr-6 pb-8 w-full lg:w-1/2">
              <date-input
                v-model="form.date"
                :error="$page.errors.first('date')"
                label="Date"
                inputmode="none"
              />
            </div>
            <div class="pr-6 pb-8 w-full lg:w-1/2">
              <time-input
                v-model="form.time"
                :error="$page.errors.first('time')"
                label="Time"
                :from="from"
                :to="to"
                inputmode="none"
              />
            </div>
            <div class="pr-6 pb-8 w-full lg:w-1/2">
              <text-input
                v-model="form.people"
                type="number"
                :error="$page.errors.first('people')"
                label="People"
              />
            </div>
            <div class="pr-6 pb-8 w-full">
              <textarea-input
                v-model="form.message"
                :error="$page.errors.first('message')"
                label="Message"
              />
            </div>
          </div>
          <div class="px-8 py-4 flex justify-end items-center">
            <loading-button :loading="sending" class="btn" type="submit">
              Create Reservation
            </loading-button>
          </div>
        </form>
      </div>
    </div>
  </front-layout>
</template>

<script>
export default {
  props: {
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
        first_name: null,
        last_name: null,
        phone: null,
        date: null,
        time: null,
        people: 2,
        message: null,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true

      this.$inertia.post(this.$route('reservations.store'), this.form, {
        onFinish: () => (this.sending = false),
      })
    },
  },
}
</script>
