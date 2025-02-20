<?php namespace App\Models;

use CodeIgniter\Model;

class UpdateStatusModel extends Model
{
    protected $table = 'forms'; // 資料表名稱
    protected $primaryKey = 'id'; // 主鍵

    protected $allowedFields = ['status']; // 允許更新的欄位
}
