<template>
  <admin-layout title="Disable Reservation">
    <div class="mb-8">
      <breadcrumb
        :previous-url="$route('admin.reservations')"
        previous-name="Reservations"
        name="Disable"
      />
    </div>
    <div class="bg-white max-w-2xl overflow-hidden rounded shadow">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <div class="pr-6 pb-8 w-full">
            <div class="flex flex-col space-y-3">
              <div>We are closed on</div>
              <label class="inline-flex items-center mr-6">
                <input
                  v-model="form.days"
                  type="radio"
                  class="form-radio"
                  name="option"
                  value="mondays"
                />
                <span class="ml-2">Mondays</span>
              </label>
              <label class="inline-flex items-center mr-6">
                <input
                  v-model="form.days"
                  type="radio"
                  class="form-radio"
                  name="option"
                  value="tuesdays"
                />
                <span class="ml-2">Tuesdays</span>
              </label>
              <label class="inline-flex items-center mr-6">
                <input
                  v-model="form.days"
                  type="radio"
                  class="form-radio"
                  name="option"
                  value="wendesdays"
                />
                <span class="ml-2">Wendesdays</span>
              </label>
              <label class="inline-flex items-center mr-6">
                <input
                  v-model="form.days"
                  type="radio"
                  class="form-radio"
                  name="option"
                  value="thursdays"
                />
                <span class="ml-2">Thursdays</span>
              </label>
              <label class="inline-flex items-center mr-6">
                <input
                  v-model="form.days"
                  type="radio"
                  class="form-radio"
                  name="option"
                  value="fridays"
                />
                <span class="ml-2">Fridays</span>
              </label>
              <label class="inline-flex items-center mr-6">
                <input
                  v-model="form.days"
                  type="radio"
                  class="form-radio"
                  name="option"
                  value="saturdays"
                />
                <span class="ml-2">Saturdays</span>
              </label>
              <label class="inline-flex items-center mr-6">
                <input
                  v-model="form.days"
                  type="radio"
                  class="form-radio"
                  name="option"
                  value="sundays"
                />
                <span class="ml-2">Sundays</span>
              </label>
              <label class="inline-flex items-center mr-6">
                <input
                  v-model="form.days"
                  type="radio"
                  class="form-radio"
                  name="option"
                  :value="null"
                />
                <span class="ml-2">We work everyday</span>
              </label>
              <div v-if="$page.errors.first('days')" class="form-error">
                {{ $page.errors.first('days') }}
              </div>
            </div>
          </div>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <date-input
              v-model="form.dates[0]"
              :error="$page.errors.first('dates.0')"
              label="No reservation date"
            />
          </div>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <date-input
              v-model="form.dates[1]"
              :error="$page.errors.first('dates.1')"
              label="No reservation date"
            />
          </div>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <date-input
              v-model="form.dates[2]"
              :error="$page.errors.first('dates.2')"
              label="No reservation date"
            />
          </div>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <date-input
              v-model="form.dates[3]"
              :error="$page.errors.first('dates.3')"
              label="No reservation date"
            />
          </div>
        </div>
        <div
          class="px-8 py-4 bg-gray-100 border-t border-gray-100 flex justify-end items-center"
        >
          <loading-button :loading="sending" class="btn" type="submit">
            Complete Setup
          </loading-button>
        </div>
      </form>
    </div>
  </admin-layout>
</template>

<script>
export default {
  props: {
    closed_days: String,
    closed_dates: Array,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        days: this.closed_days,
        dates: this.closed_dates,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia
        .post(this.$route('admin.reservations.disable.store'), this.form)
        .then(() => (this.sending = false))
    },
  },
}
</script>
