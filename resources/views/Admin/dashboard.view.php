<?php setTitle("Dashboard")?>

<div class="container-fluid mt-4">
    <div class="row mt-4">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Projects</h5>
                    <p class="card-text display-4"><?= /** @var numeric $countProjects */
                        ($countProjects) ?></p>
                    <p class="text-success"><i class="fas fa-arrow-up"></i> 12% increase</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Revenue</h5>
                    <p class="card-text display-4">$24,560</p>
                    <p class="text-success"><i class="fas fa-arrow-up"></i> 8% increase</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Orders</h5>
                    <p class="card-text display-4"><?= /** @var numeric $countOrders */
                        ($countOrders) ?></p>
                    <p class="text-danger"><i class="fas fa-arrow-down"></i> 3% decrease</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Orders</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Project</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php

                            /** @var array $orders */
                            foreach ($orders as $order){ ?>

                                <tr>
                                    <td><?= $order['id'] ?></td>
                                    <td><?= $order['project_title'] ?></td>
                                    <td>
                                        <?php
                                        $statusText = $order['status'];

                                        $statusClass = match (strtolower($order['status'])) {
                                            'pending' => 'bg-warning text-dark',
                                            'completed' => 'bg-success text-white',
                                            'cancelled' => 'bg-danger text-white',
                                            default => 'bg-secondary text-white',
                                        };
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
        </div>
    </div>
</div>