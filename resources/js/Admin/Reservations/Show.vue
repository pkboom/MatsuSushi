<template>
  <div class="w-full h-full p-1 lg:p-4">
    <div class="grid gap-2 grid-cols-7 mt-4 text-sm">
      <div v-for="day in daysOfWeek" :key="day" class="bg-white p-4 rounded">
        {{ day }}
      </div>
      <div
        v-for="(reservations, date) in dates"
        :key="date"
        class="relative bg-white p-4 rounded space-y-2"
      >
        <div v-if="today === date" class="text-red-500 font-bold">
          {{ date }}
        </div>
        <div v-else class="text-gray-500">
          {{ date }}
        </div>
        <div v-for="(reservation, index) in reservations" :key="reservation.id">
          <hr
            v-if="index > 0"
            class="my-2 border-2 border-blue-400 rounded w-10"
          />
          <div class="rounded space-y-2 overflow-hidden">
            <inertia-link
              :href="$route('admin.reservations.edit', reservation.id)"
              class="block underline leading-tight text-blue-800"
            >
              {{ reservation.name }}
            </inertia-link>
            <div class="">
              {{ reservation.people }}
            </div>
            <div class="">
              {{ reservation.time }}
            </div>
            <div class="">
              {{ reservation.phone }}
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
