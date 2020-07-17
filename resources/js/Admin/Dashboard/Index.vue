<template>
  <admin-layout title="Dashboard">
    <!-- <a href="/admin/kakao/login" class="btn">Log into kakao</a> -->
    <!-- <a href="/admin/kakao/send" class="btn">Send message</a> -->
    <div class="space-y-4">
      <div
        class="flex flex-col space-y-2 md:space-y-0 space-x-0 md:flex-row md:space-x-2"
      >
        <button class="btn" @click="alarmTest">Alarm Test</button>
        <button class="btn" @click="messageTest">Message Test</button>
        <audio ref="alarm" src="/sound/jingle-bells-sms.ogg" preload="auto" />
        <button class="btn" @click="toggleEnable">
          {{ enabled ? 'Disable Online Order' : 'Enable Online Order' }}
        </button>
      </div>
      <div class="font-bold py-2 text-xl">Latest orders</div>
      <div class="grid gap-4 grid-cols-1 lg:grid-cols-2">
        <div
          v-for="transaction in transactions"
          :key="transaction.id"
          class="bg-white rounded p-4 shadow gray-800 space-y-2"
        >
          <div>Name: {{ transaction.name }}</div>
          <div>Email: {{ transaction.email }}</div>
          <div>Phone: {{ transaction.phone }}</div>
          <div>Address: {{ transaction.address }}</div>
          <div>Subtotal: $ {{ transaction.subtotal }}</div>
          <div>Tip: $ {{ transaction.tip }}</div>
          <div>Total: $ {{ transaction.total }}</div>
          <div>Message: {{ transaction.message }}</div>
          <div>Status: {{ transaction.status }}</div>
          <div>Created at: {{ transaction.created_at }}</div>
        </div>
      </div>
    </div>
  </admin-layout>
</template>

<script>
import Http from '@/Utils/Http'

export default {
  props: {
    transactions: Array,
    online_order_enabled: Number,
  },
  data() {
    return {
      transactionData: this.transactions,
      enabled: this.online_order_enabled,
    }
  },
  mounted() {
    Echo.channel('orders').listen('OrderPlaced', e => {
      this.$page.flash.success = 'Message test. Good day!'
    })
  },
  methods: {
    alarmTest() {
      this.$refs.alarm.play()
    },
    messageTest() {
      Http.get('/admin/message/test')
    },
    toggleEnable() {
      Http.get('/admin/toggle/online/order').then(response => {
        this.enabled = response.data.online_order_enabled

        this.$page.flash.success =
          'Online order ' +
          (response.data.online_order_enabled ? 'enabled' : 'disabled')
      })
    },
  },
}
</script>
