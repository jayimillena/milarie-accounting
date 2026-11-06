# Milarie Accounting: Open-Source Accounting for SMEs

Milarie Accounting is a modern, secure, and fully open-source financial management and accounting platform designed specifically for Small and Medium-sized Enterprises (SMEs). Say goodbye to restrictive licenses and opaque cloud pricing. Take full control of your financial data, automate your bookkeeping, and streamline compliance with a tool built to scale with your business.

## 🚀 Key Features

* **Double-Entry Bookkeeping:** Complete ledger management supporting general journal entries, chart of accounts, trial balances, and automated reconciliation.

* **Invoicing & Billing:** Create professional, customizable invoices in multiple currencies, set up recurring billing, and track payment statuses in real-time.

* **Expense & Vendor Management:** Log bills, track vendor receipts, manage purchase orders, and monitor accounts payable efficiently.

* **Real-Time Financial Reporting:** Instantly generate critical financial statements including Profit & Loss (Income Statement), Balance Sheets, Cash Flow Statements, and Tax Summaries.

* **Multi-Currency & Multi-Entity:** Manage transactions across different global currencies with automated exchange rate updates and handle multiple business entities from a single dashboard.

* **Secure & Self-Hosted:** Keep your sensitive financial data on your own infrastructure with robust role-based access control (RBAC) and end-to-end encryption.

* **Extensible API:** Seamlessly integrate with payment gateways (Stripe, PayPal), CRM platforms, and inventory management systems via our RESTful API and webhooks.

## 🛠️ Technology Stack

* **Backend:** Node.js, Laravel 13, PHP 8.5.12*

* **Frontend:** React with Tailwind CSS for a responsive, modern UI, Livewire

* **Database:** MySQL for financial data handling

## ⚙️ Installation Guide (Manual / Without Docker)

If you prefer to run Milarie Accounting directly on your server or local machine without Docker, follow the steps below.

### Prerequisites

Ensure you have the following installed on your system:
* **Node.js** 
* **Composer** 
* **Git Bash**
* **MySQL** 
* **PHP 8.5.12** 

### Step 1: Clone the Repository

```bash
git clone https://github.com/milarie/milarie-accounting.git
cd milarie-accounting
```

### Step 2: Set Up the Database

Log in to your PostgreSQL shell and create a dedicated database and user for Milarie Accounting:

```sql
CREATE DATABASE milarie_db;
CREATE USER milarie_user WITH PASSWORD 'your_secure_password';
GRANT ALL PRIVILEGES ON DATABASE milarie_db TO milarie_user;
```

### Step 3: Configure Environment Variables

Copy the template environment file and update it with your database credentials and application settings:

```bash
cp .env.example .env
```

Open the `.env` file in your preferred text editor and update the following variables:
```env
PORT=3000
DATABASE_URL=postgresql://milarie_user:your_secure_password@localhost:5432/milarie_db
JWT_SECRET=your_super_secret_jwt_key
```

### Step 4: Install Dependencies & Build

Install dependencies for both the backend and frontend (or monorepo root):

```bash
# Install root/backend dependencies
npm install

# Install frontend dependencies (if separate)
cd client
npm install
cd ..
```

Run database migrations to set up your tables:

```bash
npm run db:migrate
```

### Step 5: Run the Application

You can start the backend and frontend servers in development mode, or build for production:

**Development Mode:**
```bash
npm run dev
```

**Production Mode:**
```bash
npm run build
npm start
```

Once running, open your browser and navigate to `http://localhost:3000` to complete the initial setup wizard.

## 📖 Documentation

Comprehensive guides for configuration, API usage, and contribution can be found in our [Wiki](https://github.com/milarie/milarie-accounting/wiki).

* [User Guide](https://github.com/milarie/milarie-accounting/wiki/User-Guide)
* [API Reference](https://github.com/milarie/milarie-accounting/wiki/API-Reference)

## 🤝 Contributing

We love contributions from the community! Please check out our [Contributing Guidelines](CONTRIBUTING.md) to get started.

## 🛡️ Security

If you discover a security vulnerability within Milarie Accounting, please refer to our [Security Policy](SECURITY.md) for details on how to responsibly disclose it.

## 📄 License

Milarie Accounting is open-source software licensed under the [MIT License](LICENSE).

Created by Jay and Jaymel of Salakot Agri-ventures Philippines Corporation with the help of Gemini Flash 3.6
"# milarie-accounting" 
