// ============dashboard widgets percentage =================
$(document).ready(function() {

    $.ajax({
                 type: "GET",
                 url: "unprosessed-ter-widgets",
                 success: function(response){
                     var current_month = parseInt(response.current_month_ter_count);
                     var previous_month = parseInt(response.previous_ter_count);
                     var old = parseInt(response.old);
          var options = {
                chart: {
                    type: 'donut',
                    width: 380
                },
                colors: ['#5c1ac3', '#e2a03f', '#e7515a', '#e2a03f'],
                dataLabels: {
                  enabled: false
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    fontSize: '14px',
                    markers: {
                      width: 10,
                      height: 10,
                    },
                    itemMargin: {
                      horizontal: 0,
                      vertical: 8
                    }
                },
                plotOptions: {
                  pie: {
                    donut: {
                      size: '65%',
                      background: 'transparent',
                      labels: {
                        show: true,
                        name: {
                          show: true,
                          fontSize: '29px',
                          fontFamily: 'Nunito, sans-serif',
                          color: undefined,
                          offsetY: -10
                        },
                        value: {
                          show: true,
                          fontSize: '26px',
                          fontFamily: 'Nunito, sans-serif',
                          color: '20',
                          offsetY: 16,
                          formatter: function (val) {
                            return val
                          }
                        },
                        total: {
                          show: true,
                          showAlways: true,
                          label: 'Total',
                          color: '#888ea8',
                          formatter: function (w) {
                            return w.globals.seriesTotals.reduce( function(a, b) {
                              return a + b
                            }, 0)
                          }
                        }
                      }
                    }
                  }
                },
                stroke: {
                  show: true,
                  width: 25,
                },
                series: [current_month, previous_month, old],
                labels: ['Current', 'Previous', 'Old'],
                responsive: [{
                    breakpoint: 1599,
                    options: {
                        chart: {
                            width: '350px',
                            height: '400px'
                        },
                        legend: {
                            position: 'bottom'
                        }
                    },
            
                    breakpoint: 1439,
                    options: {
                        chart: {
                            width: '250px',
                            height: '390px'
                        },
                        legend: {
                            position: 'bottom'
                        },
                        plotOptions: {
                          pie: {
                            donut: {
                              size: '65%',
                            }
                          }
                        }
                    },
                }]
          }
  
          var chart = new ApexCharts(
            document.querySelector("#chart-2"),
            options
          );
        chart.render();
                 }
             });
 
 });
