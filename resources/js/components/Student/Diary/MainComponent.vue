<template>
    <div class="row">
        <div class="col-sm-7">
            <FullCalendar 
                ref="fullCalendar"
                displayEventTime="false"
                selectable="true"
                :events="eventSource"
                @dateClick="handleDateClick"
                @eventClick="handleEventClick"
                defaultView="dayGridMonth" :plugins="calendarPlugins" />
        </div>
        <div class="col-sm-5">
            <div class="create" v-if="mode == 'adding' && dateSelected">
                <h1>
                    {{ dateSelected }}
                </h1>
                <div class="panel panel-default" >
                    <div class="panel-body">
                        <form @submit.prevent="submitAddDiary" ref="addForm">
                            <p>
                                Title
                                <input type="text" required name="title" v-model='title' class="form-control">
                            </p>
                            <p>
                                Date
                                <input type="date" readonly required v-model="dateForm" class="form-control">
                            </p>
                            <p>
                                Message
                                <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                            </p>
                            <p>
                                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Save</button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
            <div v-if="mode == 'showing' && diary.id">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-sm-6">{{  diary.date}}</div>
                            <div class="col-sm-6 text-right">
                                <a href="#" @click.prevent="editDiary"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;
                                <a href="#" @click.prevent='deleteDiary'><i class="fa fa-trash" ></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <h3>{{  diary.title}}</h3>
                        <div v-html="diary.message"></div>
                    </div>
                </div>

                <comment-component :item="diary.id" model="diary" ></comment-component>
            </div>

            <div v-if="mode == 'editing' && diary.id">
                <form @submit.prevent="submitEditDiary" ref="addForm">
                    <p>
                        Title
                        <input type="text" required name="title" v-model='title' class="form-control">
                    </p>
                    <p>
                        Date
                        <input type="date" readonly required v-model="dateForm" class="form-control">
                    </p>
                    <p>
                        Message
                        <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
                    </p>
                    <p>
                        <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Save Changes</button>
                        <button class="btn btn-default" @click="cancelEdit"><i class="fa fa-ban"></i> Cancel</button>
                    </p>
                </form>
            </div>

        </div>
    </div>
</template>

<script>
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export default {
    components: {
        FullCalendar 
    },
    data() {
        return {
            calendarPlugins: [ dayGridPlugin, interactionPlugin ],
            token : document.head.querySelector('meta[name="csrf-token"]'),
            eventSource: {
                url: '/my-dashboard/diary/list-api',
                method: 'get',
                extraParams: {
                //    _token: this.token.content
                },
                failure: function() {
                    alert('there was an error while fetching events!');
                },
            },

            mode: 'adding',
            diary: [],
            dateSelected: '',
            dateForm: '',
            title: '',

            calendarApi: '',
            editor: ClassicEditor,
            editorData: '',
            editorConfig: {
                height:300,
                toolbar: [ 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' ]
                // The configuration of the editor.
            }
        }
    },
    mounted(){
        this.calendarApi = this.$refs.fullCalendar.getApi()
    },
    methods:{
        
        submitAddDiary(){
            axios.post('/my-dashboard/diary',{
                title:  this.title,
                date: this.dateForm,
                message: this.editorData
            })
            .then(response => {
                this.title = ''
                this.dateForm = ''
                this.editorData = ''
                this.calendarApi.addEvent(response.data)
            })
            .catch( error => {
                console.log( error )
            })
        },

        editDiary(){
            this.title = this.diary.title
            this.dateForm =  this.diary.date
            this.editorData =  this.diary.message
            this.mode = 'editing'
        },

        submitEditDiary(){
            axios.put('/my-dashboard/diary/'+ this.diary.id,{
                    title:  this.title,
                    message: this.editorData
                })
                    .then(response => {
                        this.diary = response.data
                        this.cancelEdit()
                    })
                    .catch( error => {
                        console.log( error )
                    })
        },


        cancelEdit(){
            this.title = ''
            this.dateForm =  ''
            this.editorData =  ''
            this.mode = 'showing'
        },



        deleteDiary(){
            if(confirm("Are you sure to delete?")){
                axios.delete('/my-dashboard/diary/' + this.diary.id)
                    .then(response => {
                        this.calendarApi.getEventById(this.diary.id).remove();
                        this.diary = []
                    })
                    .catch( error => {
                        console.log(error)
                    })
            }
        },

        handleDateClick(arg){
            this.dateSelected = moment(arg.date).format('MMM DD, YYYY')
            this.dateForm = moment(arg.date).format('YYYY-MM-DD')
            this.mode = 'adding'
        },

        handleEventClick(arg){
            axios.post('/my-dashboard/diary/getdiary', {diary: arg.event.id})
                .then( response => {
                    this.diary = response.data
                    this.mode = 'showing'
                })
                .catch( error => {
                    console.log(error)
                })
        }
    }
}
</script>

<style lang="scss" scoped>
    @import '~@fullcalendar/core/main.css';
    @import '~@fullcalendar/daygrid/main.css';
</style>