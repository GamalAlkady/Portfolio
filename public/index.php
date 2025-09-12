<?php

/**
 * @author Amirul islam <inbox.amirul@gmail.com>
 * @copyright 2023 Amirul Islam
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Define root directory.
 */
define('APP_ROOT', dirname(__DIR__));


/**
 * Register The Auto Loader.
 */
require_once APP_ROOT . '/vendor/autoload.php';
require_once APP_ROOT . '/app/Helpers/General.php';
require_once APP_ROOT . '/app/Helpers/FormHelper.php';
require_once APP_ROOT . '/app/Helpers/SettingsHelper.php';
require_once APP_ROOT . '/app/Helpers/EnvHelper.php';
require_once APP_ROOT . '/app/Templates/EmailTemplates.php';

// require_once dirname(__DIR__, 5) . '/vendor/autoload.php';
use Devamirul\PhpMicro\core\Foundation\Application\Application;

/**
 * Create Application object instance.
 */
$app = Application::singleton();

/**
 * Require registered Route.
 */
require_once APP_ROOT . '/routes/web.php';

/**
 * Run The Application.
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$app->run();

//die();