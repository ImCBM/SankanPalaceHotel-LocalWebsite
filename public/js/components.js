/**
 * Loads header, footer, and hero sections
 */
document.addEventListener('DOMContentLoaded', function() {
    // Get path based on page
    const isIndexPage = window.location.pathname.endsWith('index.html') || window.location.pathname.endsWith('/');
    const componentPath = isIndexPage ? 'views/components/' : '../views/components/';
    
    // Load header
    fetch(componentPath + 'header.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('header-placeholder').innerHTML = data;
            setupHeader();
            
            // Add hero for index page
            if (isIndexPage) {
                addHeroSection();
            }
        })
        .catch(error => console.error('Error loading header:', error));

    // Load footer
    fetch(componentPath + 'footer.html')
        .then(response => response.text())
        .then(data => {
            document.getElementById('footer-placeholder').innerHTML = data;
            setupFooter();
        })
        .catch(error => console.error('Error loading footer:', error));
});

/**
 * Sets up header
 */
function setupHeader() {
    // Update hotel name
    document.querySelectorAll('#hotelName').forEach(el => {
        el.textContent = hotelConfig.name;
    });
    
    // Map pages to nav IDs
    const navItems = {
        'index.html': 'nav-home',
        'company_profile.html': 'nav-profile',
        'reservation.html': 'nav-reservation',
        'contacts.html': 'nav-contacts'
    };
    
    // Set active nav
    const currentPage = window.location.pathname.split('/').pop();
    if (navItems[currentPage]) {
        document.getElementById(navItems[currentPage]).classList.add('active');
    }
    
    // Map pages to titles
    const pageTitles = {
        'index.html': 'Home',
        'company_profile.html': 'Company Profile',
        'reservation.html': 'Reservation',
        'contacts.html': 'Contacts'
    };
    
    // Update titles
    if (pageTitles[currentPage]) {
        document.getElementById('page-title').textContent = pageTitles[currentPage];
        document.getElementById('current-page').textContent = pageTitles[currentPage];
    }
}

/**
 * Adds hero section
 */
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
    
    // Add hero after navbar
    const navbar = headerElement.querySelector('.navbar');
    navbar.parentNode.insertBefore(heroSection, navbar.nextSibling);
    
    // Update hero content
    document.getElementById('hotelNameHero').textContent = hotelConfig.name;
    document.getElementById('hotelTagline').textContent = hotelConfig.tagline;
}

/**
 * Sets up footer
 */
function setupFooter() {
    // Update hotel name
    document.querySelectorAll('#hotelNameFooter, #hotelNameCopyright').forEach(el => {
        el.textContent = hotelConfig.name;
    });
    
    // Update tagline
    document.querySelectorAll('#hotelTaglineFooter').forEach(el => {
        el.textContent = hotelConfig.tagline;
    });
    
    // Update contact info
    document.getElementById('hotelAddress').textContent = hotelConfig.address;
    document.getElementById('hotelPhone').textContent = hotelConfig.phone;
    document.getElementById('hotelEmail').textContent = hotelConfig.email;
    
    // Update social links
    document.getElementById('discordLink').href = hotelConfig.social.discord;
    document.getElementById('twitterLink').href = hotelConfig.social.twitter;
    document.getElementById('instagramLink').href = hotelConfig.social.instagram;
    document.getElementById('tiktokLink').href = hotelConfig.social.tiktok;
} 