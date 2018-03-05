export default {
    data() {
        return {
            items: [],
        }
    },

    methods: {
        added(item) {
            this.items.push(item);
        },

        deleted(index) {
            this.items.splice(index, 1);
        }
    }
}