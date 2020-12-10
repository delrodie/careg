/*
 Template Name: Aplomb - Bootstrap 4 Admin Dashboard
 Author: Mannatthemes
 Website: www.mannatthemes.com
 File: Chart js 
 */
!function(r){"use strict";var o=function(){};o.prototype.respChart=function(o,a,e,t){Chart.defaults.global.defaultFontColor="rgba(255,255,255,0.5)";var d=o.get(0).getContext("2d"),n=r(o).parent();function i(){o.attr("width",r(n).width());switch(a){case"Line":new Chart(d,{type:"line",data:e,options:t});break;case"Doughnut":new Chart(d,{type:"doughnut",data:e,options:t});break;case"Pie":new Chart(d,{type:"pie",data:e,options:t});break;case"Bar":new Chart(d,{type:"bar",data:e,options:t});break;case"Radar":new Chart(d,{type:"radar",data:e,options:t});break;case"PolarArea":new Chart(d,{data:e,type:"polarArea",options:t})}}r(window).resize(i),i()},o.prototype.init=function(){this.respChart(r("#lineChart"),"Line",{labels:["January","February","March","April","May","June","July","August","September","October"],datasets:[{label:"Sales Analytics",fill:!0,lineTension:.5,backgroundColor:"rgba(78, 189, 185, 0.3)",borderColor:"#4ebdb9",borderCapStyle:"butt",borderDash:[],borderDashOffset:0,borderJoinStyle:"miter",pointBorderColor:"#4ebdb9",pointBackgroundColor:"#fff",pointBorderWidth:5,pointHoverRadius:5,pointHoverBackgroundColor:"#4ebdb9",pointHoverBorderColor:"#4ebdb9",pointHoverBorderWidth:2,pointRadius:1,pointHitRadius:10,data:[65,59,80,81,56,55,40,55,30,80]},{label:"Monthly Earnings",fill:!0,lineTension:.5,backgroundColor:"rgba(221, 221, 221, 0.3)",borderColor:"#ddd",borderCapStyle:"butt",borderDash:[],borderDashOffset:0,borderJoinStyle:"miter",pointBorderColor:"#ddd",pointBackgroundColor:"#fff",pointBorderWidth:5,pointHoverRadius:5,pointHoverBackgroundColor:"#ddd",pointHoverBorderColor:"#ccc",pointHoverBorderWidth:2,pointRadius:1,pointHitRadius:10,data:[80,23,56,65,23,35,85,25,92,36]}]},{scales:{yAxes:[{ticks:{max:100,min:20,stepSize:10}}]}});this.respChart(r("#doughnut"),"Doughnut",{labels:["Desktops","Tablets"],datasets:[{data:[300,210],backgroundColor:["#4ebdb9","#7ca2a9"],borderColor:"transparent",innerRadius:"55%",hoverBackgroundColor:["#4ebdb9","#7ca2a9"],hoverBorderColor:"#aaa"}]});this.respChart(r("#pie"),"Pie",{labels:["Desktops","Tablets"],datasets:[{data:[300,180],backgroundColor:["#7ca2a9","#557ca2"],borderColor:"#aaa",hoverBackgroundColor:["#7ca2a9","#557ca2"],hoverBorderColor:"#aaaaaa"}]});this.respChart(r("#bar"),"Bar",{labels:["January","February","March","April","May","June","July","August","September"],datasets:[{label:"Sales Analytics",backgroundColor:"#8db7bf",borderColor:"#7b7b7b",borderWidth:1,hoverBackgroundColor:"#8db7bf",hoverBorderColor:"#d4cdcd",barPercentage:.3,categoryPercentage:.5,data:[65,59,81,45,56,80,50,20,81,50,14]}]},{responsive:!0,scales:{xAxes:[{barPercentage:.8,categoryPercentage:.4,display:!0}]}});this.respChart(r("#radar"),"Radar",{labels:["Eating","Drinking","Sleeping","Designing","Coding","Cycling","Running"],datasets:[{label:"Desktops",backgroundColor:"rgba(141, 183, 191, 0.4)",borderColor:"#8db7bf",pointBackgroundColor:"#8db7bf",pointBorderColor:"#fff",pointHoverBackgroundColor:"#fff",pointHoverBorderColor:"#01538d",data:[65,59,90,81,56,55,40],datasetStroke:"true"},{label:"Tablets",backgroundColor:"rgba(211, 172, 97, 0.4)",borderColor:"#d3ac61",pointBackgroundColor:"#d3ac61",pointBorderColor:"#fff",pointHoverBackgroundColor:"#fff",pointHoverBorderColor:"#d3ac61",data:[28,48,40,19,96,27,100],datasetStroke:"true"}]},{scale:{gridLines:{color:"#ddd"},angleLines:{color:"#ddd"}}});this.respChart(r("#polarArea"),"PolarArea",{datasets:[{data:[11,16,7,18],backgroundColor:["#1b2631","#d3ac61","#aaaaaa","#ccc"],borderColor:"#ddd",label:"My dataset",hoverBorderColor:"#aaa"}],labels:["Series 1","Series 2","Series 3","Series 4"]},{scale:{gridLines:{color:"#ddd"},angleLines:{color:"#ddd"}}})},r.ChartJs=new o,r.ChartJs.Constructor=o}(window.jQuery),function(r){"use strict";window.jQuery.ChartJs.init()}();