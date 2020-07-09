export default {
  data() {
    return {
      items: [],
    }
  },

  methods: {
    add(item) {
      this.items.push(item)
    },

    remove(index) {
      this.items.splice(index, 1)
    },

    update(data) {
      this.items.splice(data.index, 1, data.data)
    },
  },
}
