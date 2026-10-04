<?php include('frontincludes/header.php');  
// <!--Date 5/10/2024-->

?>
<!-- Header -->
<header class="bg-dark py-5 site-header">
    <div class="container px-5" id="section_1">
        <div class="row gx-5 align-items-center justify-content-center">
            <div class="col-lg-8 col-xl-7 col-xxl-6">
                <div class="my-5 text-xl-start" data-aos="fade-right">
                    <h1 class="display-3 fw-bolder text-white mb-2">
                        <abbr title="capstone title">INSERT TITLE HERE</abbr>
                    </h1>
                    <p class="lead fw-normal text-white-50 mb-4">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Dolor explicabo voluptate vel nihil temporibus omnis alias iste hic deserunt aliquid labore totam voluptatibus dolorum, iure distinctio nostrum odit dicta repudiandae?
                    </p>
                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                        <abbr title="Browse Features">
                            <a class="btn btn-primary btn-lg px-4 me-sm-3" href="#features">Take the First Step</a>
                        </abbr>
                        <abbr title="LogIn if you have resident account">
                            <a class="btn btn-outline-light btn-lg px-4" href="resident-login">Log In</a>
                        </abbr>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-xxl-6 d-xl-block text-center" data-aos="zoom-out">
                <!-- Applying 'flow-animation' class to create a floating effect on the image -->
                <img class="img-fluid rounded-3 my-5 flow-animation" src="assets/image/UNSPLASH.jpg" alt="no image Available!" />
            </div>
        </div>
    </div>
</header>

