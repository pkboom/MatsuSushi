<template>
  <back-layout title="Dashboard">
    <form class="max-w-md" @submit.prevent="submit">
      <input
        v-model="search"
        class="w-full bg-white leading-normal shadow rounded px-6 py-3 rounded-r focus:shadow-outline"
        autocomplete="off"
        type="text"
        name="search"
        placeholder="Search for user…"
      />
    </form>
    <div class="mt-12 flex justify-between">
      <h2 class="text-lg">Upcoming Classes</h2>
    </div>
    <div class="mt-6 bg-white rounded shadow overflow-x-auto">
      <table class="w-full">
        <tr>
          <th class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap">
            Course
          </th>
          <th class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap">
            Date/Time
          </th>
          <th class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap">
            Location
          </th>
          <th
            class="text-left px-6 pt-6 pb-4 font-bold whitespace-no-wrap"
            colspan="2"
          >
            Instructors
          </th>
        </tr>
        <tr
          v-for="class_ in classes"
          :key="class_.id"
          class="hover:bg-gray-100 focus:bg-gray-100 cursor-pointer"
          @click="$inertia.visit($route('classes.show', class_.id))"
        >
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            <div class="max-w-xs truncate">{{ class_.course.name }}</div>
            <div class="mt-1 text-gray-600 text-sm flex">
              <div>
                Capacity:
                <span class="ml-0.5">{{ class_.capacity }}</span>
              </div>
              <div class="ml-3">
                Filled:
                <span class="ml-0.5">{{ class_.students }}</span>
              </div>
              <div class="ml-3">
                Available:
                <span class="ml-0.5">
                  {{ class_.capacity - class_.students }}
                </span>
              </div>
            </div>
          </td>
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            <div>{{ class_.session.date }}</div>
            <div class="mt-1 text-gray-600 text-sm">
              {{ class_.session.time }}
            </div>
          </td>
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            <div>{{ class_.location.name }}</div>
            <div v-if="class_.room" class="mt-1 text-gray-600 text-sm">
              ({{ class_.room.name }})
            </div>
          </td>
          <td class="border-t px-6 py-4 whitespace-no-wrap">
            {{ class_.session.instructors }}
          </td>
          <td class="border-t px-4 align-middle w-min">
            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
          </td>
        </tr>
        <tr v-if="classes.length === 0">
          <td class="border-t px-6 py-4" colspan="5">
            No upcoming classes found.
          </td>
        </tr>
      </table>
    </div>
  </back-layout>
</template>

<script>
export default {
  props: {
    classes: Array,
  },
  data: () => ({ search: null }),
  methods: {
    submit() {
      this.$inertia.visit(this.$route('users', { search: this.search }))
    },
  },
}
</script>
