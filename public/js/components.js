// Component loader and configuration
document.addEventListener('DOMContentLoaded', function() {
    // Determine the correct path for components based on current page
    const isIndexPage = window.location.pathname.endsWith('index.html') || window.location.pathname.endsWith('/');
    const componentPath = isIndexPage ? 'views/components/' : '../views/components/';
    
    // Load header component
    fetch(componentPath + 'header.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('header-placeholder').innerHTML = data;
            setupHeader();
            
            // Add hero section for index page
            if (isIndexPage) {
                addHeroSection();
            }
        })
        .catch(error => console.error('Error loading header:', error));

    // Load footer component
    fetch(componentPath + 'footer.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('footer-placeholder').innerHTML = data;
            setupFooter();
        })
        .catch(error => console.error('Error loading footer:', error));
});

// Setup header after loading
function setupHeader() {
    // Update all hotel name instances in header
    document.querySelectorAll('#hotelName').forEach(el => {
        el.textContent = hotelConfig.name;
    });
    
    // Set active navigation item based on current page
    const currentPage = window.location.pathname.split('/').pop();
    const navItems = {
        'index.html': 'nav-home',
        'company_profile.html': 'nav-profile',
        'reservation.html': 'nav-reservation',
        'contacts.html': 'nav-contacts'
    };
    
    if (navItems[currentPage]) {
        document.getElementById(navItems[currentPage]).classList.add('active');
    }
    
    // Set page title and breadcrumb
    const pageTitles = {
        'index.html': 'Home',
        'company_profile.html': 'Company Profile',
        'reservation.html': 'Reservation',
        'contacts.html': 'Contacts'
    };
    
    if (pageTitles[currentPage]) {
        document.getElementById('page-title').textContent = pageTitles[currentPage];
        document.getElementById('current-page').textContent = pageTitles[currentPage];
    }
}

// Add hero section for index page
function addHeroSection() {
    const headerElement = document.querySelector('.header');
    const heroSection = document.createElement('div');
    heroSection.className = 'hero-section';
    heroSection.innerHTML = `
        <div class="hero-text container">
            <h2>Welcome to <span id="hotelNameHero"></span>! ✧˖°</h2>
            <p id="hotelTagline"></p>
            <a href="views/reservation.html" class="btn btn-primary btn-lg">Start Your Adventure</a>
        </div>
    `;
    
    // Insert hero section after the navbar
    const navbar = headerElement.querySelector('.navbar');
    navbar.parentNode.insertBefore(heroSection, navbar.nextSibling);
    
    // Update hero section content
    document.getElementById('hotelNameHero').textContent = hotelConfig.name;
    document.getElementById('hotelTagline').textContent = hotelConfig.tagline;
}

// Setup footer after loading
function setupFooter() {
    // Update all hotel name instances in footer
    document.querySelectorAll('#hotelNameFooter, #hotelNameCopyright').forEach(el => {
        el.textContent = hotelConfig.name;
    });
    
    // Update tagline
    document.querySelectorAll('#hotelTaglineFooter').forEach(el => {
        el.textContent = hotelConfig.tagline;
    });
    
    // Update contact information
    document.getElementById('hotelAddress').textContent = hotelConfig.address;
    document.getElementById('hotelPhone').textContent = hotelConfig.phone;
    document.getElementById('hotelEmail').textContent = hotelConfig.email;
    
    // Update social links
    document.getElementById('discordLink').href = hotelConfig.social.discord;
    document.getElementById('twitterLink').href = hotelConfig.social.twitter;
    document.getElementById('instagramLink').href = hotelConfig.social.instagram;
    document.getElementById('tiktokLink').href = hotelConfig.social.tiktok;
} 