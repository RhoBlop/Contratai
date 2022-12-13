const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        console.log(entry)
        if (entry.isIntersecting) {
            entry.target.classList.add('show');
        }
    });
}, {
    threshold: 0.2
});

const hiddenElements = document.querySelectorAll('.hidden'); 
hiddenElements.forEach((el) => observer.observe(el));