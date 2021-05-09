<template>
  <admin-layout title="Dashboard">
    <div class="flex justify-between items-end mb-4">
      <div>
        <div class="flex items-baseline text-xl pb-1">
          <div class="font-bold whitespace-no-wrap">Today's orders</div>
          <div class="text-xs text-gray-400 px-1">({{ currentTime }})</div>
          <span v-if="stopNotification" class="ml-1 text-red-600 text-xs">
            Stopped!
          </span>
          <span
            v-if="takeout_available_after > takeout_available_times[0]"
            class="ml-2 text-red-600 text-xs"
          >
            Wait time: {{ takeout_available_after }} min ({{ serveTime }})
          </span>
        </div>
      </div>
    </div>
    <div v-if="showPlaySound" class="mb-4">
      <button
        class="bg-red-600 font-bold rounded text-white text-sm px-6 py-3 hover:cursor-pointer hover:bg-red-700"
        @click="showPlaySound = false"
      >
        Click this button to play notification sound
      </button>
    </div>
    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 mb-4">
      <inertia-link
        v-for="reservation in upcomingReservations"
        :key="reservation.id"
        :href="
          $route('admin.reservations.edit', { reservation: reservation.id })
        "
        class="bg-white rounded p-4 shadow gray-800 space-y-4"
      >
        <span
          class="bg-orange-100 font-bold mr-2 px-4 py-1 rounded-full text-orange-600 text-xs"
        >
          Reservation
        </span>
        {{ reservation.first_name }}
        {{ reservation.last_name }}
        {{ reservation.time }}
      </inertia-link>
    </div>
    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 mb-4">
      <div
        v-for="takeout in takeouts"
        :key="takeout.id"
        class="bg-white rounded p-4 shadow gray-800 space-y-4"
      >
        <span class="text-gray-500">{{ takeout.id }}.</span>
        {{ takeout.first_name }}
        {{ takeout.last_name }}
        {{ takeout.takeout_time }}
      </div>
    </div>
    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 xl:grid-cols-3">
      <div
        v-for="transaction in transactions"
        :key="transaction.id"
        class="bg-white rounded p-4 shadow gray-800 space-y-4"
      >
        <div class="flex items-center">
          <span class="text-gray-500">Status:</span>
          <span
            v-if="transaction.status !== 'succeeded'"
            class="bg-red-100 font-bold ml-2 px-4 py-1 rounded-full text-red-600 text-xs"
          >
            {{ transaction.status }}
          </span>
          <button
            v-else-if="isNew(transaction.formattedCreatedAt)"
            type="button"
            class="bg-green-100 font-bold ml-2 px-4 py-1 rounded-full text-green-600 text-xs hover:bg-green-200"
            @click="endNotification"
          >
            new
          </button>
          <span
            v-else
            class="bg-gray-200 font-bold ml-2 px-4 py-1 rounded-full text-gray-500 text-xs"
          >
            served
          </span>
        </div>
        <div>
          <span class="text-gray-500">Order no.</span>
          {{ transaction.id }}
          <span class="text-gray-400 text-sm">
            ({{ transaction.formattedCreatedAt.slice(11) }})
          </span>
        </div>
        <div>
          <span class="text-gray-500">Total:</span>
          $ {{ transaction.total }}
        </div>
        <div>
          <span class="text-gray-500">Name:</span>
          {{ transaction.name }}
        </div>
        <div>
          <span class="text-gray-500">Phone:</span>
          {{ transaction.phone }}
        </div>
        <div v-if="transaction.takeout_time">
          <span class="text-gray-500">Takeout time:</span>
          {{ transaction.takeout_time }}
        </div>
        <div v-if="transaction.address">
          <span class="text-gray-500">Address:</span>
          {{ transaction.address }}
        </div>
        <div v-if="transaction.message">
          <span class="text-gray-500">Message:</span>
          {{ transaction.message }}
        </div>
        <div v-if="transaction.type === type.delivery">
          <span class="text-gray-500">Delivery tip:</span>
          $ {{ transaction.delivery_tip }}
        </div>
        <div><span class="text-gray-500">Items:</span></div>
        <div class="space-y-3">
          <div
            v-for="(item, key) in groupItems(transaction.items)"
            :key="key"
            class="space-y-1"
          >
            <div>
              {{ item.item.name }}
              <span v-if="item.count > 1" class="ml-1">
                &times; {{ item.count }}
              </span>
            </div>
            <div class="text-gray-400 text-sm">{{ item.item.description }}</div>
          </div>
        </div>
      </div>
    </div>
    <audio id="new-order" src="/sound/new-order.ogg" preload="auto" />
    <audio id="takeout" src="/sound/takeout.ogg" preload="auto" />
  </admin-layout>
