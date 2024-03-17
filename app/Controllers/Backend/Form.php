<?php

namespace App\Controllers\Backend;

use App\Controllers\BackendController;
use App\Models\FormDatatableModel;
use CodeIgniter\API\ResponseTrait;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv as CsvWriter;

class Form extends BackendController
{
    use ResponseTrait;

    private function typeTxtToCode($type)
    {
        if ($type == 'home-appliances') {
            $typeCode = "1";
        } elseif ($type == "group-buying") {
            $typeCode = '2';
        } else {
            $typeCode = "1";
        }

        return $typeCode;
    }

    private function typeTxtToName($type)
    {
        if ($type == "home-appliances") {
            $name = '精品家電問卷';
            // $type = '1';
        } elseif ($type == "group-buying") {
            $name = '新建案團購主問卷';
            // $type = '2';
        }

        return $name;
    }

    public function index($type = null)
    {
        $d = [
            'form_type' => $type,
            'status_options' => [
                ['value' => '0', 'text' => $this->getStatusText(0)],
                ['value' => '1', 'text' => $this->getStatusText(1)],
                ['value' => '2', 'text' => $this->getStatusText(2)],
            ],
        ];

        return $this->renderView('backend/form_datatable', $this->typeTxtToName($type), $d);
    }

    public function apiDatatable($type = null)
    {
        $perPage = 10;
        // 从数据库获取数据
        $query = $this->formModel;
        $query = $query->where('form_type', $this->typeTxtToCode($type));

        // 获取查询参数
        $startDate = $this->request->getVar('startDate');
        $endDate = $this->request->getVar('endDate');
        $status = $this->request->getVar('status');
        $sortField = $this->request->getVar('sort');
        $sortOrder = $this->request->getVar('order');

        // 应用日期范围过滤
        if (isset($startDate) && !empty($startDate)) {
            $query->where('DATE(created_at) >=', $startDate);
        }
        if (isset($endDate) && !empty($endDate)) {
            $query->where('DATE(created_at) <=', $endDate);
        }

        // 应用状态过滤
        if (isset($status) && $status !== '') {
            $query->where('status', $status);
        }

        // 应用排序
        if (isset($sortField) && !empty($sortField) && isset($sortOrder) && !empty($sortOrder)) {
            // 确定如何映射排序字段到数据库字段
            if($sortField == "budget") {
                $sortField = "u_budget";
            }
            elseif( $sortField == "location") {
                $sortField = "u_location";
            }
            $query->orderBy($sortField, $sortOrder);
        } else {
            // 默认排序
            $query->orderBy('created_at', 'DESC');
        }




        $data = $query->paginate($perPage);

        // 取出各別回答
        foreach ($data as $key => $value) {
            $userData = $value['user_data'];
            $parsedData = json_decode($userData, true);
            $data[$key]['parsedData'] = $parsedData;
            // 不方便聯繫時間
            $data[$key]['no_contact'] = $this->getQuestionValue($parsedData['questions'], 'q10');
        }

        $result = [
            'data' => $data,
            'paper' => $query->pager->getDetails(),
            'test' => [

            ]
        ];

        // 返回JSON格式的响应
        return $this->response->setJSON($result);
    }

