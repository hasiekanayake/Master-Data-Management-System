@extends('layouts.app')

@section('title', 'Dashboard - MDM System')

@section('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    .dashboard-card {
        border: none;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .dashboard-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
    }

    .card-brand {
        border-left: 4px solid var(--brand-color);
    }

    .card-category {
        border-left: 4px solid var(--category-color);
    }

    .card-item {
        border-left: 4px solid var(--item-color);
    }

    .card-recent {
        border-left: 4px solid var(--recent-color);
    }

    .icon-circle {
        height: 3rem;
        width: 3rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease;
    }

    .dashboard-card:hover .icon-circle {
        transform: scale(1.15);
    }

    .icon-brand {
        background-color: rgba(124, 58, 237, 0.2);
    }

    .icon-category {
        background-color: rgba(16, 185, 129, 0.2);
    }

    .icon-item {
        background-color: rgba(14, 165, 233, 0.2);
    }

    .icon-recent {
        background-color: rgba(245, 158, 11, 0.2);
    }

    .stats-count {
        font-size: 1.8rem;
        font-weight: 700;
    }

    .recent-item {
        border-left: 3px solid transparent;
        transition: all 0.3s;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        margin-bottom: 10px;
        padding: 1rem;
    }

    .recent-item:hover {
        border-left-color: var(--recent-color);
        background: rgba(255, 255, 255, 0.08);
        transform: translateX(5px);
    }

    .chart-container {
        position: relative;
        height: 250px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4" data-aos="fade-right">
        <div>
            <h1 class="h3 mb-0 text-white">Dashboard Overview</h1>
            <p class="text-secondary mb-0">Welcome back, {{ Auth::user()->name }}! Here's what's happening with your items today.</p>
        </div>
        <a href="#" class="d-none d-sm-inline-block btn btn-primary shadow-sm">
            <i class="bi bi-download text-white-50 me-1"></i> Generate Report
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Brands Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card glass-card card-brand h-100 py-3" data-aos="fade-up" data-aos-delay="100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-brand text-uppercase mb-1">
                                Brands
                            </div>
                            <div class="h5 mb-0 font-weight-bold stats-count">{{ $stats['brands'] }}</div>
                            <div class="text-secondary">Total brands in system</div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle icon-brand">
                                <i class="bi bi-tags text-brand"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('brands.index') }}" class="small text-decoration-none text-brand">
                        View details <i class="bi bi-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Categories Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card glass-card card-category h-100 py-3" data-aos="fade-up" data-aos-delay="200">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-category text-uppercase mb-1">
                                Categories
                            </div>
                            <div class="h5 mb-0 font-weight-bold stats-count">{{ $stats['categories'] }}</div>
                            <div class="text-secondary">Total categories in system</div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle icon-category">
                                <i class="bi bi-diagram-3 text-category"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('categories.index') }}" class="small text-decoration-none text-category">
                        View details <i class="bi bi-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Items Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card glass-card card-item h-100 py-3" data-aos="fade-up" data-aos-delay="300">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-item text-uppercase mb-1">
                                Items
                            </div>
                            <div class="h5 mb-0 font-weight-bold stats-count">{{ $stats['items'] }}</div>
                            <div class="text-secondary">Total items in system</div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle icon-item">
                                <i class="bi bi-box-seam text-item"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('items.index') }}" class="small text-decoration-none text-item">
                        View details <i class="bi bi-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-card glass-card card-recent h-100 py-3" data-aos="fade-up" data-aos-delay="400">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-recent text-uppercase mb-1">
                                Recent Activity
                            </div>
                            <div class="h5 mb-0 font-weight-bold stats-count">{{ $stats['recent'] }}</div>
                            <div class="text-secondary">Items added this month</div>
                        </div>
                        <div class="col-auto">
                            <div class="icon-circle icon-recent">
                                <i class="bi bi-clock-history text-recent"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('items.index') }}" class="small text-decoration-none text-recent">
                        View details <i class="bi bi-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4 glass-card" data-aos="fade-right" data-aos-delay="500">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-transparent border-bottom">
                    <h6 class="m-0 font-weight-bold">Items Overview</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical text-gray-400"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="#">This Week</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="itemsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4 glass-card" data-aos="fade-left" data-aos-delay="500">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-transparent border-bottom">
                    <h6 class="m-0 font-weight-bold">Items by Category</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="categoryChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="me-2">
                            <i class="bi bi-circle-fill text-brand"></i> Electronics
                        </span>
                        <span class="me-2">
                            <i class="bi bi-circle-fill text-category"></i> Clothing
                        </span>
                        <span class="me-2">
                            <i class="bi bi-circle-fill text-item"></i> Home & Kitchen
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Items -->
        <div class="col-12">
            <div class="card shadow mb-4 glass-card" data-aos="fade-up" data-aos-delay="600">
                <div class="card-header py-3 bg-transparent border-bottom">
                    <h6 class="m-0 font-weight-bold">Recent Items</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($recentItems as $item)
                        <div class="list-group-item recent-item d-flex justify-content-between align-items-center px-0 border-0">
                            <div>
                                <div class="fw-bold">{{ $item['name'] }}</div>
                                <div class="small text-secondary">{{ $item['category'] }} · {{ $item['brand'] }}</div>
                            </div>
                            <div class="text-end">
                                <div class="text-brand fw-bold">{{ $item['code'] }}</div>
                                <div class="small text-secondary">{{ $item['time'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('items.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Add New Item
                    </a>
                    <a href="{{ route('items.index') }}" class="btn btn-outline-secondary btn-sm ms-2">
                        View All Items
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Items Overview Chart
        const itemsCtx = document.getElementById('itemsChart').getContext('2d');
        const itemsChart = new Chart(itemsCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Items Added',
                    data: [18, 25, 22, 30, 27, 35, 42],
                    backgroundColor: 'rgba(124, 58, 237, 0.1)',
                    borderColor: 'rgba(124, 58, 237, 1)',
                    pointBackgroundColor: 'rgba(124, 58, 237, 1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(124, 58, 237, 1)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 10,
                            color: '#94a3b8'
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#94a3b8'
                        },
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeOutQuart'
                }
            }
        });

        // Category Distribution Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Electronics', 'Clothing', 'Home & Kitchen', 'Sports', 'Books'],
                datasets: [{
                    data: [35, 25, 20, 15, 5],
                    backgroundColor: [
                        'rgba(124, 58, 237, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(14, 165, 233, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(236, 72, 153, 0.8)'
                    ],
                    hoverBackgroundColor: [
                        'rgba(124, 58, 237, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(14, 165, 233, 1)',
                        'rgba(245, 158, 11, 1)',
                        'rgba(236, 72, 153, 1)'
                    ],
                    hoverBorderColor: 'rgba(234, 236, 244, 0.2)',
                    borderWidth: 0
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 2000,
                    easing: 'easeOutQuart'
                }
            }
        });
    });
</script>
@endsection
