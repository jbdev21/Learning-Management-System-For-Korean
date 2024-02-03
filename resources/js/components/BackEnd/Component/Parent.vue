<template>
  <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-right pt-1 controls">
                    <a href="#"  class="mr-3" data-toggle="modal" :data-target="'#parentComponentModal' + item.id"><i class="fa fa-plus"></i></a>
                    <a href="#"  class="mr-3"><i class="fa fa-pencil"></i></a>
                    <a href="#" @click="remove(item.id)" class="mr-1"><i class="fa fa-trash"></i></a>
                </div>

                <h3 class="mt-0 mb-0">
                    {{ item.name }}
                </h3>
            
            </div>
            <div class="panel-body">
                <SubComponent  v-for="subComponent in item.components" :key="subComponent.id" :item="subComponent" @deleted="subComponentDelete($event)" />
            </div>
        </div>

        <div class="modal fade" :id="'parentComponentModal' + item.id" tabindex="-1" role="dialog" aria-labelledby="parentComponentModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form @submit.prevent="submitForm">
                            <p class="text-muted">
                                Sub-component for {{ item.name }}
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
import SubComponent from './SubComponent.vue'
export default {
    props:['item'],
    components:{
        SubComponent
    },
    data(){
        return {
            name: ''
        }
    },

    methods:{
        submitForm(){
            axios.post('/back-end/component',{
                    name: this.name,
                    parent_id: this.item.id
                })
                    .then( response => {
                        this.name = ''
                        this.item.components.push(response.data) 
                        this.$refs.closeModal.click()
                    })
                    .catch( error => {
                        console.log( error )
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
        },
         
        subComponentDelete(id){
            this.item.components.splice(this.item.components.indexOf(id), 1)
        }
     }
}
</script>
