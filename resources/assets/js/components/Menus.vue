<template>
    <div>
        <div v-for="(menu, index) in items" :key="index">
            <menu-edit :data="menu" @delete="deleted(index)"></menu-edit>
        </div>

        <new-menu @add="added"></new-menu>
    </div>
</template>

<script>
    import MenuEdit from './MenuEdit.vue';
    import NewMenu from './NewMenu.vue';
    import collection from '../mixins/collection';

    export default {
        mixins: [collection],

        components: {MenuEdit, NewMenu},

        created() {
            this.fetch();
        },

        methods: {
            fetch() {
                axios.get(location.pathname)
                    .then(({data}) => this.items = data);
            },
        }
    }
</script>
