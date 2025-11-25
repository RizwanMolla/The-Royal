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
});
