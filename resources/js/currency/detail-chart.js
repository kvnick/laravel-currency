$(function () {
    'use strict';

    /*
     * Amcharts3
     * -------
     * Here we will create a few charts using Amchrts3
    */

    var amChartContainer = "chartdiv";
    var amChartLoaderUrl = $('#' + amChartContainer).attr('data-load-url');
    var amChartDataLoaderObj = {
        "url": amChartLoaderUrl,
        "format": "json"
    };
    var amChartConfig = {
        "type": "stock",
        "theme": "light",

        "marginRight": 40,
        "marginLeft": 40,
        "autoMarginOffset": 20,

        "dataDateFormat": "DD-MM-YYYY",
        "language": "ru",

        "dataSets": [{
            color: "#b0de09",
            fieldMappings: [ {
                fromField: "value",
                toField: "value"
            }],
            dataLoader : amChartDataLoaderObj,
            categoryField: "date"
        }],
        panels: [{
            showCategoryAxis: true,
            title: "Value",
            eraseAll: false,

            stockGraphs: [{
                id: "g1",
                valueField: "value",
                useDataSetColors: false
            }],

            stockLegend: {
                valueTextRegular: " ",
                markerType: "none"
            },
            drawingIconsEnabled: true
        }],

        chartScrollbarSettings: {
            graph: "g1"
        },

        chartCursorSettings: {
            valueBalloonsEnabled: true
        },

        periodSelector: {
            // position: "bottom",
            hideOutOfScopePeriods: false,
            inputFieldsEnabled: false,
            selectFromStart: false,
            width: 0,
            inputFieldWidth: 0,
            periodsText: "",
            periods: [{
                period: "DD",
                count: 7,
                label: "1 неделя"
            },{
                period: "MM",
                count: 1,
                label: "1 месяц",
                selected: true
            },{
                period: "MM",
                count: 3,
                label: "3 месяца"
            },{
                period: "MM",
                count: 6,
                label: "полгода"
            },{
                period: "YYYY",
                count: 1,
                label: "1 год"
            },{
                period: "YYYY",
                count: 2,
                label: "2 года"
            },{
                period: "MAX",
                label: "MAX"
            } ]
        }
    };
    // config obj form init chart
    var amChartConfig2 = {
        "type": "serial",
        "theme": "light",
        // "marginRight": 40,
        // "marginLeft": 40,
        "autoMarginOffset": 20,
        "dataDateFormat": "DD-MM-YYYY",
        "language": "ru",
        "valueAxes": [{
            "id": "v1",
            "axisAlpha": 0,
            "position": "left",
            "ignoreAxisWidth":true
        }],
        "balloon": {
            "borderThickness": 1,
            "shadowAlpha": 0
        },
        "graphs": [{
            "id": "g1",
            "balloon":{
                "drop":true,
                "adjustBorderColor":false,
                "color":"#ffffff"
            },
            "bullet": "round",
            "bulletBorderAlpha": 1,
            "bulletColor": "#FFFFFF",
            "bulletSize": 5,
            "hideBulletsCount": 50,
            "lineThickness": 2,
            "title": "red line",
            "useLineColorForBulletBorder": true,
            "valueField": "value",
            "balloonText": "<span style='font-size:18px;'>[[value]]</span>"
        }],
        "chartScrollbar": {
            "graph": "g1",
            "oppositeAxis":false,
            "offset":30,
            "scrollbarHeight": 80,
            "backgroundAlpha": 0,
            "selectedBackgroundAlpha": 0.1,
            "selectedBackgroundColor": "#888888",
            "graphFillAlpha": 0,
            "graphLineAlpha": 0.5,
            "selectedGraphFillAlpha": 0,
            "selectedGraphLineAlpha": 1,
            "autoGridCount":true,
            "color":"#AAAAAA"
        },
        "chartCursor": {
            "pan": true,
            "valueLineEnabled": true,
            "valueLineBalloonEnabled": true,
            "cursorAlpha":1,
            "cursorColor":"#258cbb",
            "limitToGraph":"g1",
            "valueLineAlpha":0.2
        },
        "valueScrollbar":{
            "oppositeAxis":false,
            "offset":50,
            "scrollbarHeight":10
        },
        "categoryField": "date",
        "categoryAxis": {
            "parseDates": true,
            "dashLength": 1,
            "minorGridEnabled": true
        },
        "export": {
            "enabled": true
        },
        "dataLoader" : amChartDataLoaderObj
    };

    var chart = AmCharts.makeChart(amChartContainer, amChartConfig);
    chart.addListener("rendered", zoomAmChart);
    zoomAmChart();

    function zoomAmChart() {
        // chart.zoomToIndexes(chart.dataLoader.length - 40, chart.dataLoader.length - 1);
    }

    chart.addListener("dataUpdated", zoomChart);
    //zoomChart();

    function zoomChart() {
        // if (chart.zoomToIndexes) {
        //         chart.zoomToIndexes(130, chartData.length - 1);
        // }
    }

    function changeChartPeriod(newPeriod, newCount) {
        var newCount = parseInt(newCount, 10) || 1,
            newPeriod = (newPeriod == null) ? "YYYY" : newPeriod;

        for (var x in chart.periodSelector.periods) {
            var period = chart.periodSelector.periods[x];
            if (newPeriod == period.period && newCount == period.count) {
                period.selected = true;
            } else {
                period.selected = false;
            }
        }
        chart.periodSelector.setDefaultPeriod();
    }

    $('.changeChartPeriod').on('click', function(e) {
        changeChartPeriod($(this).attr('data-chart-period'), $(this).attr('data-chart-count'));
    });
});
