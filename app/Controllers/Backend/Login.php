<?php namespace App\Controllers\Backend;

use App\Controllers\BackendController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RequestInterface;

class Login extends BackendController
{
    use ResponseTrait;

    public function index()
    {
        

        // 檢查 session 以判斷使用者是否已登入
        $session = session();
        if ($session->has('isLoggedIn')) {
            // 使用者已登入，重定向到首頁
            return redirect()->to('/demoadmin/form-datatable/home-appliances');
        }

        // 顯示登入表單
        // return view('login');
        return $this->renderView('backend/login', '登入');
    }

    public function getLogin()
    {
        $json = $this->request->getJSON();
        $username = $json->user_id ?? '';
        $password = $json->user_pw ?? '';

        
        // 這裡應該包含從資料庫獲取用戶信息和驗證密碼的邏輯
        // 假設我們從資料庫中查找用戶信息
        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('username', $username)->first();

        // 驗證密碼
        if ($user && password_verify($password, $user['password'])) {
            // 登入成功，設置用戶會話或返回成功響應
            session()->set([
                'username'		=> $user['username'],
                'isLoggedIn' 	=> TRUE
            ]);
            return $this->respond(['message' => 'Login successful', 'user' => $user], 200);
        } else {
            // 登入失敗，返回錯誤信息
            return $this->fail('Invalid username or password', 401);
        }
    }

    public function logout()
    {
        $session = session();

        // 移除所有 session 數據，或者也可以只移除登入相關的數據
        $session->remove('isLoggedIn');
        $session->remove('username');

        return redirect()->to('/demoadmin');
    }
}
