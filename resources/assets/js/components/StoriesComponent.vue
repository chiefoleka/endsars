<template>
    <div>
        <div class="flex-center" style="margin-top: 40px" v-if="loading != false">
            <i class="fa fa-spinner fa-5x fa-spin"></i>
            <p class="text-center">Loading stories ... </p>
        </div>
        <transition-group name="fade" tag="div">
            <div class="col-md-12 incident-header" v-for="(story,index) in stories" :key="index">
                <a :href="'/incidents/'+story.id">
                    <h4>{{story.name}}<small class="pull-right"><i class="fa fa-map-marker"> {{story.location.name}}</i> &nbsp; <i class="fa fa-clock-o"> {{story.year}}</i></small></h4>
                </a>
                <div class="row summary" v-html="story.summary"></div>
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
    import InfiniteLoading from 'vue-infinite-loading';
    export default {
        data : function(){
            return{
                stories : [],
                pageNo  : null,
                total   : null,
                loading : true
            }
        },
        components : {
            InfiniteLoading
        },
        methods : {
            loadmore:function($state){
                console.log(this.pageNo)
                if(this.pageNo !== null)
                {
                    axios({
                        url:this.pageNo,
                        method:'get'
                    }).then((res)=>{
                        $state.loaded();
                        this.pageNo = res.data.data.next_page_url;
                        var stories     = res.data.data.data
                        for(var i = 0; i<stories.length; i++){
                            this.stories.push(stories[i]);
                        }
                    })
                }else{
                    $state.complete();
                }
            }
        },
        mounted : function(){
            axios({
                url : '/stories'
            }).then(function(response){
                this.loading    = false
                var stories     = response.data.data.data
                this.stories    = stories
                this.total      = response.data.data.total
                this.pageNo     = response.data.data.next_page_url
            }.bind(this))
        }
    }
</script>
