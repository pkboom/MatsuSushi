<template>
  <admin-layout title="Tips">
    <div class="-mx-2 md:-mx-6">
      <div class="grid gap-2 grid-cols-7 text-sm">
        <div
          v-for="day in daysOfWeek"
          :key="day"
          class="bg-white text-matsu-blue-700 p-4 rounded"
        >
          {{ day }}
        </div>
        <div
          v-for="(tips, date) in dates"
          :key="date"
          class="relative bg-white p-4 rounded space-y-2"
        >
          <div v-if="today === date" class="text-red-500 font-bold">
            {{ date }}
          </div>
          <div v-else class="text-gray-500">
            {{ date }}
          </div>
          <div v-if="tips.tip" class="space-y-2">
            <div>Tip: ${{ tips.tip }}</div>
            <div>Delivery: ${{ tips.delivery_tip }}</div>
          </div>
        </div>
      </div>
    </div>
  </admin-layout>
</template>

<script>
export default {
  props: {
    dates: Object,
    today: String,
  },
  data() {
    return {
      daysOfWeek: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
    }
  },
}
</script>
