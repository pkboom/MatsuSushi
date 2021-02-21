<template>
  <front-layout>
    <div
      id="top"
      class="relative flex items-center justify-center bg-center bg-cover h-screen"
    >
      <div v-if="title" class="absolute right-4 top-20">
        <div class="flex flex-col">
          <img src="/images/promotion.jpg" alt="" class="hidden lg:block" />
          <div
            class="bg-white flex flex-col justify-between p-6 lg:p-8 w-64 lg:w-80 space-y-0 lg:space-y-4"
          >
            <div>
              <div
                class="font-medium lg:font-bold text-lg lg:text-2xl underline"
              >
                {{ title }}
              </div>
              <div
                class="leading-4 lg:leading-6 mt-2 lg:mt-4 text-gray-700 text-sm lg:text-base"
                v-html="body"
              />
            </div>
            <div v-if="order_now" class="flex items-center">
              <inertia-link
                :href="$route('order')"
                class="bg-red-500 inline-block px-4 lg:px-8 py-2 lg:py-3 rounded text-white font-bold mt-4 lg:mt-0"
              >
                Order Now
              </inertia-link>
            </div>
          </div>
        </div>
      </div>
      <div
        class="font-bold font-serif text-3xl md:text-5xl text-white tracking-widest"
      >
        Matsu Sushi
      </div>
    </div>
    <div class="py-10 md:py-32 bg-gray-100">
      <div class="font-thin mb-8 text-4xl text-center text-gray-900 upperclass">
        WELCOME
        <span class="hidden md:inline">TO MATSU SUSHI</span>
      </div>
      <div
        class="font-serif leading-9 max-w-3xl md:px-0 mx-auto px-4 text-center text-md md:text-xl"
      >
        Matsu Sushi has worked passionately to provide guests with a unique
        Japanese & Korean dining experience in Peterborough. Our real passion is
        making sure the quality of food and service is unmatched and everyone
        feels at home.
      </div>
    </div>
    <div
      class="flex flex-col md:flex-row h-60 my-8 md:my-12 overflow-y-auto overflow-x-hidden md:overflow-y-visible"
    >
      <div
        class="w-full md:w-1/3 flex flex-col justify-center items-center space-y-2 md:space-y-4 md:-mr-10"
      >
        <div
          class="text-lg md:text-3xl flex justify-center items-center space-x-1 md:space-x-2"
        >
          <span class="font-bold">{{ reviews.rating }}</span>
          <img src="/images/star.png" class="w-4 md:w-5" />
          <img src="/images/star.png" class="w-4 md:w-5" />
          <img src="/images/star.png" class="w-4 md:w-5" />
          <img src="/images/star.png" class="w-4 md:w-5" />
          <img src="/images/half-star.png" class="w-4 md:w-5" />
        </div>
        <div class="text-lg md:text-2xl">
          {{ reviews.user_ratings_total }} Google Reviews
        </div>
      </div>
      <div class="w-full md:w-2/3 mt-4 md:mt-0">
        <div class="w-full relative flex">
          <div
            v-for="(review, key) in reviewData"
            :key="key"
            class="absolute w-full px-2 py-4 md:px-12 md:py-8 text-gray-900"
          >
            <transition
              enter-active-class="transition duration-1000 ease-out"
              enter-class="transform opacity-0 translate-x-20"
              enter-to-class="transform opacity-100 translate-x-0"
              leave-active-class="transition duration-1000 ease-out"
              leave-class="transform opacity-100 translate-x-0"
              leave-to-class="transform opacity-0 -translate-x-20"
            >
              <div v-if="key === count % 5" class="space-y-4">
                <div class="text-center font-bold text-base md:text-xl">
                  {{ review.author_name }}
                </div>
                <div class="flex justify-center space-x-2">
                  <img
                    v-for="(rating, ratingKey) in review.rating"
                    :key="ratingKey"
                    src="/images/star.png"
                    class="w-4 md:w-5"
                  />
                </div>
                <div
                  class="leading-normal mx-6 md:px-0 text-gray-700 italic text-sm md:text-base"
                >
                  "{{ review.text }}"
                </div>
              </div>
            </transition>
          </div>
        </div>
      </div>
    </div>
    <div id="bottom" class="flex flex-col justify-center">
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
        href="https://g.page/matsusushionhunter"
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
          <div class="text-md text-center space-y-2">
            <div>
              Mon-Sat 11:30 AM ~ 10:00 PM
            </div>
            <div>
              Sun 12:00 PM ~ 10:00 PM
            </div>
            <div>
              (Tuesdays closed)
            </div>
          </div>
        </div>
      </div>
      <div class="flex font-serif justify-center text-sm text-white w-full">
        Matsu Sushi &#169; 2020 All rights reserved.
      </div>
    </div>
  </front-layout>
</template>

<script>
export default {
  props: {
    reviews: Object,
    title: String,
    body: String,
    order_now: Boolean,
  },
  data() {
    return {
      intervalId: null,
      count: 0,
      reviewData: this.shuffle(this.reviews.reviews),
    }
  },
  mounted() {
    this.fetchImage()

    clearInterval(this.intervalId)

    this.intervalId = setInterval(() => {
      this.count++
    }, 8000)
  },
  beforeDestroy() {
    clearInterval(this.intervalId)
  },
  methods: {
    fetchImage() {
      let bottom = document.getElementById('bottom')

      let imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            bottom.style.backgroundImage =
              "linear-gradient(rgba(0, 0, 0, 0), rgba(42, 67, 101, 1)), url('/images/bottom.jpg')"
          }
        })
      })

      bottom && imageObserver.observe(bottom)
    },
    shuffle(reviews) {
      return reviews.sort(() => Math.random() - 0.5)
    },
  },
}
</script>

<style scoped>
#top {
  background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)),
    url('/images/top.png');
  background-size: cover;
  background-position: center;
  margin-top: -3.5rem;
}

#bottom {
  height: 800px;
  background-size: cover;
  background-position: center top;
}
</style>
