<template>
    <div>
        <div class="flex">
            <div class="item">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">Hour</div>
                    <div class="panel-body"><h1>{{ hours }}</h1></div>
                </div>
            </div>
            <div class="item">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">Minutes</div>
                    <div class="panel-body"><h1>{{ minutes }}</h1></div>
                </div>
            </div>
            <div class="item">
                <div class="panel panel-default text-center">
                    <div class="panel-heading">Seconds</div>
                    <div class="panel-body"><h1>{{ seconds }}</h1></div>
                </div>
            </div>
        </div>
    </div>  
</template>

<script>
export default {
    props: ['end', 'stoproute'],
    data(){
        return{
            timeEnd: new Date(this.end).getTime(),
            days: 0,
            hours: 0,
            minutes:0,
            seconds: 0
        }
    },
    mounted(){
       this.StartCounting()
    },
    methods:{
        StartCounting(){
            var counter = setInterval( e =>{
                var now = new Date().getTime();
                var distance = this.timeEnd - now;
                if (distance <= 0) {
                    clearInterval(counter);
                    this.$swal({
                        icon: 'error',
                        title: 'Quiz Time Over',
                        // text: 'Quiz is Over.',
                    });
                }else{
                      // Time calculations for days, hours, minutes and seconds
                    this.days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    this.seconds = Math.floor((distance % (1000 * 60)) / 1000);
                }

            },1000)
        }
    }
}
</script>

<style scoped lang='scss'>
    .flex{
        display:flex;

        .item{
            flex:1;
            margin:1px;

            .panel-body{
                padding:5px;

                h1{
                    font-size:2em;
                }
            }
        }
    }
</style>