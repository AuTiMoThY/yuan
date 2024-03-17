<?php

namespace App\Controllers;

// 引入 BaseController
use App\Controllers\BaseController;
use App\Models\FormModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class BackendController extends BaseController
{

    protected $formModel;
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // 調用父類構造函數
        parent::initController($request, $response, $logger);

        // 初始化 FormModel
        $this->formModel = new FormModel();

        // 可以在這裡加入後台管理介面專用的初始化代碼
        // 例如：檢查用戶是否已登入，若未登入則重定向到登入頁面
        $session = session();
        if (!$session->has('isLoggedIn')) {
            // 使用者未登入，重定向到登入頁面
            return redirect()->to('/yuanadmin/login');
        } else {
            return redirect()->to('/yuanadmin/dashboard');
        }
    }

    protected function getStatusText($status)
    {
        switch ($status) {
            case '0':
                return '未聯繫';
            case '1':
                return '已聯繫';
            case '2':
                return '無效作廢';
            default:
                return '未知'; // 預設值
        }
    }


    protected function getQuestionValue($questionsArr, $key)
    {
        // 初始化一個變數來保存「回答」的值
        $valueTxt = '';
        // 取出回答
        if (isset($questionsArr[$key])) {
            $valueStr = $questionsArr[$key]['value'];

            if ($key == 'q10') {
                // 用逗號分割字符串
                $q10ValueParts = explode(',', $valueStr);
                foreach ($q10ValueParts as $part) {
                    // 移除字符串前後的空白
                    $trimmedPart = trim($part);

                    // 檢查這部分是否以「不方便聯繫的時間:」開頭
                    if (strpos($trimmedPart, '不方便聯繫的時間:') === 0) {
                        // 使用 explode() 再次分割，然後取得「不方便聯繫的時間:」後面的值
                        $timeParts = explode(':', $trimmedPart);
                        if (isset($timeParts[1])) {
                            $valueTxt = trim($timeParts[1]); // 移除前後空白
                            break; // 找到後跳出循環
                        }
                    }
                }
            }
            else {   
                $valueTxt = $valueStr;
            }
        }

        return $valueTxt;
    }
}
