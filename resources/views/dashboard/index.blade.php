@extends('layouts.app')

@section('title', 'Dashboard.index')

@section('content')
@php
function trendClass($value) {
    return $value >= 0 ? 'text-success' : 'text-danger';
}
function trendIcon($value) {
    return $value >= 0 ? 'bx-trending-up' : 'bx-trending-down';
}
@endphp
  <div class="row">
      <div class="col-lg-3 col-sm-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div class="card-info">
                <p class="text-heading mb-1">Jumlah Order</p>
                <div class="d-flex align-items-center mb-1">
                  <h4 class="card-title mb-0 me-2">{{ number_format($jumlahOrder) }}</h4>
                  <span class="{{ trendClass($persenOrder) }}">({{ $persenOrder }}%)</span>
                </div>
                <span>Periode saat ini</span>
              </div>
              <div class="card-icon">
                <span class="badge bg-label-primary rounded p-2">
                  <i class="icon-base bx {{ trendIcon($persenOrder) }} icon-lg"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Penjualan Kotor --}}
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div class="card-info">
                <p class="text-heading mb-1">Penjualan Kotor</p>
                <div class="d-flex align-items-center mb-1">
                  <h4 class="card-title mb-0 me-2">{{ number_format($penjualanKotor, 0, ',', '.') }}</h4>
                  <span class="{{ trendClass($persenKotor) }}">({{ $persenKotor }}%)</span>
                </div>
                <span>Periode saat ini</span>
              </div>
              <div class="card-icon">
                <span class="badge bg-label-info rounded p-2">
                  <i class="icon-base bx {{ trendIcon($persenKotor) }} icon-lg"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Penjualan Bersih --}}
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div class="card-info">
                <p class="text-heading mb-1">Penjualan Bersih</p>
                <div class="d-flex align-items-center mb-1">
                  <h4 class="card-title mb-0 me-2">{{ number_format($penjualanBersih, 0, ',', '.') }}</h4>
                  <span class="{{ trendClass($persenBersih) }}">({{ $persenBersih }}%)</span>
                </div>
                <span>Periode saat ini</span>
              </div>
              <div class="card-icon">
                <span class="badge bg-label-success rounded p-2">
                  <i class="icon-base bx {{ trendIcon($persenBersih) }} icon-lg"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Order Retur --}}
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div class="card-info">
                <p class="text-heading mb-1">Order Retur</p>
                <div class="d-flex align-items-center mb-1">
                  <h4 class="card-title mb-0 me-2">{{ number_format($orderRetur) }}</h4>
                  <span class="{{ trendClass($persenRetur) }}">({{ $persenRetur }}%)</span>
                </div>
                <span>Periode saat ini</span>
              </div>
              <div class="card-icon">
                <span class="badge bg-label-danger rounded p-2">
                  <i class="icon-base bx {{ trendIcon($persenRetur) }} icon-lg"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  <div class="row mt-4">
    {{-- Order Belum Lunas --}}
    <div class="col-lg-3 col-sm-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="card-info">
              <p class="text-heading mb-1">Order Belum Lunas</p>
              <div class="d-flex align-items-center mb-1">
                <h4 class="card-title mb-0 me-2">{{ number_format($orderBelumLunas) }}</h4>
                <span class="{{ trendClass($persenBelumLunas) }}">({{ $persenBelumLunas }}%)</span>
              </div>
              <span>Periode saat ini</span>
            </div>
            <div class="card-icon">
              <span class="badge bg-label-warning rounded p-2">
                <i class="icon-base bx {{ trendIcon($persenBelumLunas) }} icon-lg"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Order Lunas --}}
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="card-info">
              <p class="text-heading mb-1">Order Lunas</p>
              <div class="d-flex align-items-center mb-1">
                <h4 class="card-title mb-0 me-2">{{ number_format($orderLunas) }}</h4>
                <span class="{{ trendClass($persenLunas) }}">({{ $persenLunas }}%)</span>
              </div>
              <span>Periode saat ini</span>
            </div>
            <div class="card-icon">
              <span class="badge bg-label-success rounded p-2">
                <i class="icon-base bx {{ trendIcon($persenLunas) }} icon-lg"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- HPP (Harga Pokok Penjualan) --}}
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="card-info">
              <p class="text-heading mb-1">HPP</p>
              <div class="d-flex align-items-center mb-1">
                <h4 class="card-title mb-0 me-2">{{ number_format($hpp, 0, ',', '.') }}</h4>
                <span class="{{ trendClass($persenHpp) }}">({{ $persenHpp }}%)</span>
              </div>
              <span>Periode saat ini</span>
            </div>
            <div class="card-icon">
              <span class="badge bg-label-secondary rounded p-2">
                <i class="icon-base bx {{ trendIcon($persenHpp) }} icon-lg"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Rugi --}}
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="card-info">
              <p class="text-heading mb-1">Rugi</p>
              <div class="d-flex align-items-center mb-1">
                <h4 class="card-title mb-0 me-2">{{ number_format($rugi, 0, ',', '.') }}</h4>
                <span class="{{ trendClass($persenRugi) }}">({{ $persenRugi }}%)</span>
              </div>
              <span>Periode saat ini</span>
            </div>
            <div class="card-icon">
              <span class="badge bg-label-danger rounded p-2">
                <i class="icon-base bx {{ trendIcon($persenRugi) }} icon-lg"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

  <div class="row mt-4">
    <!-- Line Charts -->
  <div class="col-12 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex justify-content-between align-items-center">
            <div>
              <h5 class="card-title mb-0">Statistik</h5>
              <small class="text-muted">Jumlah Order, Penjualan Kotor & Bersih (per hari)</small>
            </div>
          </div>
          <div class="card-body pt-2">
            <canvas id="lineChart" height="100"></canvas>
          </div>
        </div>
      </div>   
     <!-- /Line Charts -->
  </div>
    {{-- <div class="row g-6">
      <!-- Employee List -->
      <div class="col-md-6 col-xxl-5">
        <div class="card">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2">Employee List</h5>
            <div class="dropdown">
              <button class="btn text-body-secondary p-0" type="button" id="employeeList" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-base bx bx-dots-vertical-rounded icon-lg"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="employeeList">
                <a class="dropdown-item" href="javascript:void(0);">Featured Employees</a>
                <a class="dropdown-item" href="javascript:void(0);">Based on Task</a>
                <a class="dropdown-item" href="javascript:void(0);">See All</a>
              </div>
            </div>
          </div>
          <div class="card-body pt-4">
            <ul class="p-0 m-0">
              <li class="d-flex align-items-center mb-6">
                <div class="avatar flex-shrink-0 me-3">
                  <img src="../../assets/img/avatars/20.png" alt="User" class="rounded" />
                </div>
                <div class="d-flex w-100 align-items-center gap-2">
                  <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                    <div>
                      <h6 class="mb-0 fw-normal">Alberta</h6>
                      <small>UI Designer</small>
                    </div>

                    <div class="user-progress d-flex align-items-center gap-1">
                      <h6 class="mb-0 fw-normal">100h:</h6>
                      <span class="text-body-secondary">138h</span>
                    </div>
                  </div>

                  <div class="chart-progress" data-color="secondary" data-series="85"></div>
                </div>
              </li>
              <li class="d-flex align-items-center mb-6">
                <div class="avatar flex-shrink-0 me-3">
                  <img src="../../assets/img/avatars/3.png" alt="User" class="rounded" />
                </div>
                <div class="d-flex w-100 align-items-center gap-2">
                  <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                    <div>
                      <h6 class="mb-0 fw-normal">Paul</h6>
                      <small>Branding</small>
                    </div>

                    <div class="user-progress d-flex align-items-center gap-1">
                      <h6 class="mb-0 fw-normal">121h:</h6>
                      <span class="text-body-secondary">109h</span>
                    </div>
                  </div>

                  <div class="chart-progress" data-color="warning" data-series="70"></div>
                </div>
              </li>
              <li class="d-flex align-items-center mb-6">
                <div class="avatar flex-shrink-0 me-3">
                  <img src="../../assets/img/avatars/15.png" alt="User" class="rounded" />
                </div>
                <div class="d-flex w-100 align-items-center gap-2">
                  <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                    <div>
                      <h6 class="mb-0 fw-normal">Nannie</h6>
                      <small>iOS Developer</small>
                    </div>

                    <div class="user-progress d-flex align-items-center gap-1">
                      <h6 class="mb-0 fw-normal">112h:</h6>
                      <span class="text-body-secondary">160h</span>
                    </div>
                  </div>

                  <div class="chart-progress" data-color="primary" data-series="25"></div>
                </div>
              </li>
              <li class="d-flex align-items-center mb-6">
                <div class="avatar flex-shrink-0 me-3">
                  <img src="../../assets/img/avatars/14.png" alt="User" class="rounded" />
                </div>
                <div class="d-flex w-100 align-items-center gap-2">
                  <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                    <div>
                      <h6 class="mb-0 fw-normal">Rodney</h6>
                      <small>iOS Developer</small>
                    </div>

                    <div class="user-progress d-flex align-items-center gap-1">
                      <h6 class="mb-0 fw-normal">125h:</h6>
                      <span class="text-body-secondary">166h</span>
                    </div>
                  </div>

                  <div class="chart-progress" data-color="danger" data-series="75"></div>
                </div>
              </li>
              <li class="d-flex align-items-center mb-6">
                <div class="avatar flex-shrink-0 me-3">
                  <img src="../../assets/img/avatars/7.png" alt="User" class="rounded" />
                </div>
                <div class="d-flex w-100 align-items-center gap-2">
                  <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                    <div>
                      <h6 class="mb-0 fw-normal">Martin</h6>
                      <small>Product Designer</small>
                    </div>

                    <div class="user-progress d-flex align-items-center gap-1">
                      <h6 class="mb-0 fw-normal">76h:</h6>
                      <span class="text-body-secondary">89h</span>
                    </div>
                  </div>

                  <div class="chart-progress" data-color="info" data-series="60"></div>
                </div>
              </li>
              <li class="d-flex">
                <div class="avatar flex-shrink-0 me-3">
                  <img src="../../assets/img/avatars/18.png" alt="User" class="rounded" />
                </div>
                <div class="d-flex w-100 align-items-center gap-2">
                  <div class="d-flex justify-content-between flex-grow-1 flex-wrap">
                    <div>
                      <h6 class="mb-0 fw-normal">Nancy</h6>
                      <small>PHP Developer</small>
                    </div>

                    <div class="user-progress d-flex align-items-center gap-1">
                      <h6 class="mb-0 fw-normal">22h:</h6>
                      <span class="text-body-secondary">45h</span>
                    </div>
                  </div>

                  <div class="chart-progress" data-color="warning" data-series="45"></div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!--/ Employee List -->
      <!-- Team Members -->
      <div class="col-lg-12 col-xxl-7">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title m-0 me-2">Team Members</h5>
            <div class="dropdown">
              <button class="btn text-body-secondary p-0" type="button" id="teamMemberList" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-base bx bx-dots-vertical-rounded icon-lg"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="teamMemberList">
                <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                <a class="dropdown-item" href="javascript:void(0);">Share</a>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-borderless table-sm">
              <thead>
                <tr>
                  <th class="ps-6">Name</th>
                  <th>Project</th>
                  <th>Task</th>
                  <th class="pe-6">Progress</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <div class="d-flex justify-content-start align-items-center">
                      <div class="avatar me-3">
                        <img src="../../assets/img/avatars/17.png" alt="Avatar" class="rounded-circle" />
                      </div>
                      <div class="d-flex flex-column">
                        <h6 class="mb-0 text-truncate">Nathan Wagner</h6>
                        <small class="text-truncate text-body">iOS Developer</small>
                      </div>
                    </div>
                  </td>
                  <td><span class="badge bg-label-primary text-uppercase">Zipcar</span></td>
                  <td><span class="fw-medium">87/135</span></td>
                  <td>
                    <div class="chart-progress" data-color="primary" data-series="65"></div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="d-flex justify-content-start align-items-center">
                      <div class="avatar me-3">
                        <img src="../../assets/img/avatars/8.png" alt="Avatar" class="rounded-circle" />
                      </div>
                      <div class="d-flex flex-column">
                        <h6 class="mb-0 text-truncate">Emma Bowen</h6>
                        <small class="text-truncate text-body">UI/UX Designer</small>
                      </div>
                    </div>
                  </td>
                  <td><span class="badge bg-label-danger text-uppercase">Bitbank</span></td>
                  <td><span class="fw-medium">320/440</span></td>
                  <td>
                    <div class="chart-progress" data-color="danger" data-series="85"></div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="d-flex justify-content-start align-items-center">
                      <div class="avatar me-3">
                        <span class="avatar-initial rounded-circle bg-label-warning">AM</span>
                      </div>
                      <div class="d-flex flex-column">
                        <h6 class="mb-0 text-truncate">Adrian McGuire</h6>
                        <small class="text-truncate text-body">PHP Developer</small>
                      </div>
                    </div>
                  </td>
                  <td><span class="badge bg-label-warning text-uppercase">Payers</span></td>
                  <td><span class="fw-medium">50/82</span></td>
                  <td>
                    <div class="chart-progress" data-color="warning" data-series="73"></div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div class="d-flex justify-content-start align-items-center">
                      <div class="avatar me-3">
                        <img src="../../assets/img/avatars/2.png" alt="Avatar" class="rounded-circle" />
                      </div>
                      <div class="d-flex flex-column">
                        <h6 class="mb-0 text-truncate">Alma Gonzalez</h6>
                        <small class="text-truncate text-body">Product Manager</small>
                      </div>
                    </div>
                  </td>
                  <td><span class="badge bg-label-info text-uppercase">Brandi</span></td>
                  <td><span class="fw-medium">98/260</span></td>
                  <td>
                    <div class="chart-progress" data-color="info" data-series="61"></div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!--/ Team Members --> --}}
  </div>
