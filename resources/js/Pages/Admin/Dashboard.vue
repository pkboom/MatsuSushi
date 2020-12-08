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
          <div v-if="showReload" class="ml-2">
            <button
              class="bg-matsu-blue-700 font-bold rounded text-white text-sm px-4 py-1 hover:cursor-pointer"
              @click="showReload = false"
            >
              Reload orders
            </button>
          </div>
        </div>
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
            v-else-if="isNew(transaction.formattedCreatedAt)"
            class="bg-green-100 font-bold ml-2 px-4 py-1 rounded-full text-green-600 text-xs"
          >
            new
          </span>
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
    <audio id="alarm" src="/sound/jingle-bells-sms.ogg" preload="auto" />
  </admin-layout>
</template>

<script>
import moment from 'moment'

export default {
  props: {
    transactions: Array,
    new_order: Boolean,
    new_reservation: Boolean,
    update_interval: Number,
  },
  data() {
    return {
      timeoutId: null,
      showReload: false,
    }
  },
  computed: {
    currentTime() {
      return moment().format('hh:mm a')
    },
  },
  mounted() {
    if (this.new_order) {
      document
        .getElementById('alarm')
        .play()
        .catch(error => (this.showReload = true))
    }

    this.timeoutId = setTimeout(() => {
      location.reload()
    }, this.update_interval * 1000)
  },
  beforeDestroy() {
    clearTimeout(this.timeoutId)
  },
  methods: {
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
  },
}
</script>
