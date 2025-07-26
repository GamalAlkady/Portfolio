<?php
if (!function_exists('viewAdmin')) {
    function viewAdmin($view,?array $params = null): string
    {
        return layout('admin/app')->view("/admin/$view", $params);
    }
}