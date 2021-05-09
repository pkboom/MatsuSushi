<template>
  <admin-layout title="Schedule">
    <div class="flex justify-between items-center">
      <div class="mb-8">
        <breadcrumb name="Settings" />
      </div>
    </div>
    <div class="bg-white max-w-2xl overflow-hidden rounded shadow">
      <div class="p-8 -mb-8">
        <button type="button" class="btn" @click="alarmTest">Alarm Test</button>
      </div>
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <radio-input
              v-model="form.online_order_available"
              :error="$page.errors.first('online_order_available')"
              label="Enable online order"
            />
          </div>
          <div class="pr-6 pb-8 w-full">
            <div class="flex flex-col space-y-3">
              <div>We are closed on</div>
              <div class="flex items-center">
                <input
                  id="sundays"
                  v-model="form.closed_day"
                  type="radio"
                  class="form-radio"
                  name="option"
                  value="0"
                />
                <label for="sundays" class="ml-2">Sundays</label>
              </div>
              <div class="flex items-center">
                <input
                  id="mondays"
                  v-model="form.closed_day"
                  type="radio"
                  class="form-radio"
                  name="option"
                  value="1"
                />
                <label for="mondays" class="ml-2">Mondays</label>
              </div>
              <div class="flex items-center">
                <input
                  id="tuesdays"
                  v-model="form.closed_day"
                  type="radio"
                  class="form-radio"
                  name="option"
                  value="2"
                />
                <label for="tuesdays" class="ml-2">Tuesdays</label>
              </div>
              <div class="flex items-center">
                <input
                  id="wendesdays"
                  v-model="form.closed_day"
                  type="radio"
                  class="form-radio"
                  name="option"
                  value="3"
                />
                <label for="wendesdays" class="ml-2">Wendesdays</label>
              </div>
              <div class="flex items-center">
                <input
                  id="thursdays"
                  v-model="form.closed_day"
                  type="radio"
                  class="form-radio"
                  name="option"
                  value="4"
                />
                <label for="thursdays" class="ml-2">Thursdays</label>
              </div>
              <div class="flex items-center">
                <input
                  id="fridays"
                  v-model="form.closed_day"
                  type="radio"
                  class="form-radio"
                  name="option"
                  value="5"
                />
                <label for="fridays" class="ml-2">Fridays</label>
              </div>
              <div class="flex items-center">
                <input
                  id="saturdays"
                  v-model="form.closed_day"
                  type="radio"
                  class="form-radio"
                  name="option"
                  value="6"
                />
                <label for="saturdays" class="ml-2">Saturdays</label>
              </div>
              <div class="flex items-center">
                <input
                  id="everyday"
                  v-model="form.closed_day"
                  type="radio"
                  class="form-radio"
                  name="option"
                  :value="null"
                />
                <label for="everyday" class="ml-2">We work everyday</label>
              </div>
              <div v-if="$page.errors.first('closed_day')" class="form-error">
                {{ $page.errors.first('closed_day') }}
              </div>
            </div>
          </div>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <time-input
              v-model="form.opening_hours_from"
              :error="$page.errors.first('opening_hours_from')"
              label="Opening hours(from)"
            />
          </div>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <time-input
              v-model="form.opening_hours_to"
              :error="$page.errors.first('opening_hours_to')"
              label="Opening hours(to)"
            />
          </div>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <date-input
              v-model="form.closed_dates[0]"
              :error="$page.errors.first('closed_dates.0')"
              label="Closed date"
            />
          </div>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <date-input
              v-model="form.closed_dates[1]"
              :error="$page.errors.first('closed_dates.1')"
              label="Closed date"
            />
          </div>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <date-input
              v-model="form.closed_dates[2]"
              :error="$page.errors.first('closed_dates.2')"
              label="Closed date"
            />
          </div>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <date-input
              v-model="form.closed_dates[3]"
              :error="$page.errors.first('closed_dates.3')"
              label="Closed date"
            />
          </div>
          <div class="pr-6 pb-8 w-full lg:w-1/2">
            <select-input
              v-model="form.takeout_available_after"
              label="Wait time(min) after orders"
              :error="$page.errors.first('takeout_available_after')"
              :options="takeout_times"
            />
          </div>
        </div>
        <div
          class="px-8 py-4 bg-gray-100 border-t border-gray-100 flex justify-end items-center"
        >
          <loading-button :loading="sending" class="btn" type="submit">
            Save Schedule
          </loading-button>
        </div>
      </form>
    </div>
    <audio id="alarm" src="/sound/new-order.ogg" preload="auto" />
  </admin-layout>
</template>

<script>
export default {
  props: {
    schedule: Object,
    online_order_available: Boolean,
    takeout_times: Array,
    takeout_available_after: Number,
  },
  data() {
    return {
      sending: false,
      form: {
        ...this.schedule,
        online_order_available: this.online_order_available,
        takeout_available_after: this.takeout_available_after,
      },
    }
  },
  methods: {
    submit() {
      this.sending = true
      this.$inertia.post(this.$route('admin.settings.store'), this.form, {
        onFinish: () => (this.sending = false),
      })
    },
    alarmTest() {
      document.getElementById('alarm').play()
    },
  },
}
</script>
