<template>
    <div>
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <small><i>Put your posible answers in the fields.</i></small>
            </div>
            <div class="col-sm-12 col-md-6 text-right">
                <span>
                    <input type="checkbox" id="case_sensitive" name="case_sensitive"> <label for="case_sensitive">Case Sensitive</label>
                </span>
            </div>
        </div>
        <div class="input-group mb-2" v-for="option in options" :key="option">
            <!-- <span class="input-group-addon">
                <input type="radio" :value="option" name="answer" :checked="options[0] == option" aria-label="Radio button for following text input">
            </span> -->
            <input type="hidden" class="form-control" :name="`options[${option}]`" :value="option" aria-label="Text input with radio button">
            <input type="text" required :tabindex="option" class="form-control" :name="`options[${option}]`" aria-label="Text input with radio button">

            <div class="input-group-prepend" v-if="option > 4">
            </div>
            <span class="input-group-btn">
                <button class="btn btn-default text-danger" @click="remove(option)" :disabled="options.length < 2" type="button"><i class="fa fa-remove"></i></button>
            </span>
        </div>
        <a href="#" @click.prevent="add()"><small>+ Add Field</small></a>
    </div>
</template>

<script>
export default {
   data()
    {
        return {
            options:[1]
        }
    },
    methods:{
        add()
        {
            var lastitem = this.options.slice(-1)[0] + 1
            this.options.push(lastitem)
        },
        remove(option)
        {
            this.options.splice(this.options.indexOf(option), 1);
        }
    }
}
</script>

<style lang="scss" scoped>
    .form-control{
        border-radius: 0px !important;
    }
</style>