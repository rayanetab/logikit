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
<<<<<<< HEAD
## 👤 Default Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin IT | admin@logikit.fr | admin123 |
| Manager | manager@logikit.fr | manager123 |
| User | user@logikit.fr | user123 |

## 🗄️ Database Schema

5 main entities:
- **User**: Employees with roles and authentication
- **Asset**: Unique equipment (laptops) with workflow states
- **Consumable**: Stock-managed peripherals (mice, chargers)
- **Assignment**: Links users to assets/consumables with dates
- **History**: Complete audit trail of all actions

## 🔄 Asset Workflow

## 📊 Project Management

Developed using **Scrum methodology** with 3 sprints of 2 weeks:

| Sprint | Period | Goal |
|--------|--------|------|
| Sprint 1 | 20/04 - 01/05 | Foundations & Authentication |
| Sprint 2 | 04/05 - 15/05 | Asset Management & Workflows |
| Sprint 3 | 18/05 - 05/06 | PDF Generation & Dashboard |

## 👨‍💻 Author

**Rayane Tabouri**  
L3 Informatique parcours MIAGE - Aix-Marseille Université  
Stage chez Aggrego-Tech - Aix-en-Provence  
2025/2026
=======
>>>>>>> b1cc64e929fad44c0ddedbfca0a63edf2ea7283c
