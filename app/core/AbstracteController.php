<?php

namespace App\Core;

abstract class AbstracteController
{
    use Singleton;
    abstract public function index();
    abstract public function create();
    abstract public function edit();
    abstract public function destroy();
    abstract public function show();
    abstract public function store();
    abstract public function update();
    protected $layout = 'base';

    protected Session $session;

    public function __construct()
    {
    }

    public function render($data = [], int $httpCode = 200)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Content-Type: application/json');
        http_response_code($httpCode);
        echo json_encode($data);
        exit;
    }
}
