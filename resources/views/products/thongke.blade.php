@extends('layouts.app') 

@section('content')
<div class="container-fluid">
    <h3 class="fw-bold mb-4"><i class="fas fa-chart-line me-2"></i>Báo Cáo Doanh Thu & Kho Hàng</h3>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow border-0" style="background: linear-gradient(45deg, #1cc88a, #2af598); color: white; border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase fw-bold mb-1" style="opacity: 0.9;">Tổng giá trị toàn bộ kho hàng (Dự kiến thu hồi)</h6>
                            <h2 class="display-5 fw-bold mb-0">{{ number_format($totalAllRevenue, 0, ',', '.') }} VNĐ</h2>
                        </div>
                        <div class="col-auto"><i class="fas fa-money-bill-alt fa-4x" style="opacity: 0.3;"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row d-flex align-items-stretch"> <div class="col-lg-8 mb-4">
            <div class="card shadow border-0 h-100"> <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-success">Tổng giá trị doanh thu hàng hóa theo hãng (VNĐ)</h6>
                </div>
                <div class="card-body d-flex align-items-center"> <canvas id="chartRevenue"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow border-0 h-100"> <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tỷ trọng số lượng máy (%)</h6>
                </div>
                <div class="card-body d-flex flex-column justify-content-center"> <div style="position: relative; height: 100%; width: 100%;">
                        <canvas id="chartQuantity"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>

<script>
    Chart.register(ChartDataLabels);

    const formatVND = (value) => new Intl.NumberFormat('vi-VN').format(value) + ' đ';
    const colors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'];

    // --- BIỂU ĐỒ DOANH THU (CỘT) ---
    new Chart(document.getElementById('chartRevenue'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($revLabels) !!},
            datasets: [{
                label: 'Doanh thu dự kiến',
                data: {!! json_encode($revValues) !!},
                backgroundColor: '#1cc88a',
                borderRadius: 5
            }]
        },
        options: {
            maintainAspectRatio: false, // Cho phép tùy chỉnh chiều cao theo Card
            plugins: {
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    formatter: (value) => formatVND(value),
                    font: { weight: 'bold', size: 10 },
                    color: '#2e59d9'
                },
                legend: { display: false }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    ticks: { callback: (value) => formatVND(value) } 
                }
            }
        }
    });

    // --- BIỂU ĐỒ SỐ LƯỢNG (TRÒN) ---
    new Chart(document.getElementById('chartQuantity'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                data: {!! json_encode($values) !!},
                backgroundColor: colors
            }]
        },
        options: {
            maintainAspectRatio: true, // Giữ tỉ lệ hình tròn
            aspectRatio: 1, // Tỉ lệ 1:1 để nó không bị dẹt và lấp đầy khoảng trống
            plugins: {
                datalabels: { display: false },
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endsection