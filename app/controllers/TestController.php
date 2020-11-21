<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Router;
use app\lib\Auth;
use app\lib\Flash;
use app\lib\Paginator;
use app\models\Test;

class TestController extends Controller
{
    public function index(int $page = 1) {
        $this->view->render('Test');
    }

    public function create() {

    }

    public function store() {

    }

    public function show(int $id) {

    }

    public function edit(int $id) {

    }

    public function update(int $id) {

    }

    public function delete(int $id) {

    }
}