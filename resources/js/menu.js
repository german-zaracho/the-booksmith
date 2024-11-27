document.addEventListener('DOMContentLoaded', function() {

    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuOpenIcon = document.getElementById('menu-open-icon');
    const menuCloseIcon = document.getElementById('menu-close-icon');

    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');

    // Menu's initial state
    let isMobileMenuOpen = false;
    let isUserMenuOpen = false;

    // Open/close the user's profile
    // userMenuButton.addEventListener('click', function(event) {
    //     isUserMenuOpen = !isUserMenuOpen;
    //     userMenu.classList.toggle('md:hidden', !isUserMenuOpen);
    // });

    // Closes user profile if clicked outside
    // document.addEventListener('click', function(event) {
    //     if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
    //         isUserMenuOpen = false;
    //         userMenu.classList.add('md:hidden');
    //     }
    // });

    if (userMenuButton) {
        userMenuButton.addEventListener('click', function(event) {
            isUserMenuOpen = !isUserMenuOpen;
            userMenu.classList.toggle('md:hidden', !isUserMenuOpen);
        });

        document.addEventListener('click', function(event) {
            if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                isUserMenuOpen = false;
                userMenu.classList.add('md:hidden');
            }
        });
    }

    // Open/close the hamburger menu
    mobileMenuButton.addEventListener('click', function() {
        isMobileMenuOpen = !isMobileMenuOpen;
        // mobileMenu.classList.toggle('hidden', !isMobileMenuOpen);
        mobileMenu.classList.toggle('open', isMobileMenuOpen); 
        menuOpenIcon.classList.toggle('hidden', isMobileMenuOpen);
        menuCloseIcon.classList.toggle('hidden', !isMobileMenuOpen);
    });

    // Closes hamburger menu if clicked outside
    document.addEventListener('click', function(event) {
        if (isMobileMenuOpen && !mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
            isMobileMenuOpen = false;
            // mobileMenu.classList.add('hidden');
            mobileMenu.classList.remove('open');
            menuOpenIcon.classList.remove('hidden');
            menuCloseIcon.classList.add('hidden');
        }
    });
});