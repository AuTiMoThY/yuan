<?php
namespace App\Controllers\Frontend;
use App\Controllers\BaseController;

class Home extends BaseController
{
    private $page_title = '首頁';
    public function index(): string
    {
        return $this->renderView('frontend/home', $this->page_title);
    }
}
