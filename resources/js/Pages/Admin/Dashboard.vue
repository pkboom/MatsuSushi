<template>
  <admin-layout title="Dashboard">
    <div class="flex justify-between items-end mb-4">
      <div>
        <div class="flex items-baseline text-xl pb-1">
          <div class="font-bold whitespace-no-wrap">Today's orders</div>
          <div class="text-xs text-gray-400 px-1">({{ currentTime }})</div>
          <div
            v-if="new_reservation"
            class="bg-orange-100 font-bold ml-2 px-4 py-1 rounded-full text-orange-600 text-xs"
          >
            Reservation
          </div>
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
    <audio id="notification" src="/sound/jingle-bells-sms.ogg" preload="auto" />
  </admin-layout>
</template>

<script>
import moment from 'moment'
import Http from '@/Utils/Http'

export default {
  props: {
    update_interval: Number,
    type: Object,
  },
  data() {
    return {
      transactions: [],
      new_order: false,
      new_reservation: false,
      intervalId: null,
      showPlaySound: false,
      currentTime: this.getCurrentTime(),
    }
  },
  mounted() {
    this.getTodayOrder()

    this.intervalId = setInterval(() => {
      this.getTodayOrder()
    }, this.update_interval * 1000)
  },
  beforeDestroy() {
    clearInterval(this.intervalId)
  },
  methods: {
    getTodayOrder() {
      Http.get(this.$route('admin.dashboard')).then(response => {
        this.transactions = response.data.transactions
        this.new_order = response.data.new_order
        this.new_reservation = response.data.new_reservation
        this.currentTime = this.getCurrentTime()

        this.$nextTick(() => {
          this.handleNewOrder()
        })
      })
    },
    getCurrentTime() {
      return moment().format('hh:mm a')
    },
    handleNewOrder() {
      if (this.new_order) {
        document
          .getElementById('notification')
          .play()
          .catch(() => (this.showPlaySound = true))

        return
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
      Http.put(this.$route('admin.notification.end')).then(
        () => (this.$page.flash.success = 'Notification stopped.'),
      )
    },
  },
}
</script>
