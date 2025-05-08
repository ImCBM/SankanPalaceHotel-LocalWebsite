# Database Setup Instructions

Follow these steps to set up the database for the Five Star Hotel Management System:

1. Start XAMPP:
   - Open XAMPP Control Panel
   - Start Apache and MySQL services

2. Access phpMyAdmin:
   - Open your web browser
   - Navigate to: http://localhost/phpmyadmin

3. Create Database:
   - Click "New" in the left sidebar
   - Enter database name: "five_star_hotel"
   - Click "Create"

4. Import SQL File:
   - Select the "five_star_hotel" database from the left sidebar
   - Click the "Import" tab at the top
   - Click "Choose File" and select the `database.sql` file
   - Scroll down and click "Go" to import

5. Verify Installation:
   - Check that all tables are created:
     - customers
     - room_types
     - room_capacities
     - rooms
     - payment_types
     - reservations
     - contact_messages
   - Verify that sample data is populated in the tables

The database is now ready for use with the hotel management system.