<template>
  <admin-layout :title="form.first_name + ' ' + form.last_name">
    <div class="mb-8">
      <breadcrumb
        :previous-url="$route('admin.reservations')"
        previous-name="Reservations"
        :name="form.first_name + ' ' + form.last_name"
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
          <div class="pr-6 pb-8 w-full">
            <div class="form-label">SMS:</div>
            <div class="leading-tight">
              Reminder: Your table for {{ form.people }} at Matsu Sushi is
              booked on {{ reservationDate }} {{ form.time }}. Please respond
              '1' to confirm or '9' to cancel. Thank you.
            </div>
          </div>
        </div>
        <div
          class="px-8 py-4 bg-gray-100 border-t border-gray-100 flex justify-between items-center"
        >
          <div class="flex items-baseline">
            <button
              class="text-red-500 hover:underline"
              tabindex="-1"
              type="button"
              @click="destroy"
            >
              Delete Reservation
            </button>
          </div>
          <div>
            <loading-button :loading="sending" class="btn ml-3" type="submit">
              Update Reservation
            </loading-button>
          </div>
        </div>
      </form>
    </div>
  </admin-layout>
</template>

<script>
import moment from 'moment'

export default {
  props: {
    reservation: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        first_name: this.reservation.first_name,
        last_name: this.reservation.last_name,
        phone: this.reservation.phone,
        date: this.reservation.date,
        time: this.reservation.time,
        people: this.reservation.people,
        message: this.reservation.message,
      },
    }
  },
  computed: {
    reservationDate() {
      return this.form.date.slice(0, -5)
    },
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia
        .put(
          this.$route('admin.reservations.update', this.reservation.id),
          this.form
        )
        .then(() => (this.sending = false))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this reservation?')) {
        this.$inertia.delete(
          this.$route('admin.reservations.destroy', this.reservation.id)
        )
      }
    },
  },
}
</script>
