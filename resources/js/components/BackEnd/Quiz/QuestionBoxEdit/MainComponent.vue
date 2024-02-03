<template>
    <div>
         <div v-if="isSuccessUpdate" class="callout callout-success">
            <h4 class="mb-1">Update Success!</h4>

            <p>All details is updated.</p>
        </div>
        <div class="panel panel-default">
            <form @submit.prevent="submit" :action="route" method="POST" id="question-form">
                <input type="hidden" name="_token" :value="token">
                <input type="hidden" name="quiz" :value="quizid">
                <div class="panel-heading">Question</div>
                <div class="panel-body p-3">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-2">
                                <editor
                                    api-key="3etjjswjc4u1mtvnr70q7p3ahavix9rhnp8puim5vad1kjt7"
                                    :init="editorConfig"
                                    v-model="text"
                                    name="body"
                                    />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <span class='mr-3'>
                                <input type="radio" id="multiple" v-model="currentForm" value="multiple" name="question_type"> <label for="multiple"> Multiple Choice</label>
                            </span>
                            <span>
                                <input type="radio" id="subjective" v-model="currentForm" value="subjective"  name="question_type"> <label for="subjective"> Subjective</label>
                            </span>

                            <div class="pt-2">
                                <component :question="questionData" v-bind:is="currentForm"  class="tab"></component>
                            </div>
                            <div class="mt-3">
                                <p>
                                    Please also consider to put your hint or explanation.
                                    <input type="text" class="form-control" v-model="explanationText" name="explanation">
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="panel-footer text-right p-2">
                    <button class="btn btn-warning btn-lg" :disabled="saving" type="submit" style="width:180px">
                        <span v-if="!saving">
                            <i class="fa fa-save"></i> Save Changes
                        </span>
                        <span v-if="saving">
                            <i class="fa fa-spin fa-spinner"></i> Saving...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>

import Editor from '@tinymce/tinymce-vue'
import Multiple from './options/Multiple'
import Subjective from './options/Subjective'

export default {
    props:['route', 'token', 'quizid','resourceroute'],
    components: {
        'editor': Editor,
        'multiple': Multiple,
        'subjective': Subjective
   },

    data(){
       return {
           currentForm: '',
           text: '',
           questionId: '',
           inputData: {},
           explanationText: '',
           defaultOptions: '',
           isSuccessUpdate : false,
           saving: false,
           questionData: null,
           editorConfig : {
                    height:300,
                    menubar: 'insert',
                    plugins: [
                            'advlist autolink lists link image charmap print preview anchor',
                            'searchreplace visualblocks code fullscreen',
                            'insertdatetime media table paste code help media'
                        ],
                    toolbar: 'undo redo | bold italic backcolor | \
                            alignleft aligncenter alignright alignjustify | \
                            bullist numlist outdent indent image media',
                    toolbar_mode: 'floating',
                    tinycomments_mode: 'embedded',
                    forced_root_block: '',
                    branding: false,
                    verify_css_classes : true,
                    images_upload_url: '/api/upload',
                    images_reuse_filename: true,
                    media_alt_source: false,
                    media_poster: false,
                    relative_urls : false,
                    remove_script_host : false,
                }
       }
    },
    created(){
        axios.get(this.resourceroute)
            .then( response => {
                this.text = response.data.body
                this.questionData = response.data
                this.currentForm = response.data.type
                this.questionId = response.data.id
                this.explanationText = response.data.explanation
            })
            .catch( error => {
                console.log(error)
            })
    },
    methods:{
        submit(){
            this.saving = true;
            var formData = $('#question-form').serialize() + '&body=' + encodeURIComponent(this.text) + "&question_id=" + this.questionId;
            axios.put(this.route, formData)
                .then( e => {
                    this.saving = false
                    this.isSuccessUpdate = true

                    setTimeout(() => {
                        this.isSuccessUpdate = false
                    }, 5000)
                })
                .catch( error => {
                    console.log(error)
                    this.saving = false
                })

        },
        // getInputData(data){
        //     // var formData = new FormData(data);
        //     // console.log(formData)
        //     // this.inputData = formData
        // }
    },


}
</script>

<style lang="scss" scoped>
    .tox-tinymce{
        border-top: none !important;
    }
</style>
