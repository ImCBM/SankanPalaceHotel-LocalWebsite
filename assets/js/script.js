/**
 * Five Star Hotel - Main JavaScript
 * 
 * This file contains all the custom JavaScript functionality for the hotel website
 */

document.addEventListener('DOMContentLoaded', function() {
    // Navbar scroll effect
    const navbar = document.querySelector('.navbar');
    
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    
        // Trigger the scroll event on page load to set initial state
        window.dispatchEvent(new Event('scroll'));
    }
    
    // Room type selection and price calculation for reservation form
    const reservationForm = document.getElementById('reservationForm');
    
    if (reservationForm) {
        // Ensure check-out date is after check-in date
        const dateFrom = document.getElementById('date_from');
        const dateTo = document.getElementById('date_to');
        
        if (dateFrom && dateTo) {
            dateFrom.addEventListener('change', function() {
                const nextDay = new Date(this.value);
                nextDay.setDate(nextDay.getDate() + 1);
                
                // Format the date as YYYY-MM-DD
                const year = nextDay.getFullYear();
                const month = (nextDay.getMonth() + 1).toString().padStart(2, '0');
                const day = nextDay.getDate().toString().padStart(2, '0');
                
                dateTo.min = `${year}-${month}-${day}`;
                
                // If the current to-date is before the new min date, update it
                if (new Date(dateTo.value) < nextDay) {
                    dateTo.value = `${year}-${month}-${day}`;
                }
            });
        }
    }
    
    // Handle testimonial carousel (if exists)
    const testimonialCarousel = document.querySelector('.testimonial-carousel');
    if (testimonialCarousel) {
        new bootstrap.Carousel(testimonialCarousel, {
            interval: 5000
        });
    }
    
    // Add animation to elements when they come into view
    const animateOnScroll = function() {
        const elementsToAnimate = document.querySelectorAll('.scroll-animation');
        
        elementsToAnimate.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (elementPosition < windowHeight - 50) {
                element.classList.add('animated');
            }
        });
    };
    
    // Add scroll-animation class to elements we want to animate
    const addAnimationClasses = function() {
        // Add to section titles
        document.querySelectorAll('.section-title').forEach(element => {
            element.classList.add('scroll-animation', 'fade-in');
        });
        
        // Add to room cards
        document.querySelectorAll('.room-card').forEach(element => {
            element.classList.add('scroll-animation', 'fade-in-up');
        });
        
        // Add to amenity items
        document.querySelectorAll('.amenity-item').forEach((element, index) => {
            element.classList.add('scroll-animation', 'fade-in');
            element.style.animationDelay = `${index * 0.1}s`;
        });
        
        // Add to offer cards
        document.querySelectorAll('.offer-card').forEach(element => {
            element.classList.add('scroll-animation', 'fade-in-left');
        });
        
        // Add to testimonial cards
        document.querySelectorAll('.testimonial-card').forEach((element, index) => {
            element.classList.add('scroll-animation', 'fade-in-up');
            element.style.animationDelay = `${index * 0.1}s`;
        });
    };
    
    // Call functions
    addAnimationClasses();
    window.addEventListener('scroll', animateOnScroll);
    animateOnScroll(); // Call once on page load
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href !== '#' && href.startsWith('#')) {
                e.preventDefault();
                
                const targetElement = document.querySelector(this.getAttribute('href'));
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
    
    // Form validation enhancement
    const forms = document.querySelectorAll('.needs-validation');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
            // Add validation classes on blur
            input.addEventListener('blur', function() {
                if (this.checkValidity()) {
                    this.classList.add('is-valid');
                    this.classList.remove('is-invalid');
                } else if (this.value !== '') {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                }
            });
            
            // Clear validation classes on focus
            input.addEventListener('focus', function() {
                this.classList.remove('is-valid', 'is-invalid');
            });
        });
    });
});