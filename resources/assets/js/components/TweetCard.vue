<template>
    <div class="col-md-4 tweet" style="margin-top: 40px">
        <a :href="'https://twitter.com/'+tweet.handle"><h4>{{tweet.name}}</h4></a>
        <div class="row summary" v-html>{{tweet.tweet}}</div>
        <span><i class="fa fa-retweet"></i> {{tweet.retweets}} &nbsp;</span>
        <br>
    </div>
</template>

<script>
    export default {
        props:['tweet'],
    }
</script>
