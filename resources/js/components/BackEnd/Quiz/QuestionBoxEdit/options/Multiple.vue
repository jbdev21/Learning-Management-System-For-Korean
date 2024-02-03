<template>
    <div>
        <small><i>Put you options and correct answers below.</i></small>
        <div class="input-group mb-2" v-for="option in options" :key="option">
            <span class="input-group-addon">
                <input type="radio" :value="option" name="answer" :checked="question.answer == option" aria-label="Radio button for following text input">
            </span>
            <input type="hidden" class="form-control" :name="`options[${option}]`" :value="option"  aria-label="Text input with radio button">
            <input type="text" required :tabindex="option" class="form-control" v-model="questionArray[option - 1]"  :name="`options[${option}]`" aria-label="Text input with radio button">

            <div class="input-group-prepend" v-if="option > 4">
            </div>

            <span class="input-group-btn">
                
                <button class="btn btn-default text-danger" @click="remove(option)" :disabled="options < 2" type="button"><i class="fa fa-remove"></i></button>
            </span>
        </div>
        <a href="#" @click.prevent="add()"><small>+ Add Field</small></a>
    </div>
</template>

<script>
export default {
    props:['question'],
    data()
    {
        return {
            options: Object.keys(this.question.options).map((key, index) => parseInt(index)+ 1),
            answer:parseInt(this.question.answer),
            questionArray: Object.keys(this.question.options).map((key) => this.question.options[key]),
        }
    },
    created(){
        console.log(this.options)
    },
    methods:{
        add()
        {
            var lastitem = this.options.slice(-1)[0] + 1
            this.options.push(lastitem)
        },
        remove(option)
        {
            this.questionArray[option - 2] = ""
            this.options.splice(this.options.indexOf(option), 1);
        },

    }
}
</script>

<style lang="scss" scoped>
    .form-control{
        border-radius: 0px !important;
    }
</style>