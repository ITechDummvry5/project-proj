</main>
<?php
// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']); // This will return 'forgot-password.php' if you're on that page
?>

<footer id="footer" class="footer <?php echo ($current_page === 'forgot-password.php') ? 'light-background' : 'dark-background'; ?>">

  <div class="container footer-top">
    <div class="row gy-4">
      <div class="col-lg-4 col-md-6 footer-about">

        <a href="index.html" class="logo d-flex align-items-center">
          <span class="sitename">BANADERO CALAMBA</span>
        </a>
        <div class="footer-contact pt-3">
          <p>Calamba, 4027 Laguna</p>
          <p class="mt-3"><strong>Phone:</strong> <span>+63 000 0000 000</span></p>
          <p><strong>Email:</strong> <span>banadero032019@gmail.com</span></p>
        </div>
        <div class="social-links d-flex mt-4">
          <a href=""><i class="bi bi-youtube"></i></a>
          <a href="https://www.facebook.com/barangay.banadero.96/about"><i class="bi bi-facebook"></i></a>
          <a href=""><i class="bi bi-instagram"></i></a>
          <a href=""><i class="bi bi-linkedin"></i></a>
        </div>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Useful Links</h4>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about-us.php">About us</a></li>
          <li><a href="#">Terms of service</a></li>
          <li><a href="#">Privacy policy</a></li>
        </ul>
      </div>

      <div class="col-lg-6 col-md-6 footer-links">
        <h4>Our Services</h4>
        <div class="row">
            <div class="col-3">
                <ul>
                    <li><a href="#">Barangay Certificate</a></li>
                    <li><a href="#">Barangay Clearance</a></li>
                    <li><a href="#">Barangay Indigency</a></li>
                    <li><a href="#">Barangay Residency</a></li>
                  
                </ul>
            </div>
            <div class="col-3">
                <ul>
                    <li><a href="#">PWD Certificate</a></li>
                    <li><a href="#">Solo Parent Certificate</a></li>
                    <li><a href="#">Franchising</a></li>
                    <li><a href="#">Business Clearance</a></li>
                   
                </ul>
            </div>
            <div class="col-3">
                <ul>
                    <li><a href="#">Building Clearance</a></li>
                    <li><a href="#">Cohabitation Letter</a></li>
                    <li><a href="#">Certification of Esc</a></li>
                    <li><a href="#">Certification of low Income</a></li>
                </ul>
            </div>
            <div class="col-3">
                <ul>
                    <li><a href="#">Certification of source of income</a></li>
                    <li><a href="#">Certification of legitimacy</a></li>
                    <li><a href="#">Certificate Of Good Moral</a></li>
                    <li><a href="#">Certification of Calamity</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    </div>
  </div>

  <div class="container copyright text-center mt-4">
    <p>© <span>Copyright</span> <strong class="px-1 sitename">Banadero</strong> <span>All Rights Reserved</span></p>
    <div class="credits">
      Designed by <a href="#">ItDummvry</a> Distributed By <a href="">ccc</a>
    </div>
  </div>

</footer>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.js"></script>
<script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

<!-- Main JS File -->
<script src="assets/js/main.js"></script>

</body>

</html>