@endsection

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const DATA_COUNT = 7;
    const NUMBER_CFG = {count: DATA_COUNT, min: -100, max: 100, decimals: 0};

    // Utils object can be adjusted as needed
    const Utils = {
      months: function({ count }) {
        const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        return months.slice(0, count);
      },
      numbers: function(cfg) {
        const numbers = [];
        for (let i = 0; i < cfg.count; i++) {
          numbers.push(Math.floor(Math.random() * (cfg.max - cfg.min + 1)) + cfg.min);
        }
        return numbers;
      },
      CHART_COLORS: {
        red: '#FF5733',
        blue: '#33C1FF',
      },
      transparentize: function(color, opacity) {
        const rgba = this.hexToRgb(color);
        return `rgba(${rgba.r}, ${rgba.g}, ${rgba.b}, ${opacity})`;
      },
      hexToRgb: function(hex) {
        let r = 0, g = 0, b = 0;
        if (hex.length === 4) {
          r = "0x" + hex[1] + hex[1];
          g = "0x" + hex[2] + hex[2];
          b = "0x" + hex[3] + hex[3];
        } else if (hex.length === 7) {
          r = "0x" + hex[1] + hex[2];
          g = "0x" + hex[3] + hex[4];
          b = "0x" + hex[5] + hex[6];
        }
        return { r: +r, g: +g, b: +b };
      }
    };

    const data = {
      labels: Utils.months({count: DATA_COUNT}),
      datasets: [
        {
          label: 'Dataset 1',
          data: Utils.numbers(NUMBER_CFG),
          fill: false,
          borderColor: Utils.CHART_COLORS.red,
          backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
        },
        {
          label: 'Dataset 2',
          data: Utils.numbers(NUMBER_CFG),
          fill: false,
          borderColor: Utils.CHART_COLORS.blue,
          backgroundColor: Utils.transparentize(Utils.CHART_COLORS.blue, 0.5),
        },
      ]
    };

    const footer = (tooltipItems) => {
      let sum = 0;

      tooltipItems.forEach(function(tooltipItem) {
        sum += tooltipItem.parsed.y;
      });
      return 'Sum: ' + sum;
    };

    const config = {
      type: 'line',
      data: data,
      options: {
        interaction: {
          intersect: false,
          mode: 'index',
        },
        plugins: {
          tooltip: {
            callbacks: {
              footer: footer,
            }
          }
        }
      }
    };

    // Initialize the chart

document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('lineChart').getContext('2d');

    const lineChart = new Chart(ctx, {
        type: 'line',
        data: {
        labels: @json($labels).map(date => {
                const d = new Date(date);
                return d.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
            }),            
            datasets: [
                {
                    label: 'Jumlah Order',
                    data: @json($jumlahOrderPerHari),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Penjualan Kotor',
                    data: @json($penjualanKotorPerHari),
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Penjualan Bersih',
                    data: @json($penjualanBersihPerHari),
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                x: {
                    ticks: {
                        maxRotation: 90,
                        minRotation: 45,
                        autoSkip: true,
                        maxTicksLimit: 15
                    }
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});  
</script>
@endpush