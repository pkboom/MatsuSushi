<template>
  <front-layout title="Cart">
    <div class="p-8 max-w-xl mx-auto w-full">
      <div class="font-semibold text-xl py-4 border-b">
        Checkout
      </div>
      <div v-if="online_order_enabled" class="bg-white overflow-hidden w-full">
        <div class="col-md-8">
          <form id="payment-form">
            <div class="mb-2 w-full">
              <input
                type="text"
                id="email"
                placeholder="Email address"
                class="border border-gray-500 p-2 rounded w-full"
              />
            </div>
            <div
              id="card-element"
              class="border rounded p-2 border-gray-500 mb-2"
            >
              <!--Stripe.js injects the Card Element-->
            </div>
            <p id="card-error" role="alert" class="text-red-500"></p>
            <div class="flex flex-col items-end py-4 space-y-4">
              <div>
                <span class="text-gray-500">Subtotal:</span>
                $ {{ payDetail.subtotal }}
              </div>
              <div>
                <span class="text-gray-500">GST/HST:</span>
                $ {{ payDetail.tax }}
              </div>
              <div>
                <span class="text-gray-500">Tip:</span>
                $ {{ payDetail.tip }}
              </div>
              <div>
                <span class="text-gray-500">Total:</span>
                <span class="text-red-600 font-bold">
                  $ {{ payDetail.total }}
                </span>
              </div>
            </div>
            <div class="flex justify-end mt-2">
              <button id="submit" class="btn">
                <div class="spinner hidden" id="spinner"></div>
                <span id="button-text">
                  Place your order
                </span>
              </button>
            </div>
          </form>
        </div>
      </div>
      <div v-else class="bg-white overflow-hidden pt-2 text-lg w-full">
        Sorry, online order is temporarily unavailable.
      </div>
    </div>
  </front-layout>
</template>

<script>
import Errors from '@/Utils/Errors'

export default {
  props: {
    online_order_enabled: Number,
    stripeKey: String,
    payDetail: Object,
  },
  data() {
    return {
      errors: new Errors(),
    }
  },
  mounted() {
    var stripe = Stripe(this.stripeKey)

    axios.post('/checkout').then(({ data }) => {
      var elements = stripe.elements()
      var style = {
        base: {
          color: '#32325d',
          fontFamily: 'Arial, sans-serif',
          fontSmoothing: 'antialiased',
          fontSize: '16px',
          '::placeholder': {
            color: '#32325d',
          },
        },
        invalid: {
          fontFamily: 'Arial, sans-serif',
          color: '#fa755a',
          iconColor: '#fa755a',
        },
      }
      var card = elements.create('card', { style: style })
      // Stripe injects an iframe into the DOM
      card.mount('#card-element')
      card.on('change', function(event) {
        // Disable the Pay button if there are no card details in the Element
        document.querySelector('button').disabled = event.empty
        document.querySelector('#card-error').textContent = event.error
          ? event.error.message
          : ''
      })
      var form = document.getElementById('payment-form')

      var self = this
      form.addEventListener('submit', function(event) {
        event.preventDefault()
        // Complete payment when the submit button is clicked
        self.payWithCard(stripe, card, data.clientSecret)
      })
    })
  },
  methods: {
    payWithCard(stripe, card, clientSecret) {
      var self = this
      self.loading(true)
      stripe
        .confirmCardPayment(clientSecret, {
          receipt_email: document.getElementById('email').value,
          payment_method: {
            card: card,
          },
        })
        .then(function(result) {
          if (result.error) {
            // Show error to your customer
            self.showError(result.error.message)
          } else {
            // The payment succeeded!
            self.orderComplete(result.paymentIntent.id)
          }
        })
    },
    orderComplete(paymentIntentId) {
      var self = this
      this.loading(false)

      location.href = '/thankyou/' + paymentIntentId
    },
    // Show the customer the error from Stripe if their card fails to charge
    showError(errorMsgText) {
      var self = this
      this.loading(false)
      var errorMsg = document.querySelector('#card-error')
      errorMsg.textContent = errorMsgText
      setTimeout(function() {
        errorMsg.textContent = ''
      }, 4000)
    },
    // Show a spinner on payment submission
    loading(isLoading) {
      if (isLoading) {
        // Disable the button and show a spinner
        document.querySelector('button').disabled = true
        document.querySelector('#spinner').classList.remove('hidden')
        document.querySelector('#button-text').classList.add('hidden')
      } else {
        document.querySelector('button').disabled = false
        document.querySelector('#spinner').classList.add('hidden')
        document.querySelector('#button-text').classList.remove('hidden')
      }
    },
  },
}
</script>
