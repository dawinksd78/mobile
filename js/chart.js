Highcharts.setOptions({
	lang: {
		rangeSelectorZoom: ''
	}
});

// create the chart
function chartinit(chartcontainer)
{
    //if(window.location.hostname !=='www.dawin.xyz' && window.location.hostname !=='test.dawin.xyz') {
    	//return false;
    //}
    
    var chart = Highcharts.stockChart(chartcontainer, {
        exporting: {
            enabled: false
        },
        plotOptions: {
            series: {
                lineWidth: 1,
                marker: {
                    states: {
                        hover: {
                            radiusPlus: 5,
                            lineWidthPlus: 1
                        }
                    }
                },
                states: {
                    hover: {
                        lineWidth: 3
                    }
                },
                point: {
                  events: {
                      click: function () {
                          //alert(tooltip_nowmonth);
                      }
                  }
                }
            },
        },
        chart: {
            events: {
                click: function(event) {
                    //alert(Highcharts.dateFormat('%Y-%m', event.xAxis[0].value) );
                    //alert(tooltip_nowmonth);
                    ;
                },
                load : function () {
                    this.xAxis[0].setExtremes( caldate(1) );
                }
            }
        },
        legend: {
          enabled:false,
          align: 'top',
          verticalAlign: 'top',
          borderWidth: 0,
          //labelFormatter: function() { return "123"; }
      },
        rangeSelector: {
            enabled : false,
            allButtonsEnabled: false,
            inputEnabled: false,
            buttonPosition: {
                align: 'left',
                x : -15
            },
            buttonTheme: { // styles for the buttons
                fill: 'none',
                stroke: 'none',
                'stroke-width': 0,
                r: 10,
                width: 32,
                style: {
                    color: '#626262',
                    fontWeight: 'bold',
                    fontSize: '14px'
                },
                states: {
                    hover: {},
                    select: {
                        fill: '#626262',
                        style: {
                            color: 'white'
                        }
                    }
                    // disabled: { ... }
                }
            },
            buttons: [{
                type: 'month',
                count: 12,
                text: '1년',
                dataGrouping: {
                    forced: false,
                    units: [
                        ['month', [1]]
                    ]
                }
            }, {
                type: 'month',
                count: 36,
                text: '3년',
                dataGrouping: {
                    forced: true,
                    units: [
                        ['month', [1]]
                    ]
                }
            }, {
                type: 'month',
                count: 60,
                text: '5년',
                dataGrouping: {
                    forced: false,
                    units: [
                        ['month', [1]]
                    ]
                }
            }, {
                type: 'all',
                text: '10년',
                dataGrouping: {
                    forced: false,
                    units: [
                        ['month', [1]]
                    ]
                }
            }],
            selected: 0
        },
        navigator: {
            enabled: false,
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    month: '%Y-%m'
                }
            }
        },
        scrollbar: {
            enabled: false
        },
        //title: {text: 'AAPL Historical'},
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {
                month: '%Y-%m'
            }
        },
        yAxis: [{
            opposite: false,
            labels: {
                formatter: function() {
                    return fnMoneyAboutText(this.value*10000);
                },
                align: 'right',
                x: -3
            },
            //title: {text: 'OHLC'},
            height: '100%',
            lineWidth: 0,
            resize: {
                enabled: true,
                lineWidth: 1,
                lineColor: '#999',
            }
        }, {
            labels: {
                enabled: false,
                align: 'right',
                x: -3
            },
            opposite: false,
            //title: { text: 'Volume'},
            top: '100%',
            height: '0%',
            offset: 0,
            lineWidth: 0
        }],

        series: [{
            id: 'mainchart',
            data: ohlc,
            lineWidth: 2,
            type: 'spline',
            name: '매매',
            color: '#ff5c14',
            dataGrouping: {
                units: groupingUnits
            },
            //tooltip: {xDateFormat: '%Y-%m',valueSuffix: '억'},
        }, {
            linkto: 'mainchart',
            data: ohlc2,
            //      type: 'spline',
            lineWidth: 2,
            name: '전세',
            color: '#3dbf9f',
            dataGrouping: {
                units: groupingUnits
            },
            // tooltip: {xDateFormat: '%Y-%m', valueSuffix: '억'},
        }, {
            type: 'column',
            id: 'columntype',
            name: '매매건수',
            data: volume,
            color: '#ff5c14',
            yAxis: 1,
            dataGrouping: {
                units: groupingUnits
            }
        }, {
            type: 'column',
            linkto: 'columntype',
            name: '전세건수',
            data: volume2,
            color: '#3dbf9f',
            yAxis: 1,
            dataGrouping: {
                units: groupingUnits
            }
        }], // series
        tooltip: {
            shared: !0,
            borderWidth: 0,
            shadow: false,
            style: {
                fontSize: '10px'
            },
            positioner: function(e, t, n) {
                return {
                    x: this.chart.chartWidth - n.plotX > tooltipMaxwidth ? n.plotX : this.chart.chartWidth - tooltipMaxwidth,
                    y: 0
                }
            },
            formatter: function() {
                var s = '<b>' + Highcharts.dateFormat('%Y.%m', this.x) + '</b>';
                var s1='' , s2='';
                tooltip_nowmonth = Highcharts.dateFormat('%Y.%m', this.x);
                $.each(this.points, function() {
                    if (this.series.name == "매매") s1 = '<br/>' + this.series.name + ': ' + fnMoneyAboutText(this.y*10000);
                    else if (this.series.name == "전세") s2 = '<br/>' + this.series.name + ': ' + fnMoneyAboutText(this.y*10000);
                    else if (this.series.name == "매매건수") s1 += ' (' + this.y + '건)';
                    else if (this.series.name == "전세건수") s2 += ' (' + this.y + '건)';
                });
                return s + s1 + s2;
            }
        },
    });
    return chart;
}