//  ============================Daily Work Performance
$(document).ready(function() {

  $.ajax({
               type: "GET",
               url: "daily-work-performance",
               success: function(response){
                var vipin = response.user1.split(',');
                var veena = response.user2.split(',');
                var harpreet = response.user3.split(',');
                var rameshwer = response.user4.split(',');

                var month = response.countloop.split(',');


                var options1 = {
                  chart: {
                    fontFamily: 'Nunito, sans-serif',
                    height: 365,
                    type: 'area',
                    zoom: {
                        enabled: false
                    },
                    dropShadow: {
                      enabled: true,
                      opacity: 0.2,
                      blur: 10,
                      left: -7,
                      top: 22
                    },
                    toolbar: {
                      show: false
                    },
                    events: {
                      mounted: function(ctx, config) {
                        const highest1 = ctx.getHighestValueInSeries(0);
                        const highest2 = ctx.getHighestValueInSeries(1);
                        const highest3 = ctx.getHighestValueInSeries(2);
                        const highest4 = ctx.getHighestValueInSeries(3);
                
                        ctx.addPointAnnotation({
                          x: new Date(ctx.w.globals.seriesX[0][ctx.w.globals.series[0].indexOf(highest1)]).getTime(),
                          y: highest1,
                          label: {
                            style: {
                              cssClass: 'd-none'
                            }
                          },
                          customSVG: {
                              SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#1b55e2" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
                              cssClass: undefined,
                              offsetX: -8,
                              offsetY: 5
                          }
                        })
                
                        ctx.addPointAnnotation({
                          x: new Date(ctx.w.globals.seriesX[1][ctx.w.globals.series[1].indexOf(highest2)]).getTime(),
                          y: highest2,
                          label: {
                            style: {
                              cssClass: 'd-none'
                            }
                          },
                          customSVG: {
                              SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#e7515a" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
                              cssClass: undefined,
                              offsetX: -8,
                              offsetY: 5
                          }
                        })
                        ctx.addPointAnnotation({
                          x: new Date(ctx.w.globals.seriesX[2][ctx.w.globals.series[2].indexOf(highest3)]).getTime(),
                          y: highest3,
                          label: {
                            style: {
                              cssClass: 'd-none'
                            }
                          },
                          customSVG: {
                              SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#00ff00" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
                              cssClass: undefined,
                              offsetX: -8,
                              offsetY: 5
                          }
                        })
                
                        ctx.addPointAnnotation({
                          x: new Date(ctx.w.globals.seriesX[3][ctx.w.globals.series[3].indexOf(highest4)]).getTime(),
                          y: highest4,
                          label: {
                            style: {
                              cssClass: 'd-none'
                            }
                          },
                          customSVG: {
                              SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#ff00ff" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
                              cssClass: undefined,
                              offsetX: -8,
                              offsetY: 5
                          }
                        })
                        
                      },
                    }
                  },
                  colors: ['#1b55e2', '#e7515a','#00ff00','#ff00ff'],
                  dataLabels: {
                      enabled: false
                  },
                  markers: {
                    discrete: [{
                    seriesIndex: 0,
                    dataPointIndex: 7,
                    fillColor: '#000',
                    strokeColor: '#000',
                    size: 5
                  }, {
                    seriesIndex: 2,
                    dataPointIndex: 11,
                    fillColor: '#000',
                    strokeColor: '#000',
                    size: 4
                  }]
                  },
                  subtitle: {
                    text: response.total_ter,
                    align: 'left',
                    margin: 0,
                    offsetX: 45,
                    offsetY: 0,
                    floating: false,
                    style: {
                      fontSize: '18px',
                      color:  '#4361ee'
                    }
                  },
                  title: {
                    text: 'Total:',
                    align: 'left',
                    margin: 0,
                    offsetX: -10,
                    offsetY: 0,
                    floating: false,
                    style: {
                      fontSize: '18px',
                      color:  '#0e1726'
                    },
                  },
                  stroke: {
                      show: true,
                      curve: 'smooth',
                      width: 2,
                      lineCap: 'square'
                  },
                  series: [{
                      name: 'Vipin',
                      data: vipin
                  }, 
                  {
                      name: 'Veena',
                      data: veena
                  },
                  {
                    name: 'Harpreet',
                    data: harpreet
                 },{
                  name: 'Rameshwer',
                  data: rameshwer
               }
                ],
              
                  labels: month,
                  xaxis: {
                    axisBorder: {
                      show: false
                    },
                    axisTicks: {
                      show: false
                    },
                    crosshairs: {
                      show: true
                    },
                    labels: {
                      offsetX: 0,
                      offsetY: 5,
                      style: {
                          fontSize: '12px',
                          fontFamily: 'Nunito, sans-serif',
                          cssClass: 'apexcharts-xaxis-title',
                      },
                    }
                  },
                  yaxis: {
                    labels: {
                      formatter: function(value, index) {
                        return value
                      },
                      offsetX: -22,
                      offsetY: 0,
                      style: {
                          fontSize: '12px',
                          fontFamily: 'Nunito, sans-serif',
                          cssClass: 'apexcharts-yaxis-title',
                      },
                    }
                  },
                  grid: {
                    borderColor: '#e0e6ed',
                    strokeDashArray: 5,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    },   
                    yaxis: {
                        lines: {
                            show: false,
                        }
                    },
                    padding: {
                      top: 0,
                      right: 0,
                      bottom: 0,
                      left: -10
                    }, 
                  }, 
                  legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    offsetY: -50,
                    fontSize: '16px',
                    fontFamily: 'Nunito, sans-serif',
                    markers: {
                      width: 10,
                      height: 10,
                      strokeWidth: 0,
                      strokeColor: '#fff',
                      fillColors: undefined,
                      radius: 12,
                      onClick: undefined,
                      offsetX: 0,
                      offsetY: 0
                    },    
                    itemMargin: {
                      horizontal: 0,
                      vertical: 20
                    }
                  },
                  tooltip: {
                    theme: 'dark',
                    marker: {
                      show: true,
                    },
                    x: {
                      show: false,
                    }
                  },
                  fill: {
                      type:"gradient",
                      gradient: {
                          type: "vertical",
                          shadeIntensity: 1,
                          inverseColors: !1,
                          opacityFrom: .28,
                          opacityTo: .05,
                          stops: [45, 100]
                      }
                  },
                  responsive: [{
                    breakpoint: 575,
                    options: {
                      legend: {
                          offsetY: -30,
                      },
                    },
                  }]
                }

                /*
      ================================
          Revenue Monthly | Render
      ================================
  */
  var chart1 = new ApexCharts(
    document.querySelector("#revenueMonthly"),
    options1
);

chart1.render();
               }

              });


    });
