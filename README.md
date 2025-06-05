# Sankan Palace Hotel Reservation System

A modern and feature-rich hotel reservation system built with PHP using the MVC architectural pattern. This system provides a seamless booking experience for guests while offering robust management capabilities for hotel staff.

Inspired by the fictional Sankan from the anime *Black Lagoon*, this project imagines a fully operational interface for the enigmatic luxury hotel located in the underworld-riddled city of Roanapur.

---

## Disclaimer

This project is a fan-made, non-commercial system based on the fictional *Hotel Sankan Palace*  as depicted in the anime *Black Lagoon*. All related names, characters, imagery, and references remain the intellectual property of Rei Hiroe and associated rights holders.  
It is developed solely for educational and demonstrative purposes. No copyright infringement is intended.


## Key Features

### Guest Features
- Intuitive room booking interface with real-time availability checking
- Dynamic room selection based on:
  - Room capacity (Single, Double, Family)
  - Room type (Regular, De Luxe, Suite)
  - Date availability
- Smart pricing system with:
  - Dynamic rate calculation based on room type and capacity
  - Special discounts for longer stays (10% for 3-5 nights, 15% for 6+ nights)
  - Payment method-specific pricing (Cash, Check, Credit Card)
- Real-time bill calculation with detailed breakdown
- Special requests and preferences handling
- Responsive design for all devices

### Room Management
- Three distinct room categories:
  - Regular Rooms: Essential amenities for comfortable stays
  - De Luxe Rooms: Premium amenities with elegant furnishings
  - Suite Rooms: Luxury accommodations with separate living areas
- Multiple capacity options:
  - Single occupancy
  - Double occupancy
  - Family rooms (up to 4 guests)
- Real-time room availability tracking
- Automated conflict prevention for overlapping bookings

### Payment System
- Multiple payment method support:
  - Cash (no additional charges)
  - Check (5% additional charge)
  - Credit Card (10% additional charge)
- Automatic bill calculation with:
  - Base room rate
  - Duration-based pricing
  - Payment method adjustments
  - Special discounts
  - Additional charges

## Technical Stack

- **Backend:**
  - PHP 7.4+
  - MySQL Database / PHPMyAdmin
  - PDO for secure database connectivity
  - MVC Architecture

- **Frontend:**
  - HTML5 & CSS3
  - Bootstrap 5 for responsive design
  - JavaScript for dynamic interactions
  - Font Awesome icons

## Project Structure

```
├── assets/         # Static assets (CSS, JS, images)
├── config/         # Configuration files
├── controllers/    # Request handlers
├── models/         # Data models
├── public/         # Publicly accessible files
├── supabase/       # Database migrations
└── views/          # UI templates
```

## Installation

1. Clone the repository to your local machine
2. Ensure XAMPP is installed and running
3. Place the project in your XAMPP htdocs directory
4. Create a new database named `SankanHotel_Database`
5. Import the database schema from `supabase/migrations/SQL_DB_QUERIES.sql`
6. Configure database connection in `config/config.php` if needed
7. Access the system through your web browser

## Default Admin Credentials

The system comes with a default admin account for initial setup:
- **Username**: `admin`
- **Password**: `admin123`

**Important Security Note**: 
- Change these default credentials immediately after first login
- Use strong passwords (minimum 8 characters, mix of letters, numbers, and special characters)
- Regularly update admin passwords for security
- The system uses password hashing for secure storage

## Database System

### Overview
The system uses MySQL/MariaDB through XAMPP with the following specifications:
- Database Name: `SankanHotel_Database`
- Default Credentials:
  - Username: `root`
  - Password: `` (empty by default)
- Character Set: UTF-8
- Collation: utf8mb4_general_ci

### Automatic Setup
The system includes an automatic database initialization feature that:
- Creates the database if it doesn't exist
- Sets up all required tables with proper relationships
- Imports initial data for room types, capacities, and payment methods
- Handles database migrations automatically

### Database Limits
- Maximum concurrent users: Limited by XAMPP's default configuration
- Maximum database size: Limited by available disk space
- Maximum table size: Limited by MySQL's configuration
- Backup frequency: Manual (recommended daily)

## Project Scope and Limitations

### Current Features
- Complete room management system
- Reservation handling
- Customer management
- Payment processing
- Admin dashboard
- Contact form system

### Known Limitations
1. **Scalability**
   - Designed for single-hotel operations
   - Not optimized for multi-hotel chains
   - Limited to XAMPP's default performance settings

2. **Payment Processing**
   - No direct integration with payment gateways
   - Manual payment verification required
   - Limited to cash, check, and credit card records

3. **User Management**
   - Single admin level (no role-based access control)
   - No customer account system
   - No password recovery system

4. **Reporting**
   - Basic reporting capabilities
   - No advanced analytics
   - Limited export options

5. **Technical Limitations**
   - Requires XAMPP environment
   - No cloud deployment support
   - Limited to PHP 7.4+ compatibility

### Future Enhancements
1. **Planned Features**
   - Customer account system
   - Online payment gateway integration
   - Advanced reporting system
   - Email notification system
   - Mobile app integration

2. **Potential Improvements**
   - Role-based access control
   - Cloud deployment support
   - API development
   - Multi-language support
   - Advanced search capabilities

## Database Schema

The system uses the following main tables:
- `customers`: Guest information
- `room_types`: Room categories and descriptions
- `room_capacities`: Room size configurations
- `rooms`: Individual room details and rates
- `payment_types`: Payment method configurations
- `reservations`: Booking records
- `contact_messages`: Guest inquiries

## License

This project is licensed under the GNU General Public License v3.0 (GPL-3.0).
The GPL-3.0 license ensures that:
- This software is free and open source
- You can use, modify, and distribute this software
- Any modifications must also be released under the GPL-3.0
- The software comes with no warranty

## Support

For support or inquiries, please contact the development team.