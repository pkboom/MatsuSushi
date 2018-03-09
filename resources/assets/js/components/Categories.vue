<template>
    <div>
        <div v-for="(category, index) in items" :key="index">
            <category-edit :category="category" @delete="remove(index)" :index="index" @update="update"></category-edit>
        </div>

        <new-category @add="add"></new-category>
    </div>
</template>

<script>
    import CategoryEdit from './CategoryEdit.vue';
    import NewCategory from './NewCategory.vue';
    import collection from '../mixins/collection';

    export default {
        mixins: [collection],

        components: {CategoryEdit, NewCategory},

        created() {
            this.fetch();
        },

        methods: {
            fetch() {
                axios.get(location.pathname)
                    .then(({data}) => this.items = data);
            },

            update(data) {
               this.items.splice(data.index, 1, data.data);
            }
        }
    }
</script>