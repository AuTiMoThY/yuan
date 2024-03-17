<?php namespace App\Models;

use CodeIgniter\Model;

class FormDatatableModel extends Model
{
    protected $table = 'forms'; // 資料表名稱
    protected $allowedFields = ['form_type', 'u_name', 'u_phone', 'u_budget', 'u_location', 'user_data', 'status', 'created_at', 'updated_at']; // 可被批量賦值的欄位

    // 如果您有使用時間戳，可啟用以下屬性
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
