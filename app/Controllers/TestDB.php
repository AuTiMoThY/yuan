<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Database\Config;

class TestDB extends Controller
{
    public function index()
    {
        $db = Config::connect();
        try {
            $db->query("SELECT 1");
            echo "資料庫連接成功";
        } catch (\Throwable $th) {
            echo "資料庫連接失敗: " . $th->getMessage();
        }
    }
}
