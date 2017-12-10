<template>
    <div>
        <div class="flex-center" style="margin-top: 40px" v-if="loading != false">
            <i class="fa fa-spinner fa-5x fa-spin"></i>
            <p class="text-center">Loading tweets ... </p>
        </div>
        <transition-group name="fade">
            <tweet @remove="removeTweet" @update="updateActions" v-for="(tweet,index) in tweets" :key="index" :tweet="tweet" :actions="actions"></tweet>
        </transition-group>
        <infinite-loading @infinite="loadmore">
            <span slot="no-more">
              There are no more stories
            </span>
        </infinite-loading>
        <div class="flex-center" style="margin-top:40px">
            <button @click="loadManual" class="btn btn-default" type="button" v-if="more & !loading">Load more</button>
        </div>
    </div>
</template>

<script>
    import TweetCard from './DeleteCard.vue';
    import InfiniteLoading from 'vue-infinite-loading';
    export default {
        data : function(){
            return{
                tweets  : [],
                actions : [],
                pageNo  : null,
                total   : null,
                loading : true,
                more : true
            }
        },
        components : {
            tweet : TweetCard,
            InfiniteLoading
        },
        methods : {
            removeTweet : function(item){
                axios({
                    url     : '/deleteTweet',
                    data    : {id :item.id_str.replace(/^'+|'+$/g,'')},
                    method  : 'post',
                    type    : 'json',
                }).then((response) => {
                    console.log(response.data)
                    this.tweets.splice(this.tweets.indexOf(item),1)
                }) 
            },
            updateActions : function(item){
                this.tweets.splice(this.tweets.indexOf(item),1)
            },
            loadmore:function($state){
                if(this.pageNo !== null)
                {
                    axios({
                        url:this.pageNo,
                        method:'get'
                    }).then((res)=>{
                        $state.loaded();
                        this.pageNo = res.data.data.next_page_url;
                        for(var i = 0; i<res.data.data.data.length; i++){
                            this.tweets.push(res.data.data.data[i]);
                        }
                    })
                }else{
                    $state.complete();
                }
            },
            loadManual:function(){
                if(this.pageNo !== null)
                {
                    axios({
                        url:this.pageNo,
                        method:'get'
                    }).then((res)=>{
                        this.pageNo = res.data.data.next_page_url;
                        for(var i = 0; i<res.data.data.data.length; i++){
                            this.tweets.push(res.data.data.data[i]);
                        }
                    })
                }else{
                    this.more   = false
                }
            }
        },
        mounted : function(){
            axios({
                url : '/fetchOldTweets'
            }).then(function(response){
                this.loading    = false
                this.tweets     = response.data.data.data
                this.total      = response.data.data.total
                this.actions    = response.data.actions
                this.pageNo     = response.data.data.next_page_url
            }.bind(this))
        }
    }
</script>
