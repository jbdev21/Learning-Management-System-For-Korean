<template>
    <div class="bg-white" id="main-body">
        <br>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div>
                        <div class="row">
                            <div class="col-sm-6">
                                 <br>
                                Progress: {{ answered }}/{{ questions_count }}
                            </div>
                            <div class="col-sm-6 text-right mb-3">
                                <a href="#" @click.prevent="getData()"  class="btn-skip" > Skip Question</a>
                            </div>
                        </div>
                        <!-- <Timer> -->

                        <div class="question-box">
                            <div class="question-text" >
                                <img style="width:30%;" :src="'/' + picture.source"  v-for="picture in question.images" :key="picture.id" alt="">
                                <h3 v-html="question.body"></h3>
                            </div>
                                <div class="p-3" style="padding:15px;">
                                    <div class="quiz-choices"  v-if="question.type =='multiple'"  v-for="(option, index) in question.options" :key="index">
                                        <input type="radio" :id="`choice-${index}`" v-model="answer"  :value="option">
                                        <label  @click="setAnswerAndSubmit(index)"  :for="`choice-${index}`"> {{ option }}
                                        </label>
                                    </div>
                                    <div  v-if="question.type =='subjective'">
                                        <form @submit.prevent="submitAnswer">
                                            <input type="text" required v-model="answer" placeholder="Put your answer here">
                                            <br>
                                            <br>
                                            <button type="submit" class="btn-submit">
                                                <span v-show="loading">
                                                    <i class="fa fa-spin fa-spinner"></i> Loading..
                                                </span>
                                                <span v-show="!loading">
                                                    Submit
                                                </span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Timer from './TimerComponent.vue'
export default {
    props: ['geturl', 'sendanswerurl'],
    component:{
        Timer
    },
    data(){
        return {
            question: {},
            questions_count: 0,
            answered: 0,
            answer: '',
            loading: false,
            click: new Audio("/sounds/quiz/click.mp3"),
            startSound: new Audio("/sounds/quiz/start.wav"),
        }
    },

    created(){
        if(this.answered = 0){
            this.playStarSound()
        }

        this.getData()
    },

    methods:{
        playClick(){
            this.click.pause();
            this.click.currentTime = 0;
            this.click.play();

        },
        playStarSound(){
            this.startSound.pause();
            this.startSound.currentTime = 0;
            this.startSound.play();
        },
        setAnswerAndSubmit(data){
            this.answer = data
            this.submitAnswer();
        },
        submitAnswer(){
            if(this.answer == ''){
                 this.$swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'You did not choos your answer.',
                 });
            }else{
                // setTimeout(() => {
                    axios.post(this.sendanswerurl, {
                        question_id: this.question.id,
                        answer: this.answer
                    })
                    .then( response => {
                        this.getData()
                        this.answer = ''
                    })
                    .catch( error => {
                        console.log(error)
                    })
                // }, 2000)

            }
        },
        getData(){
            this.playClick()
            this.loading = true
            axios.get(this.geturl)
                .then( response => {
                    if(response.data.status == "done"){
                        location.reload();
                    }else{
                        this.question = response.data.question
                        this.questions_count = response.data.questions_count
                        this.answered = response.data.answered
                        this.loading = false
                        this.answer = ''
                    }
                })
                .catch( error => {
                    console.log(error)
                })
        }
    }
}
</script>
<style lang="scss" scoped>

    body{
        margin:0px;
        padding:0px;

    }

    .title-bar{
        background-color:#dad3d336;
        margin-top:0px;
    }

    #main-body{
        height: 100vh;
        background-image: url('/images/quiz-bg.png');
        background-size:cover;
        color:#fff;
        font-family: 'Short Stack', cursive !important;
    }


    input[type="radio"]:checked+label{
        color:green;
    }
    input[type="text"]{
        width:100%;
        padding:15px;
        font-size:25px;
        color:#000;
        border-radius: 5px;

        &:focus{
            outline:none;
        }
    }

    .question-box{
        .question-text{
            font-size:3rem;
            font-family: 'Short Stack', cursive !important;
            margin:10px 0px 20px 0px;
            border:5px solid rgb(11, 118, 128);
            background-color:  rgb(55, 165, 175);
            border-radius: 15px;
            padding:5rem;
        }

        .quiz-choices{
            input{
                display:none;
            }

            label{
                display:block;
                padding:10px;
                // border:2px solid red;
                margin:0px 15px 20px 25px;
                font-family: 'Short Stack', cursive !important;
                font-size:3rem;
                background-color:#fff;
                color:rgb(55, 165, 175);
                box-shadow: 0 9px #999;
                border-radius: 15px;
                cursor: pointer;

                &:hover{
                    background-color:#43ecc2;
                    color:#000;
                }

                &:active{
                    background-color: #43ecc2;
                    box-shadow: 0 5px #666;
                    transform: translateY(4px);
                }
            }


        }

        .btn-submit{
            padding: 15px 25px;
            font-size: 17px;
            text-align: center;
            cursor: pointer;
            outline: none;
            color: #fff;
            background-color: #4CAF50;
            text-decoration: none;
            border: none;
            border-radius: 15px;
            box-shadow: 0 9px #999;

            &:hover {background-color: #3e8e41}

            &:active {
                background-color: #3e8e41;
                box-shadow: 0 5px #666;
                transform: translateY(4px);
            }
        }
    }

    .btn-skip{
            padding: 15px 25px;
            font-size: 17px;
            text-align: center;
            cursor: pointer;
            outline: none;
            color: #fff;
            background-color: #9e2c4f;
            text-decoration: none;
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px #999;

            &:hover {background-color: #a14367}

            &:active {
                background-color: #902929;
                box-shadow: 0 3px #666;
                transform: translateY(4px);
            }
        }
</style>
