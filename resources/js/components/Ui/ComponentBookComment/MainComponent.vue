<template>
    <div>
        <br>
        <div class="panel panel-default chat-box">
                        <div class="panel-heading">Comments</div>
                                <div class="panel-body" v-chat-scroll>
                                        <!-- <div class="message-item" v-for="(comment, index) in comments" :key="comment.id">
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
                                        </div> -->
                                        <div class="media" v-for="(comment, index) in comments" :key="comment.id">
                                                <div class="media-left">
                                                        <img class="media-object" :src="comment.avatar" alt="..."> 
                                                </div>
                                                <div class="media-body">
                                                <h4 class="media-heading">{{ comment.name }} 
                                                        <i><small style="font-size:10px;" class="text-muted">{{ comment.time }}</small></i>
                                                        <span style="margin-left:5px;">
                                                                <small style="font-size:10px;" v-if="comment.editable">
                                                                        <a href=""  @click.prevent="edit(comment, index)">
                                                                                <i class="fa fa-pencil"></i>
                                                                        </a>
                                                                        <a href="#"  style="margin-left:3px" @click.prevent="remove(comment, index)">
                                                                                <i class="fa fa-trash"></i>
                                                                        </a>
                                                                </small>
                                                        </span>
                                                        </h4>
                                                        {{ comment.message }}
                                                </div>
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
                                <!-- Button trigger modal -->
                                <a v-if="!editMode && isThisTeacher" type="button" style="cursor:pointer; font-size:12px; margin-top:5px;" data-toggle="modal" data-target="#templatesModal">
                                See Templates
                                </a>
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

                        <!-- Modal -->
                        <div  class="modal fade" v-if="!editMode && isThisTeacher" id="templatesModal" tabindex="-1" >
                                <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                                <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">Templates</h4>
                                                </div>
                                                <div class="modal-body">
                                                      <div @click="selectTemplate(template)" class="alert alert-info template-item" v-for="template in templates" :key="template">
                                                              {{ template }}
                                                      </div>
                                                </div>
                                                <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
    </div>
</template>

<script>
export default {
    props:['bookid', 'componentid','studentid','isteacher'],
    data(){
        return {
            comments:[],
            editMode: false,
            updatingComment:{},
            templates: [],
            message:'',
            selectedIndex: '',
            isThisTeacher: this.isteacher == 1 ? true : false
        }
    },
    created(){
        this.getComments()
        if(this.isteacher == 1){
                this.getTemplates(0)
        }
    },
    methods:{
            selectTemplate(template){
                $('#templatesModal').modal('hide')
                this.message = template;
        },
        sendComment(){
            axios.post('/api/component-comment',{
                    book:this.bookid,
                    component: this.componentid,
                    student: this.studentid,
                    message: this.message
                })
                .then( response => {
                    console.log(response.data)
                    this.comments.push(response.data.data)
                    this.message = ''
                })
                .catch( error =>  {
                    console.log(error)
                })
        },

        getTemplates(){
                axios.get('/api/comment-templates')
                        .then( response => {
                                this.templates = response.data
                        })
                        .catch( error => {
                                console.log(error)
                        })
        },

        getComments(){

            axios.get('/api/component-comment', {
                    params:{
                        book:this.bookid,
                        component: this.componentid,
                        student: this.studentid
                    }
                })
                .then( response => {
                    this.comments = response.data.data
                })
                    .catch( error =>  {
                    console.log(error)
                })
        },

        remove(comment, index){
                if(confirm("Are you sure to delete?")){
                        axios.delete('/api/component-comment/' + comment.id,)
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

                axios.put('/api/component-comment/' + comment.id,{
                        id: comment.id,
                        message: this.updatingComment,
                })
                .then( response => {
                        
                })
                .catch( error => {
                        console.log(error)
                })

                this.cancelEdit()
        },

        getTime(){
                var today = new Date();
                var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                var time = today.getHours() + ":" + today.getMinutes();
                var dateTime = date+' '+time;
                return dateTime;
        },
        cancelEdit(comment, index){
                this.editMode = false;
                this.updatingComment = ''
                this.selectedIndex = ''
        },

        edit(comment, index){
                this.selectedIndex = index
                var message = this.comments[index].message;
                this.editMode = true;
                this.message = ''
                this.updatingComment = message
                // console.log(this.updatingComment)
        },
    }
}
</script>
<style lang="scss" scoped>
        .template-item{
                padding:5px;
                margin-bottom:5px;
                cursor: pointer;

                &:hover{
                        color:black !important;
                }
        }

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
                margin-bottom:5px;
        }
</style>