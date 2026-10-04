<!--Date 4/24/2024-->
 <!-- Scroll Top -->
 <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="fas fa-arrow-up "style="color: white;"></i>
</a>

<!-- Preloader -->
<div id="preloader"></div>

<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/font-awesome.min.js"></script>
<script src="vendor/aos/aos.js"></script>

<script>
  // Initialize AOS when the page is loaded
AOS.init({
  duration: 500, // Animation duration
  easing: 'ease-in-out', // Easing function
});

</script>

<script>
   /**
   * Scroll top button
   */
  let scrollTop = document.querySelector('.scroll-top');

  function toggleScrollTop() {
    if (scrollTop) {
      window.scrollY > 100 ? scrollTop.classList.add('active') : scrollTop.classList.remove('active');
    }
  }
  scrollTop.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  window.addEventListener('load', toggleScrollTop);
  document.addEventListener('scroll', toggleScrollTop);

 /**
   * Preloader
   */
  const preloader = document.querySelector('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove();
    });
  }

</script>





  </body>
</html>