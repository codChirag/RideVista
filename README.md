# RideVista 🚗  
A full-stack ride booking platform inspired by Uber/Ola.

RideVista is a role-based web application that allows users to book rides, drivers to manage ride requests, and admins to monitor the system.  
This project demonstrates real-world backend and full-stack development skills.

---

## 🔑 Features
- User (Rider) registration and login
- Driver registration and dashboard
- Secure authentication using password hashing
- Role-based access control (User / Driver / Admin)
- Ride booking workflow (request → accept → complete)
- MySQL relational database with foreign keys
- Clean and scalable project structure

---

## 🛠️ Tech Stack
- **Frontend:** HTML, CSS, JavaScript  
- **Backend:** PHP  
- **Database:** MySQL  
- **Hosting:** InfinityFree  
- **Version Control:** Git & GitHub  

---

## 🗄️ Database Design
The database is normalized and designed using real production principles:
- `users` table for all roles
- `drivers` table linked via foreign key
- `rides` table with status-based lifecycle

Database schema:
