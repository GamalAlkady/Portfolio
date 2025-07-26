<?php setTitle('dashboard');?>
<div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->



            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">


                <!-- Stats Cards -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <h5 class="card-title">Total Works</h5>
                                <h2 class="card-text"><?= /** @var TYPE_NAME $countProjects */
                                    ($countProjects) ?></h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <h5 class="card-title">Total Orders</h5>
                                <h2 class="card-text"><?= /** @var TYPE_NAME $countOrders */
                                    ($countOrders) ?></h2>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-md-4 mb-4">
                        <div class="card text-white bg-info">
                            <div class="card-body">
                                <h5 class="card-title">Comments</h5>
                                <h2 class="card-text">294</h2>
                            </div>
                        </div>
                    </div> -->
                </div>

                <!-- Recent Orders Table -->

                <div class="row">
                    <div class="col">
                        <h4>Recent Orders</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Project</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($orders as $order){ ?>

                                        <tr>
                                            <td><?= $order['id'] ?></td>
                                            <td><?= $order['project_title'] ?></td>
                                            <td>
                                                <?php
                                                $statusClass = '';
                                                $statusText = $order['status'];

                                                switch(strtolower($order['status'])) {
                                                    case 'pending':
                                                        $statusClass = 'bg-warning text-dark';
                                                        break;
                                                    case 'completed':
                                                        $statusClass = 'bg-success text-white';
                                                        break;
                                                    case 'cancelled':
                                                        $statusClass = 'bg-danger text-white';
                                                        break;
                                                    default:
                                                        $statusClass = 'bg-secondary text-white';
                                                }
                                                ?>
                                                <span class="badge <?= $statusClass ?> rounded-pill"><?= $statusText ?></span>
                                            </td>
                                            <td><?= date('Y-m-d', strtotime($order['created_at'])) ?></td>
                                        </tr>
                                    <?php } ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
</div>

