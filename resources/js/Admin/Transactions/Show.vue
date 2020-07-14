<template>
  <admin-layout title="Transaction">
    <div class="mb-8">
      <breadcrumb
        :previous-url="$route('admin.transactions')"
        previous-name="Transaction"
        :name="transaction.name"
      />
    </div>
    <div class="bg-white max-w-2xl overflow-hidden rounded shadow">
      <div class="p-8 rounded space-y-4">
        <div class="">Stripe Id: {{ transaction.stripe_id }}</div>
        <div class="">Name: {{ transaction.name }}</div>
        <div class="">Email: {{ transaction.email }}</div>
        <div class="">Phone: {{ transaction.phone }}</div>
        <div class="">Address: {{ transaction.address }}</div>
        <div class="">Subtotal: $ {{ transaction.subtotal }}</div>
        <div class="">Tip: {{ transaction.tip }}%</div>
        <div class="">Total: $ {{ transaction.total }}</div>
        <div class="">Request: {{ transaction.request }}</div>
        <div class="">Status: {{ transaction.status }}</div>
      </div>
    </div>
  </admin-layout>
</template>

<script>
export default {
  props: {
    transaction: Object,
  },
  data() {
    return {
      sending: false,
    }
  },
  methods: {},
}
</script>
