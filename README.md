# LogiKit - Asset Management Platform

A modern web application for managing IT equipment, built with Symfony 7 and PHP 8.3.

## 🚀 Features

### Core Functionality
- **Asset Management**: Track laptops and equipment with serial numbers, brands, and models
- **User Management**: Role-based access control with 3 roles (Admin IT, Manager, User)
- **Assignment System**: Assign equipment to employees with start/end dates
- **PDF Generation**: Automatic responsibility discharge document generation
- **Stock Management**: Track consumables with low-stock alerts
- **Audit Trail**: Complete history of all actions performed

### Advanced Features
- **Workflow Engine**: Symfony Workflow component managing asset states (Available → Assigned → Maintenance → Lost → Retired)
- **Real-time Dashboard**: Live statistics on asset inventory
- **Role-Based Access Control**:
  - Admin IT: Full access (assets, users, audit logs)
  - Manager: Asset and assignment management
  - User: View assigned equipment

## 🛠️ Technology Stack

### Backend
- **Language**: PHP 8.3
- **Framework**: Symfony 7
- **ORM**: Doctrine
- **Database**: MySQL
- **Architecture**: MVC

### Frontend
- **Templating**: Twig
- **Styling**: Tailwind CSS
- **PDF Generation**: Dompdf

### DevOps
- **Version Control**: Git & GitHub
- **Project Management**: Jira (Scrum)
- **Local Server**: Laragon

## 📦 Installation

### Prerequisites
- PHP 8.3
- MySQL
- Composer
- Symfony CLI

### Setup

**1. Clone the repository**
```bash
git clone https://github.com/rayanetab/logikit.git
cd logikit
```

**2. Install dependencies**
```bash
composer install
```

**3. Configure environment**
```bash
cp .env .env.local
# Edit DATABASE_URL in .env.local
DATABASE_URL="mysql://root:@127.0.0.1:3306/logikit?serverVersion=8.0&charset=utf8mb4"
```

**4. Create database and run migrations**
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

**5. Load fixtures (test data)**
```bash
php bin/console doctrine:fixtures:load
```

**6. Start the server**
```bash
php -S localhost:8000 -t public
```

**7. Access the application**
