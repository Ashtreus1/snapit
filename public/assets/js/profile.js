const tabLinks = document.querySelectorAll('.tab-link');
const sections = document.querySelectorAll('.tab-section');

tabLinks.forEach(link => {
link.addEventListener('click', () => {
    const target = link.dataset.tab;

    tabLinks.forEach(l => l.classList.remove('active-tab'));
    link.classList.add('active-tab');

    sections.forEach(section => {
    section.id === target
        ? section.classList.remove('hidden')
        : section.classList.add('hidden');
    });
});
});