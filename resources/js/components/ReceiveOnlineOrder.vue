<template>
  <div class="bg-gray-100 min-h-screen">
    <div class="space-y-4 p-8">
      <div
        class="flex flex-col space-y-2 md:space-y-0 space-x-0 md:flex-row md:space-x-2"
      >
        <button class="btn" @click="alarmTest">Alarm Test</button>
        <audio
          ref="alarm"
          src="/sound/jingle-bells-sms.ogg"
          preload="auto"
          muted="muted"
        />
        <button class="btn" @click="messageTest">Message Test</button>
      </div>
      <div v-if="message">
        <span class="bg-green-100 px-4 py-3 rounded text-green-800 w-auto">
          {{ message }}
        </span>
      </div>
      <div class="font-bold py-2 text-xl">Today's orders</div>
      <div class="grid gap-4 grid-cols-1 lg:grid-cols-2">
        <div
          v-for="transaction in transactionData"
          :key="transaction.id"
          class="bg-white border gray-800 p-4 rounded shadow space-y-4"
        >
          <div class="flex items-center">
            <span class="text-gray-500">Order Number:</span>
            {{ transaction.id }}
            <span
              v-if="transaction.new"
              class="bg-green-100 font-bold ml-2 px-4 py-1 rounded-full text-green-600 text-xs"
            >
              New
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
          <div v-else-if="transaction.address">
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
          <div>
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
    </div>
  </div>
</template>

<script>
export default {
  props: {
    transactions: Array,
  },
  data() {
    return {
      transactionData: this.transactions,
      message: null,
    }
  },
  mounted() {
    document.title = 'Matsu Sushi'

    Echo.channel('orders').listen('OrderPlaced', ({ order }) => {
      if (order === 'test') {
        this.message = 'Online order messaging ready.'

        setTimeout(() => {
          this.message = null
        }, 3000)

        return
      }

      this.transactionData.unshift(order)

      this.$refs.alarm.play()

      setTimeout(() => {
        let transaction = this.transactionData.find(
          transaction => transaction.id === order.id
        )

        if (transaction) {
          transaction.new = false
        }
      }, 1000 * 60 * 30)
    })
  },
  methods: {
    alarmTest() {
      this.$refs.alarm.play()
    },
    messageTest() {
      axios.get('/message/test')
    },
  },
}
</script>
