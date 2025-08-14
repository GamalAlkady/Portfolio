<?php setTitle(__("dashboard")) ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= __("dashboard") ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row justify-content-around">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-diagram-project"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><?= __("projects") ?></span>
                            <span class="info-box-number"><?=
                                                            /** @var numeric $countProjects */
                                                            $countProjects ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-code-compare"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><?= __("skills") ?></span>
                            <span class="info-box-number"><?=
                                                            /** @var numeric $countSkills */
                                                            $countSkills ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <!--                <div class="clearfix hidden-md-up"></div>-->

                <div class="col-12 col-sm-6 col-md-4 d-none">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-tasks"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><?= __("orders") ?></span>
                            <span class="info-box-number"><?=
                                                            /** @var numeric $countOrders */
                                                            $countOrders ?></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3 d-none">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text"><?= __("users") ?></span>
                            <span class="info-box-number">1</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-md-12">
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title"><?= __("latest_projects") ?></h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th><?= __("title") ?></th>
                                            <th><?= __("description") ?></th>
                                            <th><?= __("technologies_used") ?></th>
                                            <th><?= __("category") ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        /** @var array $projects */
                                        foreach ($projects as $project) { ?>
                                            <tr>
                                                <td><?= $project['title'] ?></td>
                                                <td><?= $project['description'] ?></td>
                                                <td><?= $project['technologies'] ?></td>
                                                <td><?= $project['category'] ?></td>
                                            </tr>
                                        <?php } ?>


                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                        </div>
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>


            <!-- Main row -->
            <div class="row d-none">
                <!-- Left col -->
                <div class="col-md-10">

                    <div class="row">


                        <div class="col-md-6">
                            <!-- PRODUCT LIST -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><?= __("latest_skills") ?></h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <ul class="products-list product-list-in-card pl-2 pr-2">
                                        <?php foreach ($skills as $skill): ?>
                                            <li class="item">
                                                <div class="product-img">
                                                    <!--                                                <img src="dist/img/default-150x150.png" alt="Product Image" class="img-size-50">-->
                                                </div>
                                                <div class="product-info">
                                                    <a href="javascript:void(0)" class="product-title"><?= $skill['name'] ?>
                                                        <!--                                                    <span class="badge badge-warning float-right">$1800</span></a>-->
                                                        <span class="product-description"><?= $skill['description'] ?></span>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>
                                        <!-- /.item -->
                                    </ul>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer text-center">
                                    <a href="<?= route('projects') ?>" class="uppercase"><?= __("view_all_products") ?></a>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                        </div>


                        <div class="col-md-6">
                            <!-- Info Boxes Style 2 -->


                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><?= __("browser_usage") ?></h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="chart-responsive">
                                                <canvas id="pieChart" height="150"></canvas>
                                            </div>
                                            <!-- ./chart-responsive -->
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-md-4">
                                            <ul class="chart-legend clearfix">
                                                <li><i class="far fa-circle text-danger"></i> <?= __("chrome") ?></li>
                                                <li><i class="far fa-circle text-success"></i> <?= __("ie") ?></li>
                                                <li><i class="far fa-circle text-warning"></i> <?= __("firefox") ?></li>
                                                <li><i class="far fa-circle text-info"></i> <?= __("safari") ?></li>
                                                <li><i class="far fa-circle text-primary"></i> <?= __("edge") ?></li>
                                            </ul>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer bg-light p-0">
                                    <ul class="nav nav-pills flex-column">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                <?= __("united_states_of_america") ?>
                                                <span class="float-right text-danger">
                                                    <i class="fas fa-arrow-down text-sm"></i>
                                                    12%</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                <?= __("india") ?>
                                                <span class="float-right text-success">
                                                    <i class="fas fa-arrow-up text-sm"></i> 4%
                                                </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                <?= __("china") ?>
                                                <span class="float-right text-warning">
                                                    <i class="fas fa-arrow-left text-sm"></i> 0%
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.footer -->
                            </div>
                            <!-- /.card -->


                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->


                </div>
                <!-- /.col -->

            </div>
            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script src="<?= assets('js/pages/dashboard2.js') ?>"></script>