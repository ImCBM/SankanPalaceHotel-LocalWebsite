// Hotel Configuration
const hotelConfig = {
    name: "Sankan Palace Hotel",
    tagline: "Your Luxury Dream Getaway",
    email: "info@sankanpalace.com",
    phone: "+81 123-456-789",
    address: "Akihabara District, Tokyo",
    social: {
        discord: "#",
        twitter: "#",
        instagram: "#",
        tiktok: "#"
    },
    images: {
        hero: "https://images.pexels.com/photos/3778876/pexels-photo-3778876.jpeg",
        welcome: "https://images.pexels.com/photos/3778876/pexels-photo-3778876.jpeg",
        rooms: {
            magicalGirl: "https://images.pexels.com/photos/164595/pexels-photo-164595.jpeg",
            ninjaHideout: "https://images.pexels.com/photos/271624/pexels-photo-271624.jpeg",
            mechaPilot: "https://images.pexels.com/photos/1579253/pexels-photo-1579253.jpeg"
        },
        team: {
            ceo: "../public/img/Balalaika.png",
            operations: "../public/img/Verocchio.png",
            chef: "../public/img/MrChang.png"
        },
        history: "https://images.pexels.com/photos/1134176/pexels-photo-1134176.jpeg"
    }
};

// Make config available globally
window.hotelConfig = hotelConfig; 