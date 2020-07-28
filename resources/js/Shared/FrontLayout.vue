<template>
  <div>
    <div class="flex flex-col">
      <div class="min-h-screen flex flex-col">
        <div class="md:flex z-10">
          <div
            class="bg-gray-900 flex items-center justify-between md:flex-shrink-0 md:w-56 px-6"
          >
            <div class="md:w-full flex justify-center">
              <a
                href="/"
                class="font-semibold font-serif py-2 text-white text-xl tracking-wide"
              >
                Matsu Sushi
              </a>
            </div>
            <div
              class="hamburger hamburger--squeeze inline-block md:hidden"
              :class="{ 'is-active': open }"
              style="z-index: 99999;"
              @click="open = !open"
            >
              <div class="hamburger-box">
                <div class="hamburger-inner" />
              </div>
            </div>
            <div
              class="absolute top-0 inset-x-0 bg-gray-800"
              :class="{ hidden: !open }"
              style="z-index: 99998;"
            >
              <div>
                <front-menu
                  class="flex flex-col items-center my-16 space-y-8 pt-1 text-white text-base"
                />
              </div>
            </div>
          </div>
          <div
            class="bg-gray-900 hidden md:flex md:items-center md:justify-end md:px-10 py-4 w-full"
          >
            <front-menu class="flex space-x-7 pt-1 text-white text-base" />
          </div>
        </div>
        <slot />
        <div
          v-if="
            isNotUrl(
              'gallery',
              'order',
              'cart',
              'start/your/order',
              'checkout',
              'thankyou*'
            )
          "
          id="bottom"
          class="flex flex-col justify-center"
        >
          <div
            class="border-2 border-white flex flex-col items-center md:mx-auto mx-3 pb-14 pt-12 px-12 space-y-4 text-white"
          >
            <div class="text-4xl text-center uppercase">
              107 Hunter St. East Suite 102
            </div>
            <div class="text-lg text-center uppercase">
              Peterborough, ON K9H 1G7
            </div>
          </div>
          <a
            href="https://www.google.com/maps/place/Matsu+Sushi+(East+City)+Japanese+and+Korean+Restaurant/@44.3066026,-78.3089279,17z/data=!4m13!1m7!3m6!1s0x89d58cb8987bc695:0x9a6cf675fb1aec67!2s102+Hunter+St+E,+Peterborough,+ON+K9H+1G7!3b1!8m2!3d44.3067303!4d-78.3093375!3m4!1s0x0:0xaeb3dad2b256e13c!8m2!3d44.3064712!4d-78.3088705"
            target="_blank"
            class="-mt-7 bg-white focus:bg-blue-900 focus:text-white hover:bg-blue-900 hover:text-white mx-auto px-12 py-4 text-blue-900 text-lg uppercase"
          >
            View Map
          </a>
          <div
            class="gap-8 grid grid-cols-1 md:grid-cols-3 md:mt-8 p-16 text-white w-full"
          >
            <div class="text-4xl font-serif whitespace-no-wrap mx-auto">
              Matsu Sushi
            </div>
            <div class="space-y-2 md:space-y-4 mx-auto">
              <div class="text-2xl text-center">
                Contact
              </div>
              <div class="text-md text-center">
                (705) 760-9484
              </div>
            </div>
            <div class="space-y-2 md:space-y-4 mx-auto">
              <div class="text-2xl text-center">
                Restaurant Hours
              </div>
              <div class="text-md text-center">
                <div>
                  Mon-Sun 11:30 AM ~ 10:00 PM
                </div>
                <div>
                  (Tuesdays closed)
                </div>
              </div>
            </div>
          </div>
          <div class="flex font-serif justify-center text-sm text-white w-full">
            Matsu Sushi &#9400; 2020. All rights reserved.
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { isNotUrl } from '@/Utils/Helpers'

export default {
  props: {
    title: String,
  },
  data() {
    return {
      count: 0,
      open: false,
      lgWidth: 768,
    }
  },
  mounted() {
    this.updatePageTitle(this.title)

    this.fetchImage()
  },
  methods: {
    isNotUrl,
    updatePageTitle(title) {
      document.title = title ? `${title} | Matsu Sushi` : 'Matsu Sushi'
    },
    fetchImage() {
      let bottom = document.getElementById('bottom')

      let imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            if (window.innerWidth >= this.lgWidth) {
              bottom.style.backgroundImage =
                'linear-gradient(rgba(0, 0, 0, 0), rgba(42, 67, 101, 1)), url(\'/images/bottom.jpg\')'
            } else {
              bottom.style.backgroundImage =
                'linear-gradient(rgba(0, 0, 0, 0), rgba(42, 67, 101, 1)), url(\'/images/bottom-half.jpg\')'
            }
          }
        })
      })

      bottom && imageObserver.observe(bottom)
    },
  },
}
</script>

<style >
#bottom {
  height: 800px;
  background-size: cover;
  background-position: center top;
}
</style>