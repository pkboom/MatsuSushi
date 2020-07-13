<template>
    <div>
        <div class="w-1/2 mr-2 flex flex-col">
            <input type="text" v-model="name" class="w-full appearance-none bg-white text-black border-2 py-2 px-2 rounded mb-2" placeholder="name">
            <input type="text" v-model="price" class="w-full appearance-none bg-white text-black border-2 py-2 px-2 rounded mb-2" placeholder="price">
            <input type="text" v-model="description" @keyup.enter="added" class="w-full appearance-none bg-white text-black border-2 py-2 px-2 rounded mb-2" placeholder="description">
        </div>

        <button class="bg-purple text-white py-2 px-2 rounded" @click="added">Add Menu</button>
    </div>


</template>

<script>
    export default {
        data() {
            return {
                name: '',
                price: '',
                description: '',
            }
        },
        
        methods: {
            added() {
                axios.post(location.pathname, {
                    name: this.name,
                    price: this.price,
                    description: this.description
                })
                .then(({data})=> {
                    this.$emit('add', data);

                    this.name = '';
                    this.price = '';
                    this.description = '';
                    
                    flash('You have added new menu!');

                    window.scrollTo(0, document.body.scrollHeight);
                })
                .catch(error => {
                    flash(error.response.data.errors.name[0], 'danger');
                });
            }
        }

    }
</script>