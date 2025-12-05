// Fade-in animation on scroll
document.addEventListener("DOMContentLoaded", function () {
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("fade-in-visible");
        }
      });
    },
    {
      threshold: 0.1,
    }
  );

  // Observe all elements with fade-in class
  document.querySelectorAll(".fade-in").forEach((el) => {
    observer.observe(el);
  });

  // Navbar Scroll Effect
  const navbar = document.querySelector(".navbar");

  function updateNavbar() {
    // Trigger after scrolling past most of the hero section
    if (window.scrollY > window.innerHeight - 100) {
      navbar.classList.add("scrolled");
    } else {
      navbar.classList.remove("scrolled");
    }
  }

  window.addEventListener("scroll", updateNavbar);
  updateNavbar(); // Check on load
});
