<template>
    <li class="list-group-item p-2 pl-3">
        <small>({{ componentItem.id }})</small> {{ componentItem.name }} <span class="ml-4"></span> 
        <span v-if="!item.sub_components.length">
            <small class="text-muted"><i>{{ componentItem.type }}</i></small>
            <span v-for="input in componentItem.inputs" :key="input">
                <small class="text-muted chip">{{ input }}</small>
            </span>
        </span>
        <div class="pull-right controls">
            <a href="#"  data-toggle="modal"  :data-target="'#componentModal' + componentItem.id" class="mr-2"><i class="fa fa-pencil"></i></a>
            <a href="#" @click="remove(componentItem.id)"  class="mr-2"><i class="fa fa-trash"></i></a>
        </div>

        <SubItem v-for="component in componentItem.sub_components" :key="component.id" :item="component" @deleted="subComponentDelete($event)" />

        <div class="modal fade"  :id="'componentModal' + componentItem.id" tabindex="-1" role="dialog" :aria-labelledby="'componentModal' + componentItem.id">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <form @submit.prevent="submitItem">
                            <p>
                                Name
                                <input type="text" class="form-control" required placeholder="Component Name" v-model="componentItem.name">
                            </p>
                            <div v-if="!item.sub_components.length">
                                <br>
                                Inputs
                                <div v-for="(input, index) in inputList" :key="index">
                                    <input type="checkbox" :value="input" v-model="componentItem.inputs"  :id="index"> 
                                    <label :for="index">{{ input }}</label>
                                </div>
                                <br>
                                <p>     
                                    Type  
                                    <select class="nice-select form-control" v-model="componentItem.type">
                                        <option value="ordinary">Ordinary</option>
                                        <option value="summary">Summary</option>
                                    </select>
                                </p>
                                <br>
                                <br>
                            </div>
                            <p class="text-right">
                                <button type='submit' class="btn btn-warning" @submit.prevent="submit"><i class="fa fa-save"></i> Save Changes</button>
                                <button class="btn btn-default" data-dismiss="modal" ><i class="fa fa-ban"></i> Cancel</button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
import SubItem from "./SubItem.vue"
export default {
    props:['item'],
    data(){
        return{
            editMode: false,
            componentItem: this.item,
            inputList: [],
        }
    },
    components:{
        SubItem
    },
    created(){
        this.getInputs()
        // this.inputs = this.item.inputs
    },
    methods:{
        subComponentDelete(id){
            this.item.components.splice(this.item.components.indexOf(id), 1)
        },
        submitItem(){
            axios.put('/back-end/component/' + this.componentItem.id,{
                        name: this.componentItem.name,
                        inputs: this.componentItem.inputs,
                        type: this.componentItem.type
                    })
                        .then( response => {
                            this.componentItem = response.data
                            $('#componentModal' + this.componentItem.id).modal('hide')
                        })
                        .catch(error => {
                            console.log(error)
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

<style lang="scss" scoped>
    .chip{
        margin-left:10px;
        background-color: #54cde0;
        color:#fff;
        padding:1px 5px 2px 5px;
    }

</style>
