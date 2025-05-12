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