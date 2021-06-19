<template>
  <admin-layout title="Dashboard">
    <div class="flex justify-between items-end mb-4">
      <div>
        <div class="flex items-baseline text-xl pb-1">
          <div class="font-bold whitespace-no-wrap">Today's orders</div>
          <div class="text-xs text-gray-400 px-1">({{ currentTime }})</div>
          <span v-if="takeout_available_after > takeout_available_times[0]" class="ml-2 text-red-600 text-xs">
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
        :href="$route('admin.reservations.edit', { reservation: reservation.id })"
        class="bg-white rounded p-4 shadow gray-800 space-y-4"
      >
        <span class="bg-orange-100 font-bold mr-2 px-4 py-1 rounded-full text-orange-600 text-xs">Reservation</span>
        <span class="leading-tight">
          {{ reservation.first_name }}
          {{ reservation.last_name }}
          <span class="whitespace-no-wrap">{{ reservation.time }}</span>
          <span v-if="reservation.message">"{{ reservation.message }}"</span>
        </span>
      </inertia-link>
    </div>
    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 mb-4">
      <div v-for="takeout in takeouts" :key="takeout.id" class="bg-white rounded p-4 shadow gray-800 space-y-4">
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
        :class="{
          'cursor-pointer hover:shadow-xl': transaction.status === status.succeeded,
        }"
        @click="acceptOrder(transaction)"
      >
        <div class="flex items-center">
          <span class="text-gray-500">Status:</span>
          <span
            v-if="transaction.status === status.accepted"
            class="bg-purple-100 font-bold ml-2 px-4 py-1 rounded-full text-purple-600 text-xs"
          >
            accepted
          </span>
          <span
            v-else-if="transaction.status === status.succeeded"
            class="bg-green-100 font-bold ml-2 px-4 py-1 rounded-full text-green-600 text-xs"
          >
            new
          </span>
          <span v-else class="bg-red-100 font-bold ml-2 px-4 py-1 rounded-full text-red-600 text-xs">
            {{ transaction.status }}
          </span>
        </div>
        <div>
          <span class="text-gray-500">Order no.</span>
          {{ transaction.id }}
          <span class="text-gray-400 text-sm">({{ transaction.formattedCreatedAt.slice(11) }})</span>
        </div>
        <div>
          <span class="text-gray-500">Total:</span>
          $ {{ transaction.total }}
        </div>
        <div>
          <span class="text-gray-500">Restaurant tip:</span>
          $ {{ transaction.tip }}
        </div>
        <div>
          <span class="text-gray-500">Delivery tip:</span>
          $ {{ transaction.delivery_tip }}
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
          <span class="leading-tight">{{ transaction.message }}</span>
        </div>
        <div><span class="text-gray-500">Items:</span></div>
        <div class="space-y-4">
          <div v-for="(item, key) in groupItems(transaction.items)" :key="key" class="space-y-1">
            <div>
              {{ item.item.name }}
              <span v-if="item.count > 1" class="ml-1">&times; {{ item.count }}</span>
            </div>
            <div v-if="item.item.category_id === show_description_category" class="text-gray-500">
              {{ item.item.description }}
            </div>
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
    status: Object,
    takeout_available_times: Array,
    reservations: Array,
    show_description_category: Number,
  },
  data() {
    return {
      transactions: [],
      intervalId: null,
      showPlaySound: false,
      currentTime: this.getCurrentTime(),
      serveTime: this.getServeTime(),
      takeouts: [],
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
          transaction.status === this.status.accepted &&
          moment(transaction.takeout_time, 'h:mma').isBetween(moment(), moment().add(10, 'minutes')),
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
      let newOrder = this.transactions.find(transaction => transaction.status === this.status.succeeded)

      if (newOrder) {
        document
          .getElementById('new-order')
          .play()
          .catch(() => (this.showPlaySound = true))
      }
    },
    groupItems(items) {
      return Object.values(_.groupBy(items, item => item.id))
        .map(group => ({
          count: group.length,
          item: group[0],
        }))
        .sort((a, b) => a.item.category_id - b.item.category_id)
    },
    acceptOrder(transaction) {
      if (transaction.status === this.status.succeeded) {
        Http.put(this.$route('order.accept', transaction.id))

        transaction.status = this.status.accepted
      }
    },
    reservationsWithin30Minutes() {
      return this.reservations
        .filter(reservation => moment(reservation.reserved_at).isBetween(moment(), moment().add(30, 'minutes')))
        .map(reservation => ({
          ...reservation,
          time: moment(reservation.reserved_at).format('hh:mm a'),
        }))
    },
  },
}
</script>
