// Dark mode: apply saved preference before page render
(function () {
    const theme = localStorage.getItem('theme') || 'dark';
    document.documentElement.classList.toggle('dark', theme === 'dark');
})();

// Alpine.js dark mode toggle available globally
document.addEventListener('alpine:init', () => {
    Alpine.store('theme', {
        dark: localStorage.getItem('theme') !== 'light',
        toggle() {
            this.dark = !this.dark;
            const theme = this.dark ? 'dark' : 'light';
            localStorage.setItem('theme', theme);
            document.documentElement.classList.toggle('dark', this.dark);
        },
        init() {
            const theme = localStorage.getItem('theme') || 'dark';
            this.dark = theme === 'dark';
            document.documentElement.classList.toggle('dark', this.dark);
        }
    });
});
