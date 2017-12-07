<template>
    <div class="col-md-12" style="margin-top: 40px">
        <a :href="'https://twitter.com/'+tweet.handle"><h4>{{tweet.name}}</h4></a>
        <div class="row summary" v-html>{{tweet.tweet}}</div>
        <span><i class="fa fa-retweet"></i> {{tweet.retweets}} &nbsp;</span>
        <div class="row">
            <span class="col-md-6 col-xs-12" style="margin-bottom: 10px" v-for="(action,index) in actions">
                <input type="checkbox" name="actions[]" value="action.id" @click="check(action.id)"> {{action.name}}
            </span>
        </div>
        <div class="row">
            <button @click="remove(tweet)" class="btn btn-danger pull-right" type="button" >&times;</button>
            <button @click="update(tweet)" class="btn btn-primary" type="button" >Update</button>
        </div>
    </div>
</template>

<script>
    export default {
        props:['tweet','actions'],
        data : function(){
            return {
                checked : []
            }
        },
        methods : {
            check  : function(id){
                if(this.checked.indexOf(id) < 0){
                    this.checked.push(id)
                }
                else {
                    this.checked.splice(this.checked.indexOf(id), 1)
                }
            },
            remove : function(e){
                this.$emit('remove',e)
            },
            update : function(item){
                axios({
                    url     : '/addActions',
                    data    : {
                        id      : item.id_str.replace(/^'+|'+$/g,''),
                        actions : this.checked
                    },
                    method  : 'post',
                    type    : 'json',
                }).then((response) => {
                    console.log(response, this.checked)
                    this.$emit('update', item)
                }) 
            }
        }
    }
</script>
