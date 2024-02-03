<template>
    <div>
        <div class="pull-right pt-1 controls pr-3">
            <a href="#"  class="mr-3" data-toggle="modal" :data-target="'#subComponentModal' + item.id"><i class="fa fa-plus"></i></a>
            <a href="#"  class="mr-3"><i class="fa fa-pencil"></i></a>
            <a href="#" @click="remove(item.id)" class="mr-1"><i class="fa fa-trash"></i></a>
        </div>
        <h5>
            {{ item.name }} ({{ item.id }})
        </h5>
    
        <ul class="list-group ml-4">
            <Item v-for="component in item.components" :key="component.id" :item="component" @deleted="subComponentDelete($event)" />
        </ul>

         <!-- Modal -->
        <div class="modal fade" :id="'subComponentModal' + item.id" tabindex="-1" role="dialog" aria-labelledby="subComponentModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form @submit.prevent="submitForm">
                            <p class="text-muted">
                                Creating Component for {{ item.name }} {{ item.id }}
                            </p>
                            <p>
                                Name
                                <input type="text" class="form-control" required placeholder="Component Name" v-model="name">
                            </p>
                            <input type="checkbox" value="1" v-model="isParent"> Sub-Parent Component
                            
                            <div v-if="!isParent">
                                <br>
                                Inputs
                                <div v-for="(input, index) in inputList" :key="index" >
                                    <input type="checkbox" :value="input" v-model="inputs"  :id="index"> 
                                    <label :for="index">{{ input }}</label>
                                </div>
                                <br>
                                <p>     
                                    Type  
                                    <select class="nice-select form-control" v-model="type">
                                        <option value="ordinary">Ordinary</option>
                                        <option value="summary">Summary</option>
                                    </select>
                                </p>
                              </div>
                            <br>
                            <br>
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
import Item from './Item.vue'
export default {
    props:['item'],
    components:{
        Item
    },
    data(){
        return {
            name:'',
            inputs:[],
            inputList: [],
            type: '',
            isParent:false
        }
    },
    created(){
        this.getInputs()
    },
    methods:{
        submitForm(){
            axios.post('/back-end/component',{
                    name: this.name,
                    parent_id: this.item.id,
                    type: this.type,
                    inputs: this.inputs
                })
                    .then( response => {
                        this.name = ''
                        this.inputs = []
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
                            this.$emit('deleted', this.item)  
                        })
                        .catch( error => {
                            console.log( error )
                        })   
            }
        }, 

        subComponentDelete(id){
            this.item.components.splice(this.item.components.indexOf(id), 1)
        },

        getInputs(){
            axios.get('/get-inputs')
                .then(response => {
                    this.inputList = response.data
                })
                .catch(error => {
                    console.log(error)
                })
        }
     }
}
</script>

