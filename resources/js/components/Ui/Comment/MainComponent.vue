<template>
        <div>
                <div class="panel panel-default chat-box">
                        <div class="panel-heading">Comments</div>
                                <div class="panel-body" v-chat-scroll>
                                        <div class="message-item" v-for="(comment, index) in comments" :key="comment.id">
                                                <img :src="comment.avatar" alt="">
                                                <b>{{ comment.name }}</b>: {{ comment.message }} <i><small style="font-size:8px;" class="text-muted">{{ comment.time }}</small> 
                                                        <small style="margin-left:35px; display:block; font-size:11px;margin-top:-5px;" v-if="comment.editable">
                                                                <a href=""  @click.prevent="edit(comment, index)">
                                                                        <i class="fa fa-pencil"></i>
                                                                </a>
                                                                <a href="#"  style="margin-left:3px" @click.prevent="remove(comment, index)">
                                                                        <i class="fa fa-trash"></i>
                                                                </a>
                                                        </small>
                                                </i>
                                        </div>
                                </div>
                        <div class="panel-footer">
                                <form @submit.prevent="sendComment()" v-if="!editMode">
                                        <div class="input-group">
                                                <input type="text" class="form-control" required v-model="message" placeholder="comment message...">
                                                <span class="input-group-btn">
                                                        <button type="submit" class="btn btn-default">Send</button>
                                                </span>
                                        </div><!-- /input-group -->
                                </form>
                                <form @submit.prevent="updateComment()" v-if="editMode">
                                        <div class="input-group">
                                                <input type="text" class="form-control" required v-model="updatingComment" placeholder="comment message...">
                                                <span class="input-group-btn">
                                                        <button type="submit" class="btn btn-warning">Save Changes</button>
                                                        <button type="button" @click.prevent="cancelEdit" class="btn btn-default">Cancel</button>
                                                </span>
                                        </div><!-- /input-group -->
                                </form>
                        </div>
                </div>
        </div>
</template>
<script>
export default {
        props:['model', 'item'],
        data(){
                return {
                        comments:[],
                        editMode: false,
                        updatingComment:{},
                        message:'',
                        selectedIndex: ''
                }
        },
        created(){
                this.getComments()
        },
        watch:{
                item(){
                        this.getComments()
                }
        },
        methods:{
                edit(comment, index){
                        this.selectedIndex = index
                        var message = this.comments[index].message;
                        this.editMode = true;
                        this.message = ''
                        this.updatingComment = message
                        // console.log(this.updatingComment)
                },
                cancelEdit(comment, index){
                        this.editMode = false;
                        this.updatingComment = ''
                        this.selectedIndex = ''
                },
                remove(comment, index){
                        if(confirm("Are you sure to delete?")){
                                axios.delete('/api/comment/' + comment.id,)
                                        .then( response => {
                                                this.comments.splice(index, 1);
                                        })
                                        .catch( error => {
                                                console.log(error)
                                        })
                        }
                },
                updateComment(){
                        let comment = this.comments[this.selectedIndex]
                        comment.message = this.updatingComment

                        axios.put('/api/comment/' + comment.id,{
                                model: this.model,
                                item: this.item,
                                user_id: loggedUser.id,
                                message: this.updatingComment,
                        })
                        .then( response => {
                               
                        })
                        .catch( error => {
                                console.log(error)
                        })

                        this.cancelEdit()
                },
                sendComment(){
                        axios.post('/api/comment',{
                                model: this.model,
                                item: this.item,
                                user_id: loggedUser.id,
                                message: this.message,
                        })
                        .then( response => {
                                this.comments.push(response.data.data);
                        })
                        .catch( error => {
                                console.log(error)
                        })

                        this.message = ""
                },

                getComments(){
                        axios.get('/api/comment',{
                                params:{
                                        model: this.model,
                                        item: this.item
                                }
                        })
                        .then( response => {
                                this.comments = response.data.data
                                console.log(this.comments)
                        })
                        .catch( error => {
                                console.log( error )
                        })
                },
                
                getTime(){
                        var today = new Date();
                        var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                        var time = today.getHours() + ":" + today.getMinutes();
                        var dateTime = date+' '+time;
                        return dateTime;
                }
        }
}
</script>
<style lang="scss" scoped>
        .chat-box{
                .panel-body{
                        height: 250px;
                        overflow: auto;

                        img{
                                width:32px;
                                border-radius: 50%;
                        }
                }

                .panel-footer{
                        padding: 5px !important;

                         input{
                                border-radius: 0px !important;

                                &:focus{
                                        outline: 0 none;  
                                }
                        }
                }

        }
        .message-item{
                padding:3px 0px;
                margin-bottom:8px;
        }
</style>