function charttoggle(bt)
{
	if($(bt).data('btenable') != true) return false;
	
	var toggledata = $(bt).data('chartview');
	if(toggledata == 'all')	// 전체 매물
	{
		chart.series[0].show();
		chart.series[1].show();
		chart.series[2].show();
		chart.series[3].show();
		setlastprice('all');
		tradelistset.transtype = 'all';
		tradelistset.page = 0;
		$("#view_detail_template_price_list_more").show();	// 실거래가 더보기 출력
		getTradeList();
	}
	else if(toggledata == 'sale')	// 매매
	{
		chart.series[0].show();
		chart.series[1].hide();
		chart.series[2].show();
		chart.series[3].hide();
		setlastprice('sale');
		tradelistset.transtype = 'sale';
		tradelistset.page = 0;
		$("#view_detail_template_price_list_more").show();	// 실거래가 더보기 출력
		getTradeList();
	}
	else	// 전,월세
	{
		chart.series[0].hide();
		chart.series[1].show();
		chart.series[2].hide();
		chart.series[3].show();
		setlastprice('previous');
		tradelistset.transtype = 'previous';
		tradelistset.page = 0;
		$("#view_detail_template_price_list_more").show();	// 실거래가 더보기 출력
		getTradeList();
	}

	$("#charttoggle_tab li a").each(function(){
		$(this).removeClass("on");
	});

	$(bt).addClass("on");
}

function fnchartRangeChange(link)
{
	var year = $(link).data('year');
	var utc = caldate(year);
    chart.xAxis[0].setExtremes(utc);
    $(".bt_change_range").removeClass("on")
    $(link).addClass("on");
}

function setlastprice(type)
{
	if(type == 'previous') {
		$("#view_detail_template_price").text(fnMoneyAboutText(last_charter_price*10000));
	}
	else {
		$("#view_detail_template_price").text(fnMoneyAboutText(last_sale_price*10000));
	}
}