    /*
    public function formDatatable($type = null)
    {
        $startDate = $this->request->getGet('startDate');
        $endDate = $this->request->getGet('endDate');
        $status = $this->request->getGet('status');
        $sortField = $this->request->getGet('sort');
        $sortOrder = $this->request->getGet('order');

        $perPage = 10;

        $query = $this->formModel;

        if ($type == "home-appliances") {
            $title = '精品家電問卷';
            $type = '1';
        } elseif ($type == "group-buying") {
            $title = '新建案團購主問卷';
            $type = '2';
        }

        $query = $query->where('form_type', $type);

        // 日期範圍過濾
        if (!empty($startDate)) {
            $query->where('DATE(created_at) >=', $startDate);
        }
        if (!empty($endDate)) {
            $query->where('DATE(created_at) <=', $endDate);
        }

        // 狀態過濾
        if (!empty($status)) {
            $query->where('status', $status);
        }

        // if (!empty($sortField) && !empty($sortOrder)) {
        //     // 根据 sortField 确定数据库中对应的字段
        //     $dbField = $this->mapSortFieldToDbColumn($sortField);

        //     // 应用排序
        //     if (!empty($dbField)) {
        //         $query->orderBy($dbField, $sortOrder);
        //     }
        // } else {
        //     // 默认排序
        //     $query->orderBy('created_at', 'DESC');
        // }

        $query->orderBy('created_at', 'DESC');

        $data = $query->paginate($perPage);
        $pager = $query->pager->links();

        // 取出各別回答
        foreach ($data as $key => $value) {

            $userData = $value['user_data'];
            $parsedData = json_decode($userData, true);
            $data[$key]['parsedData'] = $parsedData;

            // 狀態code轉文字
            $data[$key]['status_text'] = $this->getStatusText($value['status']);
            // 不方便聯繫時間
            $data[$key]['no_contact'] = $this->getQuestionValue($parsedData['questions'], 'q10');
            // 預算
            $data[$key]['budget'] = $this->getQuestionValue($parsedData['questions'], 'q8');
            // 地點
            $data[$key]['location'] = $this->getQuestionValue($parsedData['questions'], 'q2');
        }



        $d = [
            'form_type' => $type,
            'data' => $data,
            'pager' => $pager,
            'status_options' => [
                ['value' => '0', 'text' => $this->getStatusText(0)],
                ['value' => '1', 'text' => $this->getStatusText(1)],
                ['value' => '2', 'text' => $this->getStatusText(2)],
            ],
            'fliter_date' => [$startDate, $endDate],
            'filter_status' => $status
        ];

        // dd($data);
        return $this->renderView('backend/form_datatable', $title, $d);
    }
    */

    public function getFormData()
    {
        $json = $this->request->getJSON();
        $id = $json->id ?? null;
        if (!$id) {
            return $this->failNotFound('No ID provided');
        }

        $formData = $this->formModel->find($id);
        if (!$formData) {
            return $this->failNotFound('Form data not found');
        }

        $formData['status_text'] = $this->getStatusText($formData['status']);



        return $this->respond(['message' => 'successful', 'data' => $formData], 200);
    }

    public function updateStatus()
    {
        $json = $this->request->getJSON();
        $id = $json->id;
        $status = $json->status;

        // 更新數據庫中的狀態...
        $updateStatusModel = new FormDatatableModel();
        $updateStatusModel->update($id, ['status' => $status]);


        return $this->response->setJSON(['success' => true]);
    }

    /*
    public function sendFilter()
    {
        // 獲取查詢參數
        $type = $this->request->getVar('type');
        $startDate = $this->request->getVar('startDate');
        $endDate = $this->request->getVar('endDate');
        $status = $this->request->getVar('status');

        // 構建查詢
        $query = $this->formModel->where('form_type', $type);

        // 根據日期範圍添加條件
        if (!empty($startDate)) {
            $query = $query->where('DATE(created_at) >=', $startDate);
        }
        if (!empty($endDate)) {
            $query = $query->where('DATE(created_at) <=', $endDate);
        }

        // 根據狀態添加條件
        if (!empty($status)) {
            $query = $query->where('status', $status);
        }

        // 執行查詢並獲取結果
        $results = $query->findAll();

        // 返回查詢結果
        // 您可以根據需要返回視圖或 JSON 響應
        return $this->response->setJSON(['success' => true, 'results' => $results]);
    }
    */


