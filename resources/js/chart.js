$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'get',
        url: 'get-chart',
        success: function (response) {
            Chart.defaults.global.defaultFontColor = '#000000';
            Chart.defaults.global.defaultFontFamily = 'Helvetica';
            var barChart = document.getElementById('barChart');
            var myChart = new Chart(barChart, {
                type: 'bar',
                data: {
                    labels: response.labels,
                    datasets: [
                        {
                            label: response.revenue_label,
                            data: response.total_revenue,
                            backgroundColor: 'blue',
                            borderColor: 'rgba(0, 128, 128, 0.7)',
                            borderWidth: 1,
                            yAxisID: "revenue"
                        },
                        {
                            label: response.order_label,
                            data: response.total_order,
                            backgroundColor: 'rgba(0, 128, 128, 0.7)',
                            borderColor: 'rgba(0, 128, 128, 1)',
                            borderWidth: 1,
                            yAxisID: "orders"
                        }
                    ]
                },
                options: {
                    responsive: true,
                    elements: {
                        line :{
                            fill: false
                        }
                    },
                    title: {
                        display: true,
                        position: 'bottom',
                        text: response.title_chart,
                        fontSize: 16
                    },
                    scales: {
                        yAxes: [{
                            display: true,
                            position: 'left',
                            type: "linear",
                            scaleLabel: {
                                display: true,
                                labelString: 'USD',
                                beginAtZero: true,
                            },
                            gridLines: {
                                display: true
                            },
                            ticks: {
                                beginAtZero: true,
                                callback: function (value, index, values) {
                                    return value.toLocaleString('en-US', {
                                        style: 'currency',
                                        currency: 'USD'
                                    });
                                }
                            },
                            id: "revenue"
                        },{
                            scaleLabel: {
                                display: true,
                                labelString: response.right_label,
                                beginAtZero: true,
                            },
                            display: true,
                            type: "linear",
                            position:"right",
                            gridLines: {
                                display: true
                            },
                            ticks: {
                                stepSize: 1
                            },
                            id: "orders"
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem, data) {
                                if (tooltipItem.datasetIndex === 0) {
                                    return tooltipItem.yLabel.toLocaleString('en-US', {
                                        style: 'currency',
                                        currency: 'USD'
                                    });
                                } else if (tooltipItem.datasetIndex === 1) {
                                    return tooltipItem.yLabel + ' ' + response.right_label;
                                }
                            }
                        }
                    }
                }
            });
        }
    })
});
