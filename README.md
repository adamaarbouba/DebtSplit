# 🏠💰 DebtSplit

> A simple and clean web app to help roommates track shared expenses and debts — without messy spreadsheets or endless group chat messages.

DebtSplit gives every roommate a clear dashboard to see who owes what, across multiple shared houses.

---

## ✨ Features

### 🏘️ Multiple Houses
- Join and manage multiple colocations  
  (e.g., your main apartment and a summer house)

### 💰 Debt Tracking
- Instantly see:
  - How much you owe
  - How much others owe you
- Clear and transparent balance calculations

### 🗂️ Expense Categories
Organize expenses into structured groups like:
- Rent
- Food
- Internet
- Utilities
- Custom categories

### 👑 Role Management
Each house includes:
- Owner – Full control over the house
- Members – Regular participants

---

## 🛠 Tech Stack

| Technology   | Purpose                      |
| ------------ | ---------------------------- |
| Laravel 11   | Backend logic & architecture |
| Tailwind CSS | Modern and responsive UI     |
| MySQL        | Relational database          |
| Eloquent ORM | Many-to-Many relationships   |

---

## 🏗 Database Architecture

The core of the system is the pivot table:

### colocation_user

This table connects users and colocations using a Many-to-Many relationship.

It also stores additional metadata:

- role → (owner or member)
- debt → Current balance for that user in the house
- joined_at → Date the user joined

### 🔒 Data Integrity

A unique constraint ensures that:
- A user cannot join the same house more than once.

---

## 🎯 Why DebtSplit?

Managing shared expenses shouldn't be stressful.

DebtSplit focuses on:
- Transparency  
- Simplicity  
- Clean UI  
- Clear financial overview  

---

## 🚀 Future Improvements

- Expense splitting per transaction  
- Payment history  
- Notifications  
- Mobile optimization  
- API support  

---

## 📌 Status

Currently in development