    public function exportCsv($type)
    {
        /*
        $data = $this->formModel->where('form_type', $type)->findAll();
        $csvTitle = [
            'A1' => '編號',
            'B1' => '填寫時間',
            'C1' => '姓名',
            'D1' => '電話',
            'E1' => '不方便聯繫時間',
            'F1' => '家電購買的緣由是？',
            'G1' => '使用地點在哪個區域呢？',
            'H1' => '建築物有配置電梯嗎？',
            'I1' => '預計常態使用人數幾位呢？',
            'J1' => '家中是否有寵物呢？',
            'K1' => '哪個家中區域是您最注重的呢？',
            'L1' => '您期望獲得哪一種的生活場景？',
            'M1' => '您預計投入多少資金打造夢想中的生活場景呢？',
            'N1' => '我們會在2日內與您聯繫，您準備好了嗎？',
            'O1' => '如果您已經準備好了，請留下資料，讓我們聯繫您'
        ];

        $csvValue = [];
        foreach ($data as $k => $v) {
            $userData = $v['user_data'];
            $parsedData = json_decode($userData, true);
            $q10ValueNoContactTxt = '';
            if (isset($parsedData['questions']['q10'])) {
                $q10ValueStr = $parsedData['questions']['q10']['value'];
                // 用逗號分割字符串
                $q10ValueParts = explode(',', $q10ValueStr);
                // 初始化一個變數來保存「不方便聯繫的時間」的值
                foreach ($q10ValueParts as $part) {
                    // 移除字符串前後的空白
                    $trimmedPart = trim($part);

                    // 檢查這部分是否以「不方便聯繫的時間:」開頭
                    if (strpos($trimmedPart, '不方便聯繫的時間:') === 0) {
                        // 使用 explode() 再次分割，然後取得「不方便聯繫的時間:」後面的值
                        $timeParts = explode(':', $trimmedPart);
                        if (isset($timeParts[1])) {
                            $q10ValueNoContactTxt = trim($timeParts[1]); // 移除前後空白
                            break; // 找到後跳出循環
                        }
                    }
                }
            }

            $questionValues = [];
            for ($i = 1; $i <= 10; $i++) {
                $questionKey = 'q' . $i;
                $questionValues[] = $this->get_question_value($parsedData, $questionKey);
            }

            $csvValue = array_merge([
                $k + 1,
                $v['created_at'],
                $v['u_name'],
                $v['u_phone'],
                $q10ValueNoContactTxt,
            ], $questionValues);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 設置數據
        foreach($csvTitle as $k => $v) {
            $sheet->setCellValue($k, $v);
        }


        // 設置欄位 A 的寬度為 20
        $sheet->getColumnDimension('A')->setWidth(20);

        // 寫入文件
        $writer = new Xlsx($spreadsheet);
        
        if ($type == '1') {
            $filename = "精品家電問卷";
        } elseif ($type == "2") {
            $filename = '新建案團購主問卷';
        }
        $fileName = $filename.'.csv';
        $writer->save($fileName);

        // 下載文件
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
        $writer->save('php://output');
        exit;
        */


        $data = $this->formModel->where('form_type', $this->typeTxtToCode($type))->findAll(); // 假設這是從Model中查詢到的數據

        // foreach ($data as $k => $v) {
        //     var_dump($v);
        //     $userData = $v['user_data'];
        //     $parsedData = json_decode($userData, true);

        //     $q10ValueNoContactTxt = '';
        //     if (isset($parsedData['questions']['q10'])) {
        //         $q10ValueStr = $parsedData['questions']['q10']['value'];
        //         // 用逗號分割字符串
        //         $q10ValueParts = explode(',', $q10ValueStr);
        //         // 初始化一個變數來保存「不方便聯繫的時間」的值
        //         foreach ($q10ValueParts as $part) {
        //             // 移除字符串前後的空白
        //             $trimmedPart = trim($part);

        //             // 檢查這部分是否以「不方便聯繫的時間:」開頭
        //             if (strpos($trimmedPart, '不方便聯繫的時間:') === 0) {
        //                 // 使用 explode() 再次分割，然後取得「不方便聯繫的時間:」後面的值
        //                 $timeParts = explode(':', $trimmedPart);
        //                 if (isset($timeParts[1])) {
        //                     $q10ValueNoContactTxt = trim($timeParts[1]); // 移除前後空白
        //                     break; // 找到後跳出循環
        //                 }
        //             }
        //         }
        //     }


        //     $questionValues = [];
        //     for ($i = 1; $i <= 10; $i++) {
        //         $questionKey = 'q' . $i;
        //         $questionValues[] = $this->get_question_value($parsedData, $questionKey);
        //     }
        //     echo "<br>";
        //     print_r(array_merge([
        //         $k + 1,
        //         $v['created_at'],
        //         $v['u_name'],
        //         $v['u_phone'],
        //         $q10ValueNoContactTxt,
        //     ], $questionValues));
        //     echo "<hr>";
        // }
        // die();

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $this->typeTxtToName($type) . '.csv"');

