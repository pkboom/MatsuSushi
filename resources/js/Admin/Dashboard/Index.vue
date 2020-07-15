<template>
  <admin-layout title="Dashboard">
    <!-- <a href="/admin/kakao/login" class="btn">Log into kakao</a>
    <a href="/admin/kakao/send" class="btn">Send message</a> -->
    <button class="btn" @click="alarmTest">Alarm Test</button>
    <button class="btn ml-2" @click="messageTest">Message Test</button>
    <audio ref="alarm" src="/sound/jingle-bells-sms.ogg" preload="auto" />
    <div>
      {{ message }}
    </div>
  </admin-layout>
</template>

<script>
import Http from '@/Utils/Http'

export default {
  data() {
    return {
      message: null,
    }
  },
  mounted() {
    Echo.channel('orders').listen('OrderPlaced', e => {
      this.message = 'Message test. Good day!'
    })
  },
  methods: {
    alarmTest() {
      this.$refs.alarm.play()
    },
    messageTest() {
      Http.get('/admin/message-test')
    },
  },
}
</script>
