<template>

    <form method="POST" @submit.prevent="saveRecording">
        <div class="alert alert-danger" v-show="noRecording" >Please have your recording to continue.</div>
        <div class="row">
            <div class="col-sm-12 col-md-8">
                    <p>
                        <label for="title">Title</label>
                        <input type="text" name='title' v-model="title" required  class="form-control">
                    </p>
                    <p>
                        <textarea name="" id="" rows="14" v-model="script" required class="form-control"></textarea>
                    </p>            
            </div>
            <div class="col-sm-12 col-md-4">
                <div class='recording-box'>
                    <div class="text-center">
                        <div class="mic-icon">
                            <i class="fa fa-microphone" :class="{ 'text-muted': !recording, 'text-danger' : recording}"></i>
                        </div>

                        <div class="buttons">
                            <button type="button" class="btn btn-primary" @click="starRecord" :disabled="recording">Start Recording</button>
                            <button type="button" class="btn btn-default" ref="stoprecordbtn" @click="recording = !recording"  :disabled="!recording">Stop Recording</button>
                        </div>

                        <p>
                        <label for="">Microphone</label>
                        <select class="form-control" v-model="microphoneId">
                                <option :value="microphone.deviceId" v-for="microphone in microphones" :key="microphone.deviceId">{{ microphone.deviceId }}</option>
                        </select>
                        </p>

                        <div class="recording-list" v-show="audioUrl">
                            <audio ref="audioPlayer" id='player' v-show="audioUrl" controls></audio>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-block btn-lg btn-warning mb-2"><i class="fa fa-save"></i> Submit</button>
                <a :href="backroute" class="btn btn-block btn-lg btn-default"><i class="fa fa-ban"></i> Cancel</a>
            </div>
        </div>
        
    </form>
 
</template>

<script>
export default {
    props:['storeroute', 'backroute'],
    data(){
        return {
            microphones: [],
            microphoneId:'',

            // inputs 
            title: '',
            script:'',
            noRecording : false,

            //states
            recording: false,
            audioUrl: '',
            audioBlob:''
        }
    },
    watch:{
        microphoneId(){
            
        }
    },
    methods:{
        saveRecording(){
            this.noRecording = false

            if(!this.audioBlob){
                this.noRecording = true
            }else{
                const formData = new FormData();
                formData.append('audiofile', this.audioBlob);
                formData.append('title', this.title);
                formData.append('script', this.script);

                axios.post(this.storeroute, formData)
                    .then( response => {
                        window.open(response.data, '_self')
                    })
            }
           
        },

        starRecord(){
            navigator.mediaDevices.getUserMedia({ audio: {deviceId: this.microphoneId}, video: false })
                    .then(this.handelRecoding);
                    
            this.recording = !this.recording
        },

        handelRecoding(stream){

            const mediaRecorder = new MediaRecorder(stream);
            mediaRecorder.start();

            const audioChunks = [];
                mediaRecorder.addEventListener("dataavailable", event => {
                audioChunks.push(event.data);
            });

            mediaRecorder.addEventListener("stop", () => {
                const audioBlob = new Blob(audioChunks, {type: 'audio/mp3'});
                this.audioBlob = audioBlob
                this.audioUrl = URL.createObjectURL(audioBlob);
                this.$refs.audioPlayer.src = this.audioUrl
            });

            this.$refs.stoprecordbtn.addEventListener('click', () => {
                mediaRecorder.stop();
            })
        },


        async sendAudioFile(file) {
                const formData = new FormData();
                formData.append('audiofile', file);

                axios.post('http://127.0.0.1:8000/my-dashboard/recording', formData)
                    .then( response => {
                        console.log(response.data)
                    })
        }
    },
    mounted(){
        navigator.mediaDevices.enumerateDevices().then((devices) => {
            var devices =  devices.filter((d) => d.kind === 'audioinput');
            this.microphones = devices;
            this.microphoneId = devices[0].deviceId
        });
    }
}
</script>

<style scoped lang="scss">
    .recording-box{
        background-color:#fff;
        padding:20px;

        .buttons{
            margin-bottom: 20px;
        }
    }
    .mic-icon{
        .fa{
            font-size:12em;
        }
    }
</style>