<template>
  <admin-layout title="Dashboard">
    <!-- <a href="/admin/kakao/login" class="btn">Log into kakao</a> -->
    <!-- <a href="/admin/kakao/send" class="btn">Send message</a> -->
    <div class="flex justify-between items-end mb-4">
      <div>
        <div class="flex font-bold items-center text-xl pb-1">
          Today's orders
          <span
            v-if="newReservation"
            class="bg-orange-100 font-bold ml-4 px-4 py-1 rounded-full text-orange-600 text-xs"
          >
            New Reservation
          </span>
        </div>
        <div class="flex font-medium items-center text-md text-pink-500">
          (Don't refresh the page. If status is
          <span
            class="bg-green-100 font-bold ml-1 px-4 py-1 rounded-full text-green-600 text-xs"
          >
            new
          </span>
          , you may serve.)
        </div>
      </div>
      <div
        class="flex flex-col space-y-2 md:space-y-0 space-x-0 md:flex-row md:space-x-2"
      >
        <button class="btn" @click="alarmTest">Alarm Test</button>
        <button class="btn" @click="toggleEnable">
          {{ enabled ? 'Disable Online Order' : 'Enable Online Order' }}
        </button>
      </div>
    </div>
    <div class="grid gap-4 grid-cols-1 lg:grid-cols-2">
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
          <span
            v-else-if="isNew(transaction.created_at)"
            class="bg-green-100 font-bold ml-2 px-4 py-1 rounded-full text-green-600 text-xs"
          >
            new
          </span>
          <span
            v-else
            class="bg-gray-400 font-bold ml-2 px-4 py-1 rounded-full text-white text-xs"
          >
            served
          </span>
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
        <div>
          <span class="text-gray-500">Total:</span>
          $ {{ transaction.total }}
        </div>
        <div>
          <span class="text-gray-500">Created at:</span>
          {{ transaction.created_at }}
        </div>
        <div v-if="transaction.message">
          <span class="text-gray-500">Message:</span>
          {{ transaction.message }}
        </div>
        <div><span class="text-gray-500">Items:</span></div>
        <div class="space-y-3">
          <div
            v-for="(item, key) in transaction.items"
            :key="'item' + key"
            class="space-y-1"
          >
            <div>{{ item.name }}</div>
            <div class="text-gray-400 text-sm">{{ item.description }}</div>
          </div>
        </div>
      </div>
    </div>

    <audio id="alarm" src="/sound/jingle-bells-sms.ogg" preload="auto" />
  </admin-layout>
</template>

<script>
import moment from 'moment'

export default {
  props: {
    online_order_enabled: Number,
  },
  data() {
    return {
      transactions: null,
      enabled: this.online_order_enabled,
      newReservation: false,
    }
  },
  mounted() {
    this.getTodayOrders()

    Echo.channel('matsusushi')
      .listen('OrderPlaced', () => {
        document.getElementById('alarm').play()

        this.getTodayOrders()
      })
      .listen('ReservationComplete', () => {
        this.newReservation = true
      })

    this.getTodayOrdersIntervalId = setInterval(
      this.getTodayOrders,
      moment.duration('3', 'minutes')
    )
  },
  beforeDestroy() {
    clearInterval(this.getTodayOrdersIntervalId)
  },
  methods: {
    alarmTest() {
      document.getElementById('alarm').play()
    },
    toggleEnable() {
      axios.get('/admin/toggle/online/order').then(response => {
        this.enabled = response.data.online_order_enabled

        this.$page.flash.success =
          'Online order ' +
          (response.data.online_order_enabled ? 'enabled' : 'disabled')
      })
    },
    getTodayOrders() {
      axios.get(this.$route('admin.dashboard')).then(response => {
        this.transactions = response.data
      })
    },
    isNew(createdAt) {
      if (
        moment(createdAt, 'YYYY-MM-DD hh:mm a').isAfter(
          moment().subtract(1, 'hours')
        )
      ) {
        return true
      }
    },
  },
}
</script>
