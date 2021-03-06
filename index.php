<?php 
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app = new Slim();

$app->config('debug', true);

// pagina principal
$app->get('/', function() {
    
	$page = new Page();

	$page -> setTpl("index");

});

// pagina de administraçao
$app->get('/admin', function() {
	
	User::verifyLogin();
	
	$page = new PageAdmin();

	$page -> setTpl("index");

});


// pagina de login, com o formulario e tal
$app->get('/admin/login', function() {
    
	$page = new PageAdmin([
		"header" => false,
		"footer" => false
	]);

	$page -> setTpl("login");

});

$app->get('/admin/logout', function() {
	User::logout();
	header("Location: /admin/login");

	exit;
});

// recebe dados da pagina de login
$app -> post('/admin/login', function(){
	User:: login($_POST["login"], $_POST["password"]);

	header("Location: /admin");

	exit;
});

$app->run();

 ?>