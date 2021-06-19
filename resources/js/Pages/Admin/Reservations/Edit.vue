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
            <div class="form-label flex items-end">
              <span class="mr-1">Phone</span>
              <button type="button" tabindex="-1" @click="copy('phone')">
                <icon name="clipboard" class="block w-5 h-5 stroke-gray-500" />
              </button>
            </div>
            <text-input ref="phone" v-model="form.phone" :error="$page.errors.first('phone')" />
          </div>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <date-input v-model="form.date" :error="$page.errors.first('date')" label="Date" />
          </div>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <time-input v-model="form.time" :error="$page.errors.first('time')" label="Time" />
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
            <div class="form-label flex items-end">
              <span class="mr-1">SMS</span>
              <button type="button" tabindex="-1" @click="copy('reminder')">
                <icon name="clipboard" class="block w-5 h-5 stroke-gray-500" />
              </button>
            </div>
            <textarea-input ref="reminder" :value="reminder" />
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
          <div class="flex items-center space-x-2">
            <a
              href="https://www.textnow.com/login"
              target="_blank"
              class="hover:underline text-matsu-blue-600"
              tabindex="-1"
            >
              Text now
            </a>
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
    reminder() {
      return `Reminder: Your table for ${this.form.people} at Matsu Sushi is booked on ${this.reservationDate} ${this.form.time}. Please respond '1' to confirm or '9' to cancel. Thank you.`
    },
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.put(this.$route('admin.reservations.update', this.reservation.id), this.form, {
        onFinish: () => (this.sending = false),
      })
    },
    destroy() {
      this.$inertia.delete(this.$route('admin.reservations.destroy', this.reservation.id), {
        onStart: () => confirm('Are you sure you want to delete this reservation?'),
      })
    },
    copy(input) {
      this.$refs[input].select()

      document.execCommand('copy')

      this.$page.flash.success = this.capitalizeFirstLetter(input) + ' copied.'
    },
    capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1)
    },
  },
}
</script>
