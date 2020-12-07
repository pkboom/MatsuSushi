<template>
  <front-layout>
    <div
      id="top"
      class="flex items-center justify-center bg-center bg-cover h-screen"
    >
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
      class="flex flex-col md:flex-row h-80 my-8 md:my-12 overflow-y-auto overflow-x-hidden md:overflow-y-visible"
    >
      <div
        class="w-full md:w-1/3 flex flex-col justify-center items-center space-y-2 md:space-y-4 md:-mr-10"
      >
        <div
          class="text-lg md:text-3xl flex justify-center items-center space-x-1 md:space-x-2"
        >
          <span class="font-bold">4.4</span>
          <img src="/images/star.png" class="w-4 md:w-5" />
          <img src="/images/star.png" class="w-4 md:w-5" />
          <img src="/images/star.png" class="w-4 md:w-5" />
          <img src="/images/star.png" class="w-4 md:w-5" />
          <img src="/images/half-star.png" class="w-4 md:w-5" />
        </div>
        <div class="text-lg md:text-2xl">
          377 Google Reviews
        </div>
      </div>
      <div class="w-full md:w-2/3 mt-4 md:mt-0">
        <div class="w-full relative flex">
          <div
            v-for="(review, key) in reviews.reviews"
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
  </front-layout>
</template>

<script>
export default {
  props: {
    reviews: Object,
  },
  data() {
    return {
      intervalId: null,
      count: 0,
    }
  },
  mounted() {
    clearInterval(this.intervalId)

    this.intervalId = setInterval(() => {
      this.count++
    }, 10000)
  },
  beforeDestroy() {
    clearInterval(this.intervalId)
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
</style>