        $output = fopen('php://output', 'w');
        fwrite($output, "\xEF\xBB\xBF");

        // 可選：添加CSV列標題
        fputcsv($output, [
            '編號',
            '填寫時間',
            '姓名',
            '電話',
            '不方便聯繫時間',
            '家電購買的緣由是？',
            '使用地點在哪個區域呢？',
            '建築物有配置電梯嗎？',
            '預計常態使用人數幾位呢？',
            '家中是否有寵物呢？',
            '哪個家中區域是您最注重的呢？',
            '您期望獲得哪一種的生活場景？',
            '您預計投入多少資金打造夢想中的生活場景呢？',
            '我們會在2日內與您聯繫，您準備好了嗎？',
            '如果您已經準備好了，請留下資料，讓我們聯繫您'
        ]);

        foreach ($data as $k => $v) {
            $userData = $v['user_data'];
            $parsedData = json_decode($userData, true);
            $q10ValueNoContactTxt = '';
            if (isset($parsedData['questions']['q10'])) {
                $q10ValueStr = $parsedData['questions']['q10']['value'];
                // 用逗號分割字符串
                $q10ValueParts = explode(',', $q10ValueStr);
                // 初始化一個變數來保存「不方便聯繫的時間」的值
                foreach ($q10ValueParts as $part) {
                    // 移除字符串前後的空白
                    $trimmedPart = trim($part);

                    // 檢查這部分是否以「不方便聯繫的時間:」開頭
                    if (strpos($trimmedPart, '不方便聯繫的時間:') === 0) {
                        // 使用 explode() 再次分割，然後取得「不方便聯繫的時間:」後面的值
                        $timeParts = explode(':', $trimmedPart);
                        if (isset($timeParts[1])) {
                            $q10ValueNoContactTxt = trim($timeParts[1]); // 移除前後空白
                            break; // 找到後跳出循環
                        }
                    }
                }
            }

            $questionValues = [];
            for ($i = 1; $i <= 10; $i++) {
                $questionKey = 'q' . $i;
                $questionValues[] = $this->get_question_value($parsedData, $questionKey);
            }

            fputcsv($output, array_merge([
                $k + 1,
                $v['created_at'],
                $v['u_name'],
                $v['u_phone'],
                $q10ValueNoContactTxt,
            ], $questionValues));
        }

        fclose($output);
        exit;
    }
    public function get_question_value($parsedData, $questionKey)
    {
        if (isset($parsedData['questions'][$questionKey])) {
            $value = $parsedData['questions'][$questionKey]['value'];
            if (is_array($value)) {
                $value = implode(', ', $value);  // 將數組轉換為以逗號和空格分隔的字串
            }
            return $value;
        } else {
            return '';
        }
        // return isset($parsedData['questions'][$questionKey]) ? $parsedData['questions'][$questionKey]['value'] : '';
    }
}
