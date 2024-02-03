<template>
      <div class="main">
            <div style='margin-bottom:0px; margin-right:60px; padding:3px 0px 3px 0px;' v-show="!inserting" @click="inserting = !inserting">
                  {{ text }}: {{ value }}/100
            </div>
            <div  v-show="inserting" style="margin-right:120px;">
                 {{ text }}: <input ref="editinput" type="number" min="0" max="100" style="width:55px;" v-model.number="value" @blur="inserting = !inserting" @keyup.enter="updateInserting">
            </div>
            <span>
                  <button v-if="isChanged" type="button" @click="updateRate" class="btn btn-xs btn-success">
                        <i class="fa fa-check"></i>
                  </button>
                  <button v-if="isChanged" type="button" @click="cancelBtn" class="btn btn-xs btn-danger">
                        <i class="fa fa-ban"></i>
                  </button>
            </span>
            <input type="range" min="0"  max="100" v-model="value">
      </div>
</template>
<script>
export default {
      props:['default', 'label', 'uri', 'component', 'book','student'],
      created(){
            this.value = this.default ? this.default : 0
            this.text = this.label ? this.label : "Score"
      },
      data(){
            return {
                  value: 0,
                  inserting: false,
                  isChanged: false,
                  first: true,
            }
      },
      watch:{
            inserting(){
                  if(this.inserting){
                        this.$nextTick(() => this.$refs.editinput.focus())
                        // console.log("hehe")
                  }
            },

            value(){
                  if(!this.first){
                        this.isChanged = true
                  }else{
                        this.first = false
                  }
            }
      },
      methods:{
            updateInserting(){
                  this.inserting =  false
            },
            updateRate(){
                  var msg = "";

                  if (this.value > 1) {
                        // msg = "Thanks! You rated this " + this.value + ".";
                      msg = "Score Saved"
                  }
                  else {
                        msg = "We will improve ourselves. You rated this " + this.value + ".";
                  }

                  axios.post(this.uri, {
                        student: this.student,
                        book: this.book,
                        component: this.component,
                        rating: this.value
                  })
                  .then( response => {
                        toastr.success(msg);
                        this.isChanged = false
                        this.inserting = false
                  })
                  .catch(error => {
                        console.log(error)
                  })
            },
            cancelBtn(){
                  this.isChanged = false
                  this.inserting = false
                  this.first = true // so that watcher will not assign new value
                  this.value = this.default
            }
      },
}
</script>

<style lang="scss" scoped>
      .main{
            position: relative;

            span{
                  position: absolute;
                  top:2px;
                  right: 2px;
            }
      }
</style>
