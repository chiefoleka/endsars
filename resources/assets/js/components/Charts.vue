<template>
    <div>
        <svg viewBox="-1 -1 2 2" class="vue-chart-pie"><defs>
            <mask id="vue-chart-pie-mask" >
                <rect x="-1" y="-1" width="2" height="2" fill="white"/>
                <circle cx="0" cy="0" r="0.5" fill="black"/>
            </mask>
            </defs>
        </svg>
    </div>
</template>

<script>
    export default {
        data : function(){
            return{
                pie:[
                  { percent: 0.10 },
                  { percent: 0.65 },
                  { percent: 0.25 },
                ],
                options : [

                ]
            }
        },
        components : {
        },
        methods : {
            getCoordinatesForPercent(percent) {
              const x = Math.cos(2 * Math.PI * percent);
              const y = Math.sin(2 * Math.PI * percent);
              return [x, y];
            }
        },
        mounted : function(){
            axios({
                url : '/chartdata'
            }).then(function(response){
                console.log(response.data.data)
                this.data     = response.data.data
            }.bind(this))
            let cumulativePercent = 0;
            this.pie.forEach(slice => {
              // destructuring assignment sets the two variables at once
              const [startX, startY] = this.getCoordinatesForPercent(cumulativePercent);

              // each slice starts where the last slice ended, so keep a cumulative percent
              cumulativePercent += slice.percent;

              const [endX, endY] = this.getCoordinatesForPercent(cumulativePercent);

              // if the slice is more than 50%, take the large arc (the long way around)
              const largeArcFlag = slice.percent > .5 ? 1 : 0;

                // create an array and join it just for code readability
              const pathData = [
                `M ${startX} ${startY}`, // Move
                `A 1 1 0 ${largeArcFlag} 1 ${endX} ${endY}`, // Arc
                `L 0 0`, // Line
              ].join(' ');

              // create a <path> and append it to the <svg> element
              const pathEl = document.createElementNS('http://www.w3.org/2000/svg', 'path');
              pathEl.setAttribute('d', pathData);
              pathEl.setAttributeNS(null, 'mask', 'url(#vue-chart-pie-mask)');
              this.$el.appendChild(pathEl);
            });   
        }
    }
</script>
<style type="text/css">
    .vue-chart-pie {
        width: 100%;
        transform-origin: center;
        transform: rotate(-90deg);
        path { stroke: white; stroke-width: 0; transform:rotate(-1turn); transition: 1s; opacity:1;}
        path:nth-of-type(1){ fill: tomato;  transition-delay: 300ms;}
        path:nth-of-type(2){ fill: olive;   transition-delay: 200ms;}
        path:nth-of-type(3){ fill: skyblue; transition-delay: 100ms;}
        path:nth-of-type(4){ fill: gold;    transition-delay: 0ms;} 
        &:hover path{ transform: none; opacity:1; } 
    }
</style>
