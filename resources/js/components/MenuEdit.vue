<template>
    <div class="flex items-center py-2">
        <div v-if="editing" class="w-1/2 mr-2 flex flex-col">
            <input type="text" v-model="menu.name" class="w-full appearance-none bg-white text-black border-2 py-2 px-2 rounded">
            <input type="text" v-model="menu.price" class="w-full appearance-none bg-white text-black border-2 py-2 px-2 rounded">
            <input type="text" v-model="menu.descript" @keyup.enter="edited" class="w-full appearance-none bg-white text-black border-2 py-2 px-2 rounded">
        </div>
        <div v-else class="mr-4 flex flex-col">
            <span v-text="menu.name"></span>
            <span v-text="menu.price"></span>
            <span v-text="menu.descript"></span>
        </div>

        <button class="bg-orange-light text-white py-1 px-2 rounded mr-3" @click="edited">Edit</button>

        <button type="submit" @click="deleted">Delete</button>
    </div>
</template>

<script>
    export default {
        props: ['data'],

        data() {
            return {
                menu: this.data,
                editing: false
            }
        },

        watch: {
            data() {
                this.menu = this.data;
            }
        },

        methods: {
            edited() {
                if (this.editing) {
                    axios.patch(location.pathname + '/items/' + this.menu.id, {
                        name: this.menu.name,
                        price: this.menu.price,
                        descript: this.menu.descript
                    })
                    .then(() => flash('Updated!'))
                    .catch(error => {
                        flash(error.response.data.errors.name[0], 'danger');
                            
                        this.editing = !this.editing;
                    });
                }

                this.editing = !this.editing;
            },
            deleted() {
                axios.delete(location.pathname + '/items/' + this.menu.id)
                .then(() => {
                    flash('Deleted!');

                    this.$emit('delete');
                });
            }
        }
    }
</script>
