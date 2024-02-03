<template>
  <div>
    <div class="text-right mb-2">
        <button class="btn btn-default btn-sm"  data-toggle="modal" data-target="#newComponentModal"><i class="fa fa-plus"></i> Add New Parent Component</button>
    </div>

    <Parent  v-for="item in list" :item="item" :key="item.id"/>
    <!-- Modal -->
    <div class="modal fade" id="newComponentModal" tabindex="-1" role="dialog" aria-labelledby="newComponentModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form @submit.prevent="submitForm">
                        <p class="text-muted">
                           Create new Parent Component
                        </p>
                        <p>
                            <label for=""></label>
                            <input type="text" class="form-control" required placeholder="Component Name" v-model="name">
                        </p>
                        <p class="text-right">
                            <button type='submit' class="btn btn-warning"><i class="fa fa-save"></i> Save Component</button>
                            <button class="btn btn-default" ref="closeModal" data-dismiss="modal" ><i class="fa fa-ban"></i> Cancel</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

  </div>
</template>

<script>
import Parent from './Parent.vue'
export default {
    props: ['route'],
    components:{
        Parent
    },
    data(){
        return {
            name: '',
            list: []
        }
    },
    created(){
        this.getData();
    },
    methods:{
        submitForm(){
            axios.post('/back-end/component',{
                    name: this.name,
                    type: ''
                })
                    .then( response => {
                        this.name = ''
                        this.getData()
                        this.$refs.closeModal.click()
                    })
                    .catch( error => {
                        console.log( error )
                    })
        },

        getData(){
            axios.get('/back-end/component')
                .then(response => {
                    this.list = response.data
                })
                .catch( error => {
                    console.log(error)
                })
        },

        remove(id){
            if(confirm("Are your sure to delete?")){
                axios.delete('/back-end/component/' + id)
                        .then( response => {
                            this.getData()
                           
                        })
                        .catch( error => {
                            console.log( error )
                        })   
            }
        }

    }
}
</script>

<style>

</style>