<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\FormModel;

class Form extends BaseController
{

    use ResponseTrait;
    public $forms = [
        'homeAppliances' => [
            'title' => '精品家電顧問服務',
            'view' => 'frontend/formindex_home_appliances',
            'otherData' => [
                'page_class' => 'form-homeAppliances',
                'form_type' => '1',
            ],
        ],
        'groupBuying' => [
            'title' => '新建案團購主招募',
            'view' => 'frontend/formindex_group_buying',
            'otherData' => [
                'page_class' => 'form-groupBuying',
                'form_type' => '2',
            ]
        ]
    ];
    public function homeAppliances()
    {

        $form = $this->forms['homeAppliances'];
        return $this->renderView($form['view'], $form['title'], $form['otherData']);
    }
    public function homeAppliancesForm()
    {

        $form = $this->forms['homeAppliances'];
        return $this->renderView('frontend/form', $form['title'], $form['otherData']);
    }

    public function groupBuying()
    {
        $form = $this->forms['groupBuying'];
        return $this->renderView($form['view'], $form['title'], $form['otherData']);
    }
    public function groupBuyingForm()
    {
        $form = $this->forms['groupBuying'];
        return $this->renderView('frontend/form', $form['title'], $form['otherData']);
    }

    // 处理精品家电顾问服务表单
    public function submitForm()
    {

        $jsonData = $this->request->getJSON(true);
        
        // 將數據轉換為需要的格式
        $saveData = [
            'type' => $jsonData['type'],
            'name' => $jsonData['name'],
            'phone' => $jsonData['phone'],
            // 其他來自表單的數據
            'questions' => []
        ];
        for ($i = 1; $i <= 10; $i++) {
            $qKey = 'q'.$i; // 構造鍵名，如 'q1', 'q2', ..., 'q10'
            if (isset($jsonData[$qKey])) {
                $saveData['questions'][$qKey] = $jsonData[$qKey];
            }
        }
        

        // 序列化或轉為 JSON
        $serializedData = json_encode($saveData, JSON_UNESCAPED_UNICODE);

        // 準備儲存到資料庫的數據
        $formData = [
            'form_type' => $jsonData['type'],
            'u_name'    => $jsonData['name'],
            'u_phone'   => $jsonData['phone'],
            'u_budget'   => $jsonData['u_budget'],
            'u_location'   => $jsonData['u_location'],
            'user_data' => $serializedData,
            'status'    => 'pending'  // 或其他預設狀態
        ];

        // 保存到資料庫
        $formModel = new FormModel();
        $formModel->save($formData);

        // return $this->respond(["status" => "success", 'message' => '已成功提交', 'user_data' => $formData['user_data']], 200);

        $result = [
            "status" => "success",
            "message" => "已成功提交",
            "isSave" =>  $formModel->save($formData)
        ];
        return $this->response->setJSON($result);
    }
    public function sendSuccess() {
        return $this->renderView('frontend/sendSuccess',  '問卷答復已經送出');
    }
}
