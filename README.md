# LabForce

LabForce is a laboratory testing and quality assurance system for fertilizer products, designed to support multi-country agricultural operations. The system enables field and lab teams to validate incoming fertilizer shipments against supplier certificates, ensuring compliance, quality, and safety standards.

---

## 🌍 Business Context

Fertilizer is sourced and distributed across multiple regions including Africa, the Middle East, Europe, and Asia. Ensuring product quality is critical for:

- Agricultural productivity
- Supplier accountability
- Regulatory compliance
- Customer trust

LabForce acts as a centralized system for recording, validating, and monitoring fertilizer quality across different countries and supply chains.

---

## 🎯 Key Objectives

- Capture lab test results for incoming fertilizer shipments
- Compare actual lab results against supplier certificates
- Flag deviations from expected specifications
- Record physical condition (e.g., wet, damaged, contaminated)
- Maintain a centralized, multi-country dataset
- Enable auditability and traceability of quality checks

---

## ⚙️ Core Features

### 🧪 Laboratory Testing
- Input lab test results for fertilizer samples
- Support multiple test parameters (e.g., nutrient composition, moisture content)
- Store structured results for analysis and reporting

### 📊 Certificate Comparison
- Compare lab results with supplier-provided certificates
- Automatically detect under-spec or out-of-range values
- Highlight discrepancies for review

### 🚨 Alerts & Warnings
- Trigger warnings when values fall below acceptable thresholds
- Visual indicators for under-spec products
- Email notifications using PHPMailer for critical deviations

### 📸 Image Capture
- Upload photos of fertilizer condition upon arrival
- Document issues such as:
  - Moisture exposure
  - Physical damage
  - Contamination

### 🌐 Multi-Country Support
- Manage data across multiple regions:
  - Saudi Arabia
  - Europe
  - China
  - Africa
- Standardized structure with localized data handling

### 🗂️ Centralized Data Management
- Store all lab results in a unified system
- Enable traceability of shipments and test outcomes
- Support operational reporting and audits

---

## 🧱 Tech Stack

- **Backend:** PHP (Laravel)
- **Frontend:** Blade templates / standard Laravel views
- **Database:** MySQL (or compatible)
- **Email Service:** PHPMailer
- **File Storage:** Local / server-based uploads

---

## 🚀 Getting Started

### 1. Clone the Repository

git clone https://github.com/YOUR_USERNAME/labforce.git
cd labforce

### 2. Install Dependencies
composer install

### 3. Configure Environment

Copy the environment file:

cp .env.example .env

Update the following in .env:

APP_NAME=LabForce
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_DATABASE=labforce
DB_USERNAME=root
DB_PASSWORD=yourpassword

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email
MAIL_FROM_NAME="LabForce"
4. Generate Application Key
php artisan key:generate
5. Run Migrations
php artisan migrate
6. Start the Server
php artisan serve

Then open:

http://127.0.0.1:8000
