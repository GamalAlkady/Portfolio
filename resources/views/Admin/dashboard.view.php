<?php setTitle('dashboard');?>
<div class="container mx-auto px-4">
    <div class="flex">
        <!-- Sidebar -->

        <!-- Main content -->
        <main class="flex-1  p-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-blue-600 rounded-lg shadow-lg p-6 text-white">
                    <h5 class="text-lg font-semibold">Total Projects</h5>
                    <h2 class="text-4xl font-bold mt-2"><?= /** @var TYPE_NAME $countProjects */
                        ($countProjects) ?></h2>
                </div>

                <div class="bg-green-600 rounded-lg shadow-lg p-6 text-white">
                    <h5 class="text-lg font-semibold">Total Orders</h5>
                    <h2 class="text-4xl font-bold mt-2"><?= /** @var TYPE_NAME $countOrders */
                        ($countOrders) ?></h2>
                </div>
            </div>

            <!-- Recent Orders Table -->
            <div class="mt-8">
                <h4 class="text-2xl font-semibold mb-4">Recent Orders</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg overflow-hidden">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($orders as $order){ 
                                $statusClass = '';
                                $statusText = $order['status'];
                                
                                switch(strtolower($order['status'])) {
                                    case 'pending':
                                        $statusClass = 'bg-yellow-100 text-yellow-800';
                                        break;
                                    case 'completed':
                                        $statusClass = 'bg-green-100 text-green-800';
                                        break;
                                    case 'cancelled':
                                        $statusClass = 'bg-red-100 text-red-800';
                                        break;
                                    default:
                                        $statusClass = 'bg-gray-100 text-gray-800';
                                }
                            ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $order['id'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?= $order['project_title'] ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClass ?>">
                                        <?= $statusText ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= date('Y-m-d', strtotime($order['created_at'])) ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