</template>

<script>
import moment from 'moment'
import Http from '@/Utils/Http'

export default {
  props: {
    update_interval: Number,
    type: Object,
    takeout_available_times: Array,
    reservations: Array,
  },
  data() {
    return {
      transactions: [],
      new_order: false,
      intervalId: null,
      showPlaySound: false,
      currentTime: this.getCurrentTime(),
      serveTime: this.getServeTime(),
      takeouts: [],
      stopNotification: false,
      timeoutId: null,
      takeout_available_after: null,
      upcomingReservations: [],
    }
  },
  mounted() {
    this.getTodayOrder()

    this.intervalId = setInterval(() => {
      this.getTodayOrder()
    }, this.update_interval * 2 * 1000)
  },
  beforeDestroy() {
    clearInterval(this.intervalId)
  },
  methods: {
    getTodayOrder() {
      Http.get(this.$route('admin.dashboard')).then(response => {
        this.transactions = response.data.transactions
        this.new_order = response.data.new_order
        this.takeout_available_after = response.data.takeout_available_after

        this.currentTime = this.getCurrentTime()
        this.serveTime = this.getServeTime()
        this.takeouts = this.getTakeouts()
        this.upcomingReservations = this.reservationsWithin30Minutes()
        this.notifyNewOrder()
      })
    },
    getCurrentTime() {
      return moment().format('hh:mm a')
    },
    getServeTime() {
      return moment()
        .add(this.takeout_available_after, 'minutes')
        .format('hh:mm a')
    },
    getTakeouts() {
      let newTakeouts = this.transactions.filter(
        transaction =>
          transaction.type === this.type.takeout &&
          moment(transaction.takeout_time, 'h:mma').isBetween(
            moment(),
            moment().add(10, 'minutes'),
          ),
      )

      let newTakeoutIds = newTakeouts.map(takeout => takeout.id)
      let ids = this.takeouts.map(takeout => takeout.id)

      if (!newTakeoutIds.every(value => ids.includes(value))) {
        let notification = document.getElementById('takeout')

        notification
          .play()
          .then(() =>
            setTimeout(() => {
              notification.load()
              notification.play()
            }, 1500),
          )
          .catch(() => (this.showPlaySound = true))
      }

      return newTakeouts
    },
    notifyNewOrder() {
      if (this.new_order) {
        document
          .getElementById('new-order')
          .play()
          .catch(() => (this.showPlaySound = true))
      }
    },
    isNew(createdAt) {
      if (
        moment(createdAt, 'YYYY-MM-DD hh:mm a').isAfter(
          moment().subtract(1, 'hours'),
        )
      ) {
        return true
      }
    },
    groupItems(items) {
      return Object.values(
        _.groupBy(items, item => item.name + item.description),
      )
        .map(group => ({
          count: group.length,
          item: group[0],
        }))
        .sort((a, b) => a.item.name.localeCompare(b.item.name))
    },
    endNotification() {
      Http.put(this.$route('admin.notification.end'))

      this.stopNotification = true

      clearTimeout(this.timeoutId)

      this.timeoutId = setTimeout(() => {
        this.stopNotification = false
      }, 3000)
    },
    reservationsWithin30Minutes() {
      return this.reservations
        .filter(reservation =>
          moment(reservation.reserved_at).isBetween(
            moment(),
            moment().add(30, 'minutes'),
          ),
        )
        .map(reservation => ({
          ...reservation,
          time: moment(reservation.reserved_at).format('hh:mm a'),
        }))
    },
  },
}
</script>
