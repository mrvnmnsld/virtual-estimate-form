<?php
/**
 * Test Routes File
 * This file helps debug routing issues on Hostinger
 * Access it at: https://lime-snake-252779.hostingersite.com/test_routes.php
 */

echo "<h1>CodeIgniter Routes Test</h1>";
echo "<h2>Server Information</h2>";
echo "<pre>";
echo "PHP Version: " . phpversion() . "\n";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "\n";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "Script Name: " . $_SERVER['SCRIPT_NAME'] . "\n";
echo "Base URL: " . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
echo "</pre>";

echo "<h2>File Check</h2>";
echo "<pre>";
echo "index.php exists: " . (file_exists('index.php') ? 'YES' : 'NO') . "\n";
echo ".htaccess exists: " . (file_exists('.htaccess') ? 'YES' : 'NO') . "\n";
echo "application folder exists: " . (is_dir('application') ? 'YES' : 'NO') . "\n";
echo "system folder exists: " . (is_dir('system') ? 'YES' : 'NO') . "\n";
echo "</pre>";

echo "<h2>mod_rewrite Test</h2>";
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    echo "mod_rewrite enabled: " . (in_array('mod_rewrite', $modules) ? 'YES' : 'NO') . "\n";
} else {
    echo "Cannot check Apache modules (function not available)\n";
}

echo "<h2>Test Links</h2>";
$base = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
echo "<ul>";
echo "<li><a href='" . $base . "'>Home (/)</a></li>";
echo "<li><a href='" . $base . "forms'>Forms (/forms)</a></li>";
echo "<li><a href='" . $base . "admin">Admin (/admin)</a></li>";
echo "<li><a href='" . $base . "index.php/forms'>Forms (with index.php)</a></li>";
echo "<li><a href='" . $base . "index.php/main/forms'>Forms (full path)</a></li>";
echo "</ul>";

