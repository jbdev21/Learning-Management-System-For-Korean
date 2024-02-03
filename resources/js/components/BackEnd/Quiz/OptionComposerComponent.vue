<template>
    <div>
        <div class="input-group mb-2" v-for="option in options" :key="option">
            <span class="input-group-addon">
            <input type="radio" :value="option" name="answer" :checked="options[0] == option" aria-label="Radio button for following text input">
            </span>
            <input type="hidden" class="form-control" :name="`options[${option}]`" :value="option" aria-label="Text input with radio button">
            <input type="text" :tabindex="option" class="form-control" :name="`options[${option}]`" aria-label="Text input with radio button">

            <div class="input-group-prepend" v-if="option > 4">
            </div>
            <span class="input-group-btn">
                <button class="btn btn-default text-danger" @click="remove(option)"  type="button"><i class="fa fa-remove"></i></button>
            </span>
        </div><!-- /input-group -->
        <a href="#" @click="add()">+Add</a>
    </div><!-- /input-group -->
</template>

<script>
export default {
   data()
    {
        return {
            options:[1, 2, 3, 4]
        }
    },
    methods:{
        add()
        {
            var lastitem = this.options.slice(-1)[0] + 1
           // console.log(lastitem)
            this.options.push(lastitem)
        },
        remove(option)
        {
            this.options.splice(this.options.indexOf(option), 1);
        }
    }
}
</script>

<style>

</style>