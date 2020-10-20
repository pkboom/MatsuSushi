<template>
  <front-layout :title="reservation.name + ' Reservation'">
    <div
      class="my-8 p-8 max-w-2xl mx-auto space-y-4 rounded bg-matsu-blue-50 shadow-lg"
    >
      <div class="text-xl border-b-2 border-gray-400 py-2">
        Thank you!
      </div>
      <div class="space-y-8">
        <div>
          <span class="text-gray-500">Name:</span>
          {{ reservation.name }}
        </div>
        <div>
          <span class="text-gray-500">Phone:</span>
          {{ reservation.phone }}
        </div>
        <div>
          <span class="text-gray-500">People:</span>
          {{ reservation.people }}
        </div>
        <div>
          <span class="text-gray-500">Reserved at:</span>
          {{ reservation.reserved_at }}
        </div>
        <div v-if="reservation.message">
          <span class="text-gray-500">Message:</span>
          {{ reservation.message }}
        </div>
        <div>
          If you have any questions, call us at
          <a
            href="tel:7057609484"
            class="inline-block underline text-matsu-blue-600 font-bold"
          >
            705-760-9484
          </a>
          .
        </div>
      </div>
    </div>
  </front-layout>
</template>

<script>
export default {
  props: {
    reservation: Object,
  },
}
</script>
