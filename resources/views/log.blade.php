@extends('layouts.sidebar')

@section('title', 'Home Page')

@section('content')
    <style>
        canvas {
            height: 300px !important;
            width: 100% !important; /* Make sure canvas takes full width of its container */
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
            flex-direction: column; /* Ensure items stack vertically */
            font-size: 14px; /* Increase font size for better readability */
            color: #333; /* Dark color for better contrast */
        }
        
        .chart-description div {
            margin-bottom: 10px; /* Increase space between lines */
            white-space: nowrap; /* Prevent line breaks within the content */
        }
        .chart-title {
            font-size: 16px; /* Larger font size for better readability */
            font-weight: bold; /* Make text bold */
            color: #333; /* Dark color for better contrast */
        }

        .chart-label {
            font-size: 14px; /* Increase font size for better readability */
            color: #333; /* Dark color for better contrast */
        }

        .table-container {
            max-height: 200px; /* Adjust as needed */
            overflow-y: auto; /* Enable vertical scrolling */
        }

        .table thead th {
            position: sticky;
            top: 0;
            background: #f8f9fa; /* Background color for sticky header */
            z-index: 1; /* Ensure header is above table rows */
        }

        .filter-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
        }

        .filter-container select {
            padding: 5px;
            font-size: 14px;
            min-width: 150px; /* Set a minimum width for the dropdowns */
        }

        .filter-container select#timeFilter {
            min-width: 200px; /* Set a specific width for the time filter */
        }

        .filter-container select#attackTypeFilter {
            min-width: 200px; /* Set a specific width for the attack type filter */
        }
    </style>

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Log</h1>
            <div class="filter-container">
                <select class="form-select" id="timeFilter">
                    <option value="">Select Time Range</option>
                    <option value="5m">Last 5 minutes</option>
                    <option value="15m">Last 15 minutes</option>
                    <option value="30m">Last 30 minutes</option>
                    <option value="1h">Last 1 hour</option>
                    <option value="3h">Last 3 hours</option>
                    <option value="6h">Last 6 hours</option>
                    <option value="12h">Last 12 hours</option>
                    <option value="24h">Last 24 hours</option>
                    <option value="2d">Last 2 days</option>
                    <option value="7d">Last 7 days</option>
                    <option value="30d">Last 30 days</option>
                    <option value="90d">Last 90 days</option>
                    <option value="6m">Last 6 months</option>
                    <option value="1y">Last 1 year</option>
                    <option value="2y">Last 2 years</option>
                    <option value="5y">Last 5 years</option>
                </select>

                <select class="form-select" id="attackTypeFilter">
                    <option value="">Select Attack Type</option>
                    <option value="Botnet">Botnet</option>
                    <option value="Malware">Malware</option>
                    <option value="Trojan">Trojan</option>
                    <!-- More options as needed -->
                </select>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <h5 class="card-title">Total Threat</h5>
                        <canvas id="userCountChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
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
                        <h5 class="card-title">Top Destination</h5>
                        <canvas id="topDestChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Top URL</h5>
                        <canvas id="topURLChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <h5>Log Table</h5>
                <div class="table-container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Attack</th>
                                <th>Dest IP</th>
                                <th>Dest port/Dest user</th>
                                <th>Src IP</th>
                                <th>Src port/Src user</th>
                                <th>Threat Level</th>
                                <th>Counter</th>
                                <th>Altered</th>
                                <th>URL</th>
                                <th>Action</th>
                                <th>Rule ID</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2024-07-24 09:27:34</td>
                                <td>botnet</td>
                                <td>162.18.2.63</td>
                                <td>0:0:0:0:0:0</td>
                                <td>null</td>
                                <td>0.0.0.0</td>
                                <td>High</td>
                                <td>24</td>
                                <td>True</td>
                                <td>www.botnet.com</td>
                                <td>Denied</td>
                                <td>0</td>
                            </tr>
                            <!-- More rows as needed -->
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

    var ctx2 = document.getElementById('topUserChart').getContext('2d');
    var topUserChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['User 1', 'User 2', 'User 3'],
            datasets: [{
                label: 'Top Users',
                data: [15, 10, 5],
                backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                borderColor: ['rgba(255, 99, 132, 1)', 'rgba(255, 99, 132, 1)', 'rgba(255, 99, 132, 1)'],
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

    var ctx3 = document.getElementById('topDestChart').getContext('2d');
    var topDestChart = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: ['Destination 1', 'Destination 2', 'Destination 3'],
            datasets: [{
                label: 'Top Destinations',
                data: [12, 9, 6],
                backgroundColor: ['rgba(255, 206, 86, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                borderColor: ['rgba(255, 206, 86, 1)', 'rgba(255, 206, 86, 1)', 'rgba(255, 206, 86, 1)'],
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

    var ctx4 = document.getElementById('topURLChart').getContext('2d');
    var topURLChart = new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: ['URL 1', 'URL 2', 'URL 3'],
            datasets: [{
                label: 'Top URLs',
                data: [10, 8, 7],
                backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(54, 162, 235, 1)', 'rgba(54, 162, 235, 1)'],
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
</script>
@endsection
