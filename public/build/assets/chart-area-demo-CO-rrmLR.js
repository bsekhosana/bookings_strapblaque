Chart.defaults.global.defaultFontFamily="Metropolis";Chart.defaults.global.defaultFontColor="#858796";function l(a,o,r,u){a=(a+"").replace(",","").replace(" ","");var i=isFinite(+a)?+a:0,t=isFinite(+o)?Math.abs(o):0,d=",",s=".",e="",g=function(c,p){var n=Math.pow(10,p);return""+Math.round(c*n)/n};return e=(t?g(i,t):""+Math.round(i)).split("."),e[0].length>3&&(e[0]=e[0].replace(/\B(?=(?:\d{3})+(?!\d))/g,d)),(e[1]||"").length<t&&(e[1]=e[1]||"",e[1]+=new Array(t-e[1].length+1).join("0")),e.join(s)}var b=document.getElementById("myAreaChart");new Chart(b,{type:"line",data:{labels:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],datasets:[{label:"Earnings",lineTension:.3,backgroundColor:"rgba(0, 97, 242, 0.05)",borderColor:"rgba(0, 97, 242, 1)",pointRadius:3,pointBackgroundColor:"rgba(0, 97, 242, 1)",pointBorderColor:"rgba(0, 97, 242, 1)",pointHoverRadius:3,pointHoverBackgroundColor:"rgba(0, 97, 242, 1)",pointHoverBorderColor:"rgba(0, 97, 242, 1)",pointHitRadius:10,pointBorderWidth:2,data:[0,1e4,5e3,15e3,1e4,2e4,15e3,25e3,2e4,3e4,25e3,4e4]}]},options:{maintainAspectRatio:!1,layout:{padding:{left:10,right:25,top:25,bottom:0}},scales:{xAxes:[{time:{unit:"date"},gridLines:{display:!1,drawBorder:!1},ticks:{maxTicksLimit:7}}],yAxes:[{ticks:{maxTicksLimit:5,padding:10,callback:function(a,o,r){return"$"+l(a)}},gridLines:{color:"rgb(234, 236, 244)",zeroLineColor:"rgb(234, 236, 244)",drawBorder:!1,borderDash:[2],zeroLineBorderDash:[2]}}]},legend:{display:!1},tooltips:{backgroundColor:"rgb(255,255,255)",bodyFontColor:"#858796",titleMarginBottom:10,titleFontColor:"#6e707e",titleFontSize:14,borderColor:"#dddfeb",borderWidth:1,xPadding:15,yPadding:15,displayColors:!1,intersect:!1,mode:"index",caretPadding:10,callbacks:{label:function(a,o){var r=o.datasets[a.datasetIndex].label||"";return r+": $"+l(a.yLabel)}}}}});
