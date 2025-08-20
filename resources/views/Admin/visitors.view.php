<?php setTitle(__("visitors_statistics") ?? "إحصائيات الزوار") ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-chart-bar mr-2"></i><?= __("visitors_statistics") ?? "إحصائيات الزوار" ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= route('dashboard') ?>"><?= __("dashboard") ?></a></li>
                        <li class="breadcrumb-item active"><?= __("visitors") ?? "الزوار" ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            
            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= $visitorsToday['total_visits'] ?? 0 ?></h3>
                            <p><?= __("visitors_today") ?? "زوار اليوم" ?></p>
                            <small><?= ($visitorsToday['unique_visitors'] ?? 0) . ' ' . (__("unique") ?? "فريد") ?></small>
                        </div>
                        <div class="icon">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $visitorsWeek['total_visits'] ?? 0 ?></h3>
                            <p><?= __("visitors_this_week") ?? "زوار هذا الأسبوع" ?></p>
                            <small><?= ($visitorsWeek['unique_visitors'] ?? 0) . ' ' . (__("unique") ?? "فريد") ?></small>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-week"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $visitorsMonth['total_visits'] ?? 0 ?></h3>
                            <p><?= __("visitors_this_month") ?? "زوار هذا الشهر" ?></p>
                            <small><?= ($visitorsMonth['unique_visitors'] ?? 0) . ' ' . (__("unique") ?? "فريد") ?></small>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3><?= $visitorsTotal['total_visits'] ?? 0 ?></h3>
                            <p><?= __("total_visitors") ?? "إجمالي الزوار" ?></p>
                            <small><?= ($visitorsTotal['unique_visitors'] ?? 0) . ' ' . (__("unique") ?? "فريد") ?></small>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Online Visitors -->
            <div class="row">
                <div class="col-md-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-wifi"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><?= __("online_visitors") ?? "الزوار المتصلون الآن" ?></span>
                            <span class="info-box-number"><?= $currentVisitors ?? 0 ?></span>
                            <span class="progress-description"><?= __("visitors_in_last_30_minutes") ?? "زوار في آخر 30 دقيقة" ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Daily Statistics Chart -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __("daily_visits_chart") ?? "رسم بياني للزيارات اليومية" ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="dailyChart" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Pages -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __("top_pages") ?? "أكثر الصفحات زيارة" ?></h3>
                        </div>
                        <div class="card-body p-0">
                            <ul class="products-list product-list-in-card pl-2 pr-2">
                                <?php if (!empty($topPages)): ?>
                                    <?php foreach ($topPages as $page): ?>
                                        <li class="item">
                                            <div class="product-info">
                                                <a href="<?= $page['page_url'] ?>" class="product-title">
                                                    <?= basename(parse_url($page['page_url'], PHP_URL_PATH)) ?: '/' ?>
                                                    <span class="badge badge-info float-right"><?= $page['visits'] ?></span>
                                                </a>
                                                <span class="product-description text-truncate" style="max-width: 200px;">
                                                    <?= $page['page_url'] ?>
                                                </span>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="item text-center py-3">
                                        <span class="text-muted"><?= __("no_data_available") ?? "لا توجد بيانات متاحة" ?></span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Country Statistics -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __("visitors_by_country") ?? "الزوار حسب الدولة" ?></h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th><?= __("country") ?? "الدولة" ?></th>
                                        <th><?= __("visits") ?? "الزيارات" ?></th>
                                        <th><?= __("unique") ?? "فريد" ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($countryStats)): ?>
                                        <?php foreach ($countryStats as $country): ?>
                                            <tr>
                                                <td><?= $country['country'] ?: (__("unknown") ?? "غير معروف") ?></td>
                                                <td><?= $country['visits'] ?></td>
                                                <td><?= $country['unique_visitors'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">
                                                <?= __("no_data_available") ?? "لا توجد بيانات متاحة" ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Top Referrers -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?= __("top_referrers") ?? "أهم مصادر الإحالة" ?></h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th><?= __("source") ?? "المصدر" ?></th>
                                        <th><?= __("visits") ?? "الزيارات" ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($topReferrers)): ?>
                                        <?php foreach ($topReferrers as $referrer): ?>
                                            <tr>
                                                <td>
                                                    <?php
                                                    $domain = parse_url($referrer['referer'], PHP_URL_HOST);
                                                    echo $domain ?: (__("direct") ?? "مباشر");
                                                    ?>
                                                </td>
                                                <td><?= $referrer['visits'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">
                                                <?= __("no_data_available") ?? "لا توجد بيانات متاحة" ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Daily visits chart
const ctx = document.getElementById('dailyChart').getContext('2d');
const dailyData = <?= json_encode($dailyStats ?? []) ?>;

// Prepare data for chart
const labels = [];
const visits = [];
const uniqueVisitors = [];

// Sort data by date and prepare for chart
dailyData.sort((a, b) => new Date(a.visit_date) - new Date(b.visit_date));

dailyData.forEach(item => {
    labels.push(new Date(item.visit_date).toLocaleDateString('<?= locale() ?>'));
    visits.push(parseInt(item.total_visits));
    uniqueVisitors.push(parseInt(item.unique_visitors));
});

const chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: '<?= __("total_visits") ?? "إجمالي الزيارات" ?>',
            data: visits,
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.1
        }, {
            label: '<?= __("unique_visitors") ?? "زوار فريدون" ?>',
            data: uniqueVisitors,
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        },
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: true,
                text: '<?= __("daily_visits_trend") ?? "اتجاه الزيارات اليومية" ?>'
            }
        }
    }
});

// Auto refresh every 5 minutes
setInterval(function() {
    location.reload();
}, 300000);
</script>