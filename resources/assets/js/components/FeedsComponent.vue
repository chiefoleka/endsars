<template>
    <div>
        <div class="flex-center" style="margin-top: 40px" v-if="loading != false">
            <i class="fa fa-spinner fa-5x fa-spin"></i>
            <p class="text-center">Loading feeds ... </p>
        </div>
        <transition-group name="fade" tags="div">
            <div class="col-md-4 tweet" style="margin-top: 40px" v-for="(tweet,index) in tweets" :key="index">
                <a :href="'https://twitter.com/'+tweet.user.screen_name"><h4>{{tweet.user.name}}</h4></a>
                <div class="row summary" v-html>{{tweet.text}}</div>
                <span><i class="fa fa-retweet"></i> {{tweet.retweet_count}} &nbsp;</span>
                <br>
            </div>
        </transition-group>
        <infinite-loading @infinite="loadmore">
            <span slot="no-more">
              There are no more stories
            </span>
        </infinite-loading>
    </div>
</template>

<script>
    import TweetCard from './TweetCard.vue';
    import InfiniteLoading from 'vue-infinite-loading';
    export default {
        data : function(){
            return{
                tweets  : [],
                loading : true
            }
        },
        components : {
            tweet : TweetCard,
            InfiniteLoading
        },
        methods : {
            loadmore:function($state){
                axios({
                    url:'/getTweets',
                    method:'get'
                }).then((res)=>{
                    $state.loaded();
                    for(var i = 0; i<res.data.data.length; i++){
                        this.tweets.push(res.data.data[i]);
                    }
                })
            }
        },
        mounted : function(){
            axios({
                url : '/getTweets'
            }).then(function(response){
                this.loading    = false
                this.tweets     = response.data.data
            }.bind(this))
        }
    }
</script>
