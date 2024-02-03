<template>
    <div class="panel panel-default" style="border:1px solid red;">
        <div class="panel-heading">
            Grammar/Spelling Checker
        </div>
        <div class="panel-body">
            <!-- <div class="text-right">
                <button class="btn btn-primary" type='button' @click="applyCorrection()" v-html="label"></button>
            </div> -->
            <div class="row">
                <div class="col-sm-8">
                    <input type="hidden" v-if="isApply" name="form[data][summary]" v-model="inputText">
                    <input type="hidden"  v-if="isApply" v-for="error in errors" :name="`form[data][errors][${error.bad}]`" :value="error.bad"  :key="error.id">
                    <div class="bg-white" v-html="inputText">
                    </div>
                </div>
                <div class="col-sm-4">
                        <label for="">Suggestions</label>
                        <div class="grammar-errors" v-for="error in errors" :key="error.id">
                            <dl>
                                <dt style="color:#ff1818;">{{ error.bad }}</dt>
                                <!-- <input type="text" v-for="error in errors" :name="`form[data][errors][${error.bad}][]`" :value="getCorrection(error.better)" :key="error.id"> -->
                                <input type="hidden"  :name="`form[data][errors][${error.bad}][]`" :value="error.better.slice(0,5)">
                                <dd>
                                    <span class="text-muted" v-for="(better, index) in error.better" :key="better" v-if="index <= 4">
                                        {{ better }}
                                    </span>
                                </dd>
                            </dl>
                        </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>import { isBuffer, result } from "lodash"


export default {
    // props:['text', 'api'],
    props:{
        text:{
            type: String,
            default: ''
        },
        api:{
            type: String,
            default: ''
        }
    },
    data(){
        return {
            errors:[],
            inputText: this.text,
            isApply: true,
            label: 'Check'
        }
    },
    created(){
    
        this.inputText = this.text.replace(/\n\r?/g, '<br>')
        this.applyCorrection()
    },
    methods:{
    getCorrection(data){
            return data
        },
        applyCorrection(){
            this.label = '<i class="fa fa-spin fa-spinner"></i> checking'
            var noHtml = this.text.replace(/\n\r?/g, ' ')
            noHtml = noHtml.replace(/(<([^>]+)>)/gi, "")
            fetch(`https://api.textgears.com/check.php?text=${noHtml}&key=${this.api}`)
                .then(response => response.json())
                .then(result => {
                    if(result.error_code == 607){
                        alert(result.description)
                    }else{
                         String.prototype.replaceAt = function(index, to) {
                            if (index >= this.length) {
                                return this.valueOf();
                            }
                            var chars = this.split('');
                            chars[index - 1] = " <span style='color:red'>";
                            chars[index + to] = "</span> ";
                            return chars.join('');
                        }

                        this.errors = result.errors
                        var i = 0
                        this.errors.forEach(e => {
                            var word = e.bad
                            let re = new RegExp(`\\b${word}\\b`, 'g')
                            console.log(e.bad)
                            noHtml = noHtml.replace(re, `<span style='color:#ff1818;'>${e.bad}</span>`)
                            console.log(noHtml)
                            // if(i == 0){
                            //     var offset = e.offset
                            // }else{
                            //     var offset = (i * 31) + e.offset
                            // }
                            // noHtml = noHtml.replaceAt(offset, e.length)
                            // i++
                        })

                        this.inputText = noHtml
                    }

                    this.label = "Check"
                })
                .catch( error => {
                    this.label = "Check"
                })
        },
    }

}
</script>

<style lang="scss" scoped>

    .bg-white{
        background-color:#fff;
        user-select: none;
    }


</style>
