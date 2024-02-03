<template>
    <div ref='rankContainer' class="rank-container">
        <div class="student-rank-list small" v-for="rank in ranks" :key='rank.id'>
            <div class="date-div">
                <div class="month">{{ rank.month }}</div>
                <div class="year">{{ rank.year }} </div>
            </div>
            <div class="details">
                <h3 v-for="student in rank.ranks" :key='student.rank'>
                    <img src="/images/index/first-medal.png" v-if="student.rank == 1" alt="">
                    <img src="/images/index/2nd-medal.png"  v-if="student.rank == 2"  alt="">
                    {{ student.name }}
                </h3>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:['uri'],
    data(){
        return {
            ranks:[],
            next_page_url:'',
        }
    },
    created(){
        this.getRanks()
    },

    mounted () {
        this.scroll()
    },

    methods:{
        getRanks(nextLink = null){
            var source = nextLink ? nextLink : this.uri
            axios.get(source)
                .then( response => {
                    console.log(response.data)
                    if(nextLink){   
                        // just append or add in the list
                        if(response.data.data){
                            response.data.data.map( e => {
                                this.ranks.push(e)
                            })
                        }
                    }else{
                        // just make a list
                        this.ranks = response.data.data
                    }

                    this.next_page_url = response.data.next_page_url
                })
                .catch( error => {
                    console.log(error)
                })
        },

        loadMore(){
           this.getRanks(this.next_page_url); 
        },

        scroll () {
            this.$refs.rankContainer.onscroll = () => {
                let bottomOfWindow = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop) + window.innerHeight + 900 >= document.documentElement.offsetHeight
                if (bottomOfWindow) {
                    if(this.next_page_url != null){
                        if(!this.loadingContent){
                            this.loadMore()
                        }
                    }
                }
            }
        },
    }
}
</script>

<style lang="scss" scoped >
    .rank-container{
        height: 450px;
        overflow: auto;
    }
</style>