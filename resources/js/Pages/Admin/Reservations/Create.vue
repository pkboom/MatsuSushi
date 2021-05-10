<template>
  <admin-layout title="Create Reservation">
    <div class="mb-8">
      <breadcrumb
        :previous-url="$route('admin.reservations')"
        previous-name="Reservations"
        name="Create"
      />
    </div>
    <div class="bg-white max-w-2xl overflow-hidden rounded shadow">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <text-input
              v-model="form.first_name"
              :error="$page.errors.first('first_name')"
              label="First name"
            />
          </div>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <text-input
              v-model="form.last_name"
              :error="$page.errors.first('last_name')"
              label="Last name"
            />
          </div>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <text-input
              v-model="form.phone"
              :error="$page.errors.first('phone')"
              label="Phone"
            />
          </div>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <date-input
              v-model="form.date"
              :error="$page.errors.first('date')"
              label="Date"
            />
          </div>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <time-input
              v-model="form.time"
              :error="$page.errors.first('time')"
              label="Time"
              :from="from"
              :to="to"
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
        <div
          class="px-8 py-4 bg-gray-100 border-t border-gray-100 flex justify-end items-center"
        >
          <loading-button :loading="sending" class="btn" type="submit">
            Create Reservation
          </loading-button>
        </div>
      </form>
    </div>
  </admin-layout>
</template>

<script>
export default {
  remember: 'form',
  data() {
    return {
      sending: false,
      from: '11:00am',
      to: '9:30pm',
      form: {
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

      this.$inertia.post(this.$route('admin.reservations.store'), this.form, {
        onFinish: () => (this.sending = false),
      })
    },
  },
}
</script>
