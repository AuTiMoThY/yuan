# 問卷網 - 前端+後端開發

## 📝 專案簡介
一個使用 CodeIgniter 4 框架開發的問卷調查系統，包含前台問卷填寫及後台管理功能。

## 🔗 相關連結
- [前台網站](https://demo-yuan.auozzy.com/)
- [後台管理](https://demo-yuan.auozzy.com/demoadmin)
  - 測試帳號：demo
  - 測試密碼：demo

## ✨ 功能特點
- 前台功能
  - 問卷填寫
  - 表單驗證
  - 客製化介面
- 後台功能
  - 問卷管理
  - 資料查詢與排序
  - CSV資料匯出

## 🛠 技術
### 前端
- Vue 3 (Composition API)
- SCSS 樣式處理
- Gulp 自動化工具
- RWD響應式設計
- 客製化表單元件
- 互動效果設計

### 後端
- CodeIgniter 4
- MySQL
- RESTful API


## 💻 環境要求
- PHP 8.1
-- PHP intl 擴展已安裝並啟用`extension=intl`
- MySQL 8.0
- Node.js v22.11.0
- npm v10.9.0

## 🔧 安裝說明
1. 下載專案
```bash
git clone https://github.com/AuTiMoThY/yuan.git
cd yuan
```

2. 安裝依賴
```bash
npm install
```

3. 設定資料庫
- 建立資料庫 `yuan`
- 匯入資料表
```bash
# 將 database.sql 匯入到 MySQL
mysql -u your_username -p yuan < database.sql
```
- 複製 `.env.example` 為 `.env` 並設定資料庫連線資訊
```bash
DB_HOST = localhost
DB_USER = your_username
DB_PASS = your_password
DB_NAME = yuan
```

4. 啟動
```bash
gulp php
```

5. 訪問網站
```bash
http://localhost:8100
```



## 📸 系統展示
### 前台首頁
![首頁](https://demo.auozzy.com/picture/yuan-index.jpg)
![表單](https://demo.auozzy.com/picture/yuan-form-1.jpg)
![表單](https://demo.auozzy.com/picture/yuan-form-2.jpg)

### 後台介面
![後台登入頁](https://demo.auozzy.com/picture/yuan-admin-login.jpg)
![後台資料頁](https://demo.auozzy.com/picture/yuan-admin-datatable.jpg)

