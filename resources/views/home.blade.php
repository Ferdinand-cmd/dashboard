@extends('layouts.sidebar')

@section('title', 'Home Page')

@section('content')
    <style>
        canvas {
            height: 300px !important;
            width: 100% !important; /* Ensure canvas takes full width */
        }

        .chart-container {
            display: flex;
            align-items: flex-start; /* Align items at the start */
            justify-content: space-between;
        }

        .chart-description {
            margin-left: 20px;
            max-width: 200px;
            display: flex;
            flex-direction: column; /* Stack items vertically */
            font-size: 14px; /* Increase font size for readability */
            color: #333; /* Dark color for contrast */
        }

        .chart-description div {
            margin-bottom: 10px; /* Increase space between lines */
            white-space: nowrap; /* Prevent line breaks */
        }

        .chart-title {
            font-size: 16px; /* Larger font size */
            font-weight: bold; /* Make text bold */
            color: #333; /* Dark color for contrast */
        }

        .chart-label {
            font-size: 14px; /* Increase font size */
            color: #333; /* Dark color for contrast */
        }

        .table-container {
            max-height: 200px; /* Adjust height as needed */
            overflow-y: auto; /* Enable vertical scrolling */
        }

        .table thead th {
            position: sticky;
            top: 0;
            background: #f8f9fa; /* Background color for sticky header */
            z-index: 1; /* Ensure header is above table rows */
        }

        .action-allowed {
            background-color: #d4edda !important; /* Green for Allow */
        }

        .action-denied {
            background-color: #f8d7da !important; /* Red for Denied */
        }

        .alert-success {
            background-color: #d4edda !important; /* Green for Successful */
        }

        .alert-failed {
            background-color: #f8d7da !important; /* Red for Failed */
        }

        .alert-not-alert {
            background-color: #fff3cd !important; /* Yellow for Not alert */
        }
    </style>
    <div class="container-fluid">
        <h1>Dashboard</h1>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <h5 class="card-title">Total Infected User</h5>
                        <canvas id="userCountChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Success Alert</h5>
                        <div class="chart-container">
                            <canvas id="successAlertChart"></canvas>
                            <div class="chart-description" id="chartDescription">
                                <!-- Descriptions will be populated here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Top User</h5>
                        <canvas id="topUserChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Top Attack Type</h5>
                        <canvas id="topAttackTypeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <h5>Infected User</h5>
                <div class="table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Dest User</th>
                                <th>Dest IP</th>
                                <th>Attack Type</th>
                                <th>Action Taken</th>
                                <th>Alert Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2024-07-24</td>
                                <td>a21938729</td>
                                <td>172.22.102.182</td>
                                <td>Botnet</td>
                                <td class="action-denied">Denied</td>
                                <td class="alert-success">True</td>
                            </tr>
                            <!-- Repeat rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
    </div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('userCountChart').getContext('2d');
    var userCountChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['00:00', '00:01', '00:02', '00:03', '00:04', '00:05', '00:06', '00:07', '00:08', '00:09', '00:10', '00:11', '00:12', '00:13', '00:14'],
            datasets: [{
                label: 'Total User',
                data: [5, 10, 12, 8, 15, 20, 25, 30, 28, 32, 35, 28, 16, 10, 2],
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                fill: false,
                pointBackgroundColor: 'rgba(75, 192, 192, 1)',
                pointBorderColor: '#fff',
                pointRadius: 8,
                pointHoverRadius: 10,
                hitRadius: 20
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Time (Minutes)',
                        font: {
                            size: 16
                        }
                    },
                    ticks: {
                        font: {
                            size: 14
                        }
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'User Count',
                        font: {
                            size: 16
                        }
                    },
                    ticks: {
                        font: {
                            size: 14
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return 'User Count: ' + tooltipItem.raw;
                        }
                    },
                    bodyFont: {
                        size: 14
                    },
                    titleFont: {
                        size: 16
                    }
                }
            }
        }
    });

    var ctx2 = document.getElementById('successAlertChart').getContext('2d');
    var successAlertChart = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Successful', 'Failed', 'Not alert'],
            datasets: [{
                label: 'Alert Status',
                data: [10, 20, 30],
                backgroundColor: [
                    'rgba(76, 175, 80, 0.2)',  // Green for Successful
                    'rgba(244, 67, 54, 0.2)',  // Red for Failed
                    'rgba(255, 235, 59, 0.2)'   // Yellow for Not alert
                ],
                borderColor: [
                    'rgba(76, 175, 80, 1)',    // Green for Successful
                    'rgba(244, 67, 54, 1)',    // Red for Failed
                    'rgba(255, 235, 59, 1)'    // Yellow for Not alert
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            var dataset = tooltipItem.dataset;
                            var dataIndex = tooltipItem.dataIndex;
                            var value = dataset.data[dataIndex];
                            return tooltipItem.label + ': ' + value;
                        }
                    },
                    bodyFont: {
                        size: 14
                    },
                    titleFont: {
                        size: 16
                    }
                },
                datalabels: {
                    display: true,
                    color: '#333',
                    font: {
                        size: 14,
                    }
                }
            }
        }
    });

    // Add description to the pie chart
    function updateChartDescription(chart) {
        const descriptionContainer = document.getElementById('chartDescription');
        descriptionContainer.innerHTML = ''; // Clear existing content
        chart.data.labels.forEach((label, index) => {
            const dataValue = chart.data.datasets[0].data[index];
            const description = document.createElement('div');
            description.textContent = `${label}: ${dataValue}`;
            descriptionContainer.appendChild(description);
        });
    }

    updateChartDescription(successAlertChart);

    var ctx3 = document.getElementById('topUserChart').getContext('2d');
    var topUserChart = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: ['User 1', 'User 2', 'User 3'],
            datasets: [{
                label: 'Top Users',
                data: [15, 10, 5],
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    ticks: {
                        font: {
                            size: 14
                        }
                    }
                },
                y: {
                    ticks: {
                        font: {
                            size: 14
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                datalabels: {
                    display: true,
                    color: '#333',
                    font: {
                        size: 14,
                        weight: 'bold'
                    },
                    anchor: 'end',
                    align: 'end'
                }
            }
        }
    });

    var ctx4 = document.getElementById('topAttackTypeChart').getContext('2d');
    var topAttackTypeChart = new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: ['Attack 1', 'Attack 2', 'Attack 3'],
            datasets: [{
                label: 'Top Attack Types',
                data: [12, 9, 7],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    ticks: {
                        font: {
                            size: 14
                        }
                    }
                },
                y: {
                    ticks: {
                        font: {
                            size: 14
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                datalabels: {
                    display: true,
                    color: '#333',
                    font: {
                        size: 14,
                        weight: 'bold'
                    },
                    anchor: 'end',
                    align: 'end'
                }
            }
        }
    });

</script>
@endsection
