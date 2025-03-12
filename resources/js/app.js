import './bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggleBtn = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const cards = document.querySelectorAll('.card'); // Select all cards
    const allContainer1 = document.querySelector('.all-container1');
    const headerBackground1 = document.querySelector('.header-background1');
    const cardContainer = document.querySelector('.card-container');

    sidebarToggleBtn.addEventListener('click', function () {
        sidebar.classList.toggle('open');

        // Toggle class for all cards
        cards.forEach(function(card) {
            card.classList.toggle('sidebar-open');
        });

        if (allContainer1) {
            allContainer1.classList.toggle('sidebar-open');
        }
        if (headerBackground1) {
            headerBackground1.classList.toggle('sidebar-open');
        }
        if (cardContainer) {
            cardContainer.classList.toggle('sidebar-open');
        }
    });

    document.addEventListener('click', function (event) {
        const isClickInsideSidebar = sidebar.contains(event.target);
        const isClickOnToggleBtn = sidebarToggleBtn.contains(event.target);

        if (!isClickInsideSidebar && !isClickOnToggleBtn) {
            sidebar.classList.remove('open');

            // Remove class from all cards
            cards.forEach(function(card) {
                card.classList.remove('sidebar-open');
            });

            if (allContainer1) {
                allContainer1.classList.remove('sidebar-open');
            }
            if (headerBackground1) {
                headerBackground1.classList.remove('sidebar-open');
            }
            if (cardContainer) {
                cardContainer.classList.remove('sidebar-open');
            }
        }
    });

    const phHoursElement = document.getElementById('phHours');
    const phMinutesElement = document.getElementById('phMinutes');
    const phSecondsElement = document.getElementById('phSeconds');
    const phAMPMElement = document.getElementById('phAMPM');
    const phDayElement = document.getElementById('phDay');
    const phFullDateElement = document.getElementById('phFullDate');

    function updatePhilippineTime() {
        const now = new Date();
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        const formattedDate = now.toLocaleDateString('en-US', options);
        const hours = now.getHours();
        const minutes = now.getMinutes();
        const seconds = now.getSeconds();
        const ampm = hours >= 12 ? 'PM' : 'AM';

        const displayHours = hours % 12 || 12;
        const displayMinutes = minutes < 10 ? '0' + minutes : minutes;
        const displaySeconds = seconds < 10 ? '0' + seconds : seconds;

        phHoursElement.textContent = displayHours;
        phMinutesElement.textContent = displayMinutes;
        phSecondsElement.textContent = displaySeconds;
        phAMPMElement.textContent = ampm;
        phDayElement.textContent = now.toLocaleDateString('en-US', { weekday: 'long' });
        phFullDateElement.textContent = formattedDate;
    }

    setInterval(updatePhilippineTime, 1000);
    updatePhilippineTime();
});

/// This code is for sidebar toggle hamburger

document.getElementById('sidebarToggle').addEventListener('click', function() {
    const sidebar = document.getElementById('sidebar');
    const hamburger = this.querySelector('.hamburger-icon');

    sidebar.classList.toggle('closed');
    this.classList.toggle('open');
    hamburger.classList.toggle('open');
});
