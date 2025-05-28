# 📊 Renata PLC Analytics Dashboard

A secure, role-based internal dashboard for Renata PLC that provides customer analytics, edit-approval workflows, and real-time notifications. Built using HTML, CSS, JavaScript, PHP, MySQL, and JSON.

---
![image](https://github.com/user-attachments/assets/802b792c-8be0-4889-bb49-5516f34e5e6d)

---

## 🚀 Project Summary

This web application is designed to:
- Visualize customer metrics and trends
- Allow authorized roles to manage and update customer data
- Enforce approval-based edit workflows
- Display live notifications for pending changes
- Maintain a clean, user-friendly interface for all roles

---

## 👥 User Roles and Permissions

| Role    | View Dashboard | View Customer List | Edit Info | Approve Edits |
|---------|----------------|--------------------|-----------|----------------|
| Admin   | ✅ Yes         | ✅ Yes             | ✅ Yes    | ❌ No          |
| Manager | ✅ Yes         | ✅ Yes             | ❌ No     | ✅ Yes         |
| Sales   | ✅ Yes         | ✅ Yes             | ❌ No     | ❌ No          |
| User    | ✅ Yes         | ❌ No              | ❌ No     | ❌ No          |

---

## 📂 Features

### 🔐 1. User Authentication
- Session-protected pages
- Login system with roles: admin, manager, sales, user
---

---

### 👁 2. Role-Based UI
- Content displayed conditionally based on user role
- Unauthorized access restricted both frontend and backend

### 📊 3. Analytics Dashboard
Includes:
- Total customers
- Average and highest income
- Sales by division (Bar Chart)
- Income distribution (Donut Chart)
- Gender-wise sales (Pie Chart)
- Marital status (Stacked Bar)
- Age vs. Income (Line Chart)
- Zero income customers (Indicator)
---
![image](https://github.com/user-attachments/assets/5b31d78c-b6c4-45b4-8fe6-90f239d52f5d)

---

### 📋 4. Customer Data Table (Role-based)
- Search by name
- Filter by division, gender, marital status
- Sort by age or income
- Income shown with progress bars
---
![image](https://github.com/user-attachments/assets/4148be1d-3b51-4724-960c-468d1ce2b75e)

---

### 📝 5. Edit Workflow (Admin Only)
- Modal form for editing
- Edits stored in `customer_edits` (pending state)
- Admins can't approve their own edits
---
![image](https://github.com/user-attachments/assets/2b491d22-50ce-4c56-829b-2968f95bce0b)

---

### ✅ 6. Approval System (Manager Only)
- View pending edits
- Approve → write to `data.json`
- Reject → discard changes
---
![image](https://github.com/user-attachments/assets/7ba00739-4c11-4b61-a899-068f28a03920)

---

### 🔔 7. Notification System (Manager Only)
- Admin submits edit → Notification created
- Bell icon with live alert (!)
- Notifications disappear when viewed
---
![image](https://github.com/user-attachments/assets/bb732658-e2e0-4d1f-a2ee-c3b9ea3ab0d9)

---

## 🗃️ Database Structure

### MySQL Tables:
- `users` — login info + roles
- `customer_edits` — pending edits
- `notifications` — alerts for manager

### JSON File:
- `data.json` — approved and finalized customer data

---

## 🧱 Folder Structure

```text
reneta_plc_dashboard/
│
├── dashboard/
│   ├── index.php
│   ├── dashboard.js
│   ├── style.css
│   ├── assets/
│   │   └── data/
│   │       └── data.json
│   ├── apply_edit.php
│   ├── pending-edits.php
│   ├── insert_notification.php
│   ├── fetch_notifications.php
│   └── submit_edit.php
│
├── login/
│   ├── login.html
│   ├── login.css
│   ├── login.php
│   ├── logout.php
│
├── register/
│   ├── register.html
│   ├── handle_register.php
│
├── db/
│   ├── create_users_table.sql
│   ├── create_customer_edits_table.sql
│   ├── create_notifications_table.sql
│   └── renata_users.sql
│
├── README.md
├── .gitignore
└── LICENSE (optional)

```

---

## ⚙️ Technologies Used

- **Frontend:** HTML, CSS, JS, FontAwesome, Chart.js
- **Backend:** PHP
- **Database:** MySQL + JSON file
- **Session:** PHP native sessions

---

## 🧪 How to Run Locally

1. **Clone Repository:**
   ```bash
   git clone https://github.com/YOUR_USERNAME/renata-plc-dashboard.git
   cd renata-plc-dashboard

2. **Setup Database:**

- Import SQL files in `/db` into MySQL  
- Update `config.php` with DB credentials

3. **Run Server (Linux Example):**

  ```bash
  sudo systemctl start httpd
  sudo systemctl start mysqld
 ```

4. **Access in Browser:**
   `http://localhost/reneta_plc/login/login.html`

---

## 📌 Notes

- Do not approve your own edits.
- JSON file (`data.json`) should not be edited manually.
- Notifications only show for the manager role.
- No customer data can be changed without approval.

--## 🧠 Author & Credits

**Developed By**: Ahib Afnan Siam  
🔗 [https://github.com/Ahib-Afnan-Siam](https://github.com/Ahib-Afnan-Siam)
