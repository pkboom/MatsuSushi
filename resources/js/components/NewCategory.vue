<template>
    <div>
        <input type="text" v-model="name" @keyup.enter="added" class="w-1/2 appearance-none bg-white text-black border-2 py-2 px-2 rounded" placeholder="name">
        <button type="submit" class="bg-purple text-white py-2 px-2 rounded" @click="added">Add Category</button>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                name: '',
            }
        },

        methods: {
            added() {
                axios.post(location.pathname, {
                    name: this.name
                })
                .then(({data})=> {
                    this.$emit('add', data);

                    this.name = '';
                    
                    flash('You have added a new category!');

                    window.scrollTo(0, document.body.scrollHeight);
                })
                .catch(error => {
                    flash(error.response.data.errors.name[0], 'danger');
                });
            }
        }
    }
</script>