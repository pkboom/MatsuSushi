<template>
  <admin-layout title="Dashboard">
    <!-- <a href="/admin/kakao/login" class="btn">Log into kakao</a> -->
    <!-- <a href="/admin/kakao/send" class="btn">Send message</a> -->
    <div class="space-y-4">
      <div>
        <button class="btn" @click="alarmTest">Alarm Test</button>
      </div>
      <div>
        <button class="btn" @click="messageTest">Message Test</button>
        <audio ref="alarm" src="/sound/jingle-bells-sms.ogg" preload="auto" />
      </div>
      <div>
        <button class="btn" @click="toggleOnlineOrder">
          {{
            onlineOrderButton ? 'Disable Online Order' : 'Enable Online Order'
          }}
        </button>
      </div>
      <div>
        {{ message }}
      </div>
    </div>
  </admin-layout>
</template>

<script>
import Http from '@/Utils/Http'

export default {
  props: {
    onlineOrder: Number,
  },
  data() {
    return {
      message: null,
      onlineOrderButton: this.onlineOrder,
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
      Http.get('/admin/message-test')
    },
    toggleOnlineOrder() {
      Http.get('/admin/toggle-online-order').then(response => {
        this.onlineOrderButton = response.data.onlineOrder

        this.$page.flash.success =
          'Online order ' + (response.data.onlineOrder ? 'enabled' : 'disabled')
      })
    },
  },
}
</script>
