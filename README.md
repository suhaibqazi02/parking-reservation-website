# parking-reservation-website

PARKER is a web-based parking reservation system that allows users to reserve parking spots, manage reservations, and view receipts. The system also includes an admin dashboard for managing reservations and generating reports.

---

## Features

### User Features
- **User Registration**: Create an account to access the reservation system.
- **Login/Logout**: Secure login and logout functionality.
- **Make Reservations**: Reserve parking spots by selecting a vehicle type, license plate number, arrival time, and parking duration.
- **View Reservations**: Check reservation details.
- **Cancel Reservations**: Cancel existing reservations.
- **View Receipts**: View a detailed receipt after making a reservation.

### Admin Features
- **Admin Login**: Secure access to the admin dashboard.
- **View Reservations**: View all reservations in a tabular format.
- **Cancel Reservations**: Cancel reservations on behalf of users.
- **Generate Reports**: Generate daily, weekly, or monthly reports.
- **Logout**: Secure logout functionality.

---

## Prerequisites

To run this project, ensure you have the following installed:
1. **XAMPP** (or any other local server with PHP and MySQL support)
2. **Web Browser** (e.g., Chrome, Firefox)
3. **PHP 7.4+**
4. **MySQL 5.7+**

---

## Installation

1. Clone or download the project files into your local server's root directory (e.g., `htdocs` for XAMPP).
   ```bash
   git clone https://github.com/suhaibqazi02/parking-reservation-website.git
   ```

2. Start your XAMPP server and ensure Apache and MySQL are running.

3. Import the database:
   - Open **phpMyAdmin** in your browser (e.g., `http://localhost/phpmyadmin`).
   - Create a new database named `parking_reservation_website`.
   - Import the SQL file `parking_reservation_website.sql` located in the project folder.

4. Configure the database connection:
   - Open the file `db_connect.php` in the project folder.
   - Ensure the database credentials match your local setup:
     ```php
     $host = "localhost";
     $dbname = "parking_reservation_website";
     $db_user = "root";
     $db_pass = "";
     ```

5. Access the project in your browser:
   - Navigate to `http://localhost/parking_reservation_website`.

---

## Project Structure

```
parking_reservation_website/
├── admin.html                # Admin dashboard
├── reservation.html          # User reservation page
├── cancel_reservation.html   # Cancel reservation page
├── view_reservation.html     # View reservations (Admin)
├── db_connect.php            # Database connection file
├── reservation.php           # Backend logic for reservations
├── cancel_reservation.php    # Backend logic for canceling reservations
├── receipt.php               # Display reservation receipt
├── parking_reservation_website.sql # Database schema and sample data
└── README.md                 # Project documentation
```

---

## Usage

### For Users:
1. Register an account on the signup page.
2. Log in to access the reservation system.
3. Make a reservation by filling out the form with vehicle details, arrival time, and parking duration.
4. View or cancel reservations as needed.

### For Admins:
1. Log in to the admin dashboard using admin credentials.
2. View all reservations, cancel reservations, or generate reports.

---

## Database Schema

### Tables:
1. **users**: Stores user information.
2. **reservations**: Stores reservation details.
3. **contact_form**: Stores messages submitted via the contact form.
4. **admin**: Stores admin credentials.

---

## Troubleshooting

1. **Database Connection Error**:
   - Ensure the database credentials in `db_connect.php` are correct.
   - Verify that the database `parking_reservation_website` exists in phpMyAdmin.

2. **Page Not Found**:
   - Ensure the project folder is placed in the correct directory (e.g., `htdocs` for XAMPP).
   - Access the project via `http://localhost/parking_reservation_website`.

3. **Reservation Errors**:
   - Ensure the `reservations` table in the database is properly configured.
   - Check for overlapping reservations or duplicate license plate numbers.

---

## Contact

For any issues or inquiries, please contact:
- **Email**: [suhaib.ckazi@gmail.com]
```
