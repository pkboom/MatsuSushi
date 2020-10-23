<template>
  <admin-layout title="Reports">
    <div class="mb-8">
      <breadcrumb name="Reports" />
    </div>
    <div class="grid grid-cols-3 gap-8">
      <inertia-link
        class="rounded bg-white p-4 shadow hover:shadow-lg"
        :href="$route('admin.reports.tips')"
      >
        Tips
      </inertia-link>
    </div>
  </admin-layout>
</template>

<script></script>
