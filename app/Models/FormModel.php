<?php
namespace App\Models;

use CodeIgniter\Model;

class FormModel extends Model
{
    protected $table      = 'forms';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = ['form_type', 'u_name', 'u_phone', 'u_budget', 'u_location', 'user_data', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // 其他需要的方法或邏輯...
}