<style>
    /* Floating Animation */
    @keyframes float {
        0% {
            transform: translateY(0);
            opacity: 1;
        }
        50% {
            transform: translateY(-10px);
            opacity: 0.7;
        }
        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .flow-animation {
        animation: float 3s ease-in-out infinite;
    }
</style>




      <!-- Features section-->
<section class="py-5 my-3" id="features"  data-aos="fade-up">
    <div class="container px-5 my-5">
        <div id="featuresCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">

                <div class="carousel-item active">
                    <div class="row gx-5 justify-content-center align-items-center">
                        <div class="col-lg-6">
                            <div class="row gx-5 row-cols-1 row-cols-md-1">
                                <div class="col mb-5 h-100 rounded-3 ">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-collection"></i></div>
                                    <h2 class="h5">System Admin</h2>
                                    <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe perferendis adipisci architecto ducimus facere, ea eligendi tempora aut et, id sunt natus dicta rerum consectetur exercitationem iure consequatur inventore ipsum?</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <img src="assets/image/undraw_feature_1.svg" alt="System Admin" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="row gx-5 justify-content-center align-items-center">
                        <div class="col-lg-6">
                            <div class="row gx-5 row-cols-1 row-cols-md-1">
                                <div class="col mb-5 h-100">
                                    <div class="feature bg-custom bg-gradient text-white rounded-3 mb-3"><i class="bi bi-building"></i></div>
                                    <h2 class="h5">Stockman</h2>
                                    <p class="mb-0">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum inventore numquam pariatur, deleniti illo voluptate labore et culpa ea adipisci exercitationem at, asperiores delectus atque rerum, quasi ipsa eveniet fugiat.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <img src="assets/image/undraw_feature_2.svg" alt="Stockman" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="row gx-5 justify-content-center align-items-center">
                        <div class="col-lg-6">
                            <div class="row gx-5 row-cols-1 row-cols-md-1">
                                <div class="col mb-5 mb-md-0 h-100" >
                                    <div class="feature bg-success bg-gradient text-white rounded-3 mb-3"><i class="bi bi-toggles2"></i></div>
                                    <h2 class="h5">Home Owner Officer</h2>
                                    <p class="mb-5">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nulla autem, debitis mollitia nisi illo minus tenetur odio molestiae minima consectetur nemo recusandae ab in dolore praesentium necessitatibus. Reprehenderit, quas porro?<br><br><br></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <img src="assets/image/undraw_feature_3.svg" alt="Home Owner Officer" class="img-fluid">
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="row gx-5 justify-content-center align-items-center ">
                        <div class="col-lg-6">
                            <div class="row gx-5 row-cols-1 row-cols-md-1">
                                <div class="col mb-3 h-100 rounded-3">
                                    <div class="feature bg-warning bg-gradient text-white rounded-3 mb-3"><i class="bi bi-toggles2"></i></div>
                                    <h2 class="h5">Resident</h2>
                                    <p class="mb-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas veritatis amet voluptate accusamus assumenda eaque pariatur eius, odio optio eos consequuntur perferendis dolorem temporibus distinctio, tenetur qui alias sint consequatur?</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <img src="assets/image/undraw_feature_4.svg" alt="Resident" class="img-fluid">
                        </div>
                    </div>
                </div>

            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#featuresCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#featuresCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

<!-- Dark Section -->
<section class="py-5 my-5 bg-dark text-light " >
    <div class="container px-4 my-5">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10 col-md-12" data-aos="flip-up">
                <h1 class="display-4 mb-4">House MODEL</h1>
                <p class="lead mb-5">
                "Discover INSERT TITLE HERE, a thoughtfully crafted subdivision that brings together quality, comfort, and environmental consciousness."
                </p>
            </div>
        </div>

        <!-- Row for Images and Descriptions -->
        <div class="row g-4">
            <!-- First Image and Description -->
            <div class="col-lg-6 d-flex flex-column align-items-center " data-aos="fade-right">
                <div class="fixed-image-container">
                    <img src="assets/image/model.jpg" class="img-fluid rounded mb-5 fixed-image" alt="Casa Cecilia Model" data-bs-toggle="collapse" data-bs-target="#description1" aria-expanded="false" aria-controls="description1">
                </div>
             
                <div class="collapse mt-3 w-100" id="description1">
                    <div class="card card-body bg-secondary text-light">
                        <p><strong>MODEL HOUSE NAME</strong></p>
                        <ul>
                            <li>Floor Area: 32.35 sq.m.</li>
                            <li>38.54 sq.m. (Corner Unit)</li>
                            <li>Min Lot Area: 80 sq.m.</li>
                            <li>Provision for 2 Bedrooms, 1 T&B</li>
                            <li>Provision for carport</li>
                            <li>Optional Fence and Gate</li>
                        </ul>
                    </div>
                </div>
            </div>

          <!-- Second Image and Description -->
<div class="col-lg-6 d-flex flex-column align-items-center" data-aos="fade-left">
    <div class="fixed-image-container">
        <!-- Make the image clickable to trigger collapse -->
        <img src="assets/image/model2.jpg" class="img-fluid rounded mb-5 fixed-image" alt="Casa Victoria Model" data-bs-toggle="collapse" data-bs-target="#description2" aria-expanded="false" aria-controls="description2">
    </div>
    <div class="collapse mt-3 w-100" id="description2">
        <div class="card card-body bg-secondary text-light">
            <p><strong>MODEL HOUSE NAME</strong></p>
            <ul>
                <li>Floor Area: 49.54 sq.m. (Inner/End Unit)</li>
                <li>48.54 sq.m. (Corner Unit)</li>
                <li>Minimum Lot Area: 60 sq.m.</li>
                <li>Provision for 2 Bedrooms, 1 T&B</li>
                <li>Provision for carport</li>
                <li>Optional Fence and Gate</li>
            </ul>
        </div>
    </div>
</div>


        </div>
    </div>
</section>






            <!-- Notice -->
            <section class="py-5 bg-light" >
    <div class="container px-4 my-5" data-aos="zoom-out">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12 text-center">
                <h1 class="display-4 mb-4 mt-5">Public Notice!</h1>
                <p class="lead">
                   Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae ipsum dicta earum debitis. Quam, maxime! Corrupti laudantium, facere vel impedit earum autem laboriosam doloremque numquam odio. Repellat aliquid debitis obcaecati.
                </p>
            </div>
        </div>
    </div>
</section>

   <section class="section-padding bg-dark text-white" id="section_2 " data-aos="zoom-in">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-12 col-12 text-center" >
                            <h1 class="mb-5 fw-bolder text-white">"Connect with us"</h1>
                        </div>

                        <div class="col-lg-5 col-12 mb-4 mb-lg-0 img-fluid rounded-3 my-0" id="map">
                            <img class="img-fluid" src="assets/image/undraw_connecting.svg" >

                        </div>

                        <div class="col-lg-3 col-md-6 col-12 mb-3 mb-lg- mb-md-0 ms-auto">
                            <h4 class="mb-3">Head Office</h4>

                            <p class="text-muted">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Facilis reiciendis, vel rerum, Makati City</p>

                            <hr>

                            <p class="d-flex align-items-center mb-1">
                                <span class="me-2">Phone</span>

                                <b class="site-footer-link">
                                    (00) xxxx-xxx-xxxx
                                </b>
                            </p>

                            <p class="d-flex align-items-center">
                                <span class="me-2">Email</span>

                                <b class="site-footer-link">
                                jokeinvesment@yahoo.com
                                </b>
                            </p>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12 mx-auto">
                            <h4 class="mb-3">Branch Office</h4>

                            <p class="text-muted">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Facilis reiciendis, vel rerum, Davao City</p>

                            <hr>

                            <p class="d-flex align-items-center mb-1">
                                <span class="me-2">Phone</span>
                                

                                <b  class="site-footer-link">
                                    xxxx-xxx-xxxx
                                </b>
                            </p>

                            <p class="d-flex align-items-center">
                                <span class="me-2">Email</span>

                                <b class="site-footer-link">
                                jokeinvesment@yahoo.com
                                </b>
                            </p>
                        </div>

                    </div>
                </div>
            </section>
        </main>       
        
<!-- footer-->
<footer class="site-footer section-padding " data-aos="fade-left">
    <div class="container">
        <div class="row">

            <div class="col-lg-3 col-12 mb-4 pb-2 display-6 text-muted">
                <a class="navbar-brand mb-2" href="#">
                     <span>Topic section</span>
                </a>
            </div>

            <div class="col-lg-3 col-md-4 col-6">
                <h6 class="site-footer-title mb-3">Useful Links</h6>
                <ul class="site-footer-links">
                <li class="site-footer-link-item ">
    <button class="site-footer-link btn btn-sm text-muted" onclick="location.href='#section_1';">Home</button>
</li>

                    
                    <li class="site-footer-link-item  ">
                    <button class="site-footer-link btn btn-sm  text-muted" onclick="location.href='login';">Login As Staff</button>

                    </li>
                    <li class="site-footer-link-item ">
                    <button class="site-footer-link btn btn-sm  text-muted" onclick="location.href='resident-login';">Login As Resident</button>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-4 col-6 mb-4 mb-lg-0">
                <h6 class="site-footer-title mb-3">Information</h6>
                <p class="text-white d-flex mb-1">
                    <a href="tel:09175851528" class="site-footer-link">
                     xxxx-xxx-xxxx
                    </a>
                </p>
                <p class="text-white d-flex">
                    <a href="mailto:jokeinvesment@yahoo.com" class="site-footer-link" style="max-width: 100%; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    jokeinvesment@yahoo.com
                    </a>
                </p>
                <!-- <p class="mt-lg-5 mt-4 text-muted">Copyright ©IMS 2024</p> -->
            </div>

            <div class="col-lg-3 col-md-4 col-12 mt-4 mt-lg-0 ms-auto">
                <div class="dropdown">
                    <button class="btn btn-primary  dropdown-toggle"  type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        English
                    </button>
                    <ul class="dropdown-menu">
                        <li><button class="dropdown-item" type="button">Thai</button></li>
                        <li><button class="dropdown-item" type="button">Myanmar</button></li>
                        <li><button class="dropdown-item" type="button">Arabic</button></li>
                    </ul>
                </div>
                <br>
                <p class="mt-lg-5 mt-4 text-muted">Copyright ©IMS 2024 </p>
            </div>

        </div>
    </div>
</footer>

<style>
    @media (max-width: 576px) {
        .site-footer-title {
            font-size: 1.2rem;
        }
        .site-footer-link {
            font-size: 0.9rem;
        }
        .site-footer-link {
            max-width: 100%; /* Adjust maximum width for smaller screens */
        }
    }
    /* Ensure both images are of the same height and width */
.fixed-image-container {
    display: flex;
    flex-direction: column;
    justify-content: stretch;
    align-items: stretch;
    height: 300px; /* Set fixed height */
}

.fixed-image {
    flex: 1;
    width: 100%;
    object-fit: cover; /* Ensure images cover the box without distortion */
}

</style>

    </body>
</html>



<?php  include('frontincludes/footer.php'); ?>    

