
<!-- ==========================
     CLIENT LOGOS SECTION
     ========================== -->
<section id="client-holder" data-aos="fade-up">
    <div class="container">
        <div class="row">
            <div class="inner-content">
                <div class="logo-wrap">
                    <div class="grid">
                        <!-- Client logos -->
                        <a href="#"><img src="images/client-image1.png" alt="client"></a>
                        <a href="#"><img src="images/client-image2.png" alt="client"></a>
                        <a href="#"><img src="images/client-image3.png" alt="client"></a>
                        <a href="#"><img src="images/client-image4.png" alt="client"></a>
                        <a href="#"><img src="images/client-image5.png" alt="client"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================
     FEATURED BOOKS / CRUD DISPLAY
     ========================== -->
<section id="featured-books" class="leaf-pattern-overlay py-5 my-5">
    <div class="corner-pattern-overlay"></div>
    <div class="container">

        <!-- Section header -->
        <div class="row">
            <div class="col-md-12">
                <div class="section-header align-center">
                    <div class="title"><span>C.R.U.D</span></div>
                    <h2 class="section-title">Featured Books</h2>
                </div>
            </div>
        </div>

        <!-- Featured Books Grid -->
        <div class="row">
            <?php
            $featuredBooksQuery = mysqli_query($con, "SELECT b.*, a.name AS author_name 
                                                     FROM books b
                                                     LEFT JOIN authors a ON b.author_id = a.id
                                                     WHERE b.featured = 1
                                                     ORDER BY b.id DESC
                                                     LIMIT 4");
            if ($featuredBooksQuery && mysqli_num_rows($featuredBooksQuery) > 0):
                while ($book = mysqli_fetch_assoc($featuredBooksQuery)):
                    $cover = !empty($book['cover_image']) ? str_replace('../', '', $book['cover_image']) : 'images/default-cover.png ';
            ?>
            <div class="col-md-3">
                <div class="product-item">
                    <figure class="products-thumb product-style">
                        <img src="<?php echo htmlspecialchars($cover); ?>"
                             alt="<?php echo htmlspecialchars($book['title']); ?>"
                             class="product-item book-cover">
                        <!-- Edit book button triggers Edit Book Modal -->
                        <button type="button"
                                class="btn btn-primary mt-2 w-100 edit-book-btn"
                                data-id="<?php echo $book['id']; ?>"
                                data-title="<?php echo htmlspecialchars($book['title']); ?>"
                                data-author="<?php echo htmlspecialchars($book['author_name']); ?>"
                                data-date="<?php echo $book['date_published']; ?>"
                                data-description="<?php echo htmlspecialchars($book['description']); ?>"
                                data-genre="<?php echo $book['genre']; ?>"
                                data-featured="<?php echo $book['featured']; ?>">
                            Edit Book
                        </button>
                    </figure>
                    <figcaption>
                        <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                        <span><?php echo htmlspecialchars($book['author_name']); ?></span>
                        <?php if (!empty($book['price'])): ?>
                            <div class="item-price">$ <?php echo htmlspecialchars($book['price']); ?></div>
                        <?php endif; ?>
                    </figcaption>
                </div>
            </div>
            <?php
                endwhile;
            else:
                echo "<p class='text-center text-primary'>No featured books available.</p>";
            endif;
            ?>
        </div>

        <!-- View All Products Button -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="btn-wrap align-right">
                    <!-- <a href="#" class="btn-accent-arrow">View all products <i class="icon icon-ns-arrow-right"></i></a> -->
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ==========================
     EDIT BOOK MODAL
     ========================== -->
<div class="modal fade" id="editBookModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fw-bold text-primary text-center w-100">Edit Book</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editBookForm" action="custom/bookCode.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="book_id" id="edit_book_id">

                    <div class="row gx-3">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <label class="form-label">Book Title</label>
                            <input type="text" name="title" id="edit_title" class="form-control" required>

                            <label class="form-label mt-3">Author</label>
                            <select name="author" id="edit_author" class="form-select" required>
                                <option value="" disabled>Select Author</option>
                                <?php
                                $authors = getAuthors();
                                if ($authors && mysqli_num_rows($authors) > 0) {
                                    while ($row = mysqli_fetch_assoc($authors)) {
                                        echo '<option value="'.htmlspecialchars($row['name']).'">'.htmlspecialchars($row['name']).'</option>';
                                    }
                                }
                                ?>
                            </select>

                            <label class="form-label mt-3">Date Published</label>
                            <input type="date" name="date_published" id="edit_date_published" class="form-control" required>

                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" name="featured" value="1" id="edit_featured">
                                <label class="form-check-label fw-semibold" for="edit_featured">Feature this book</label>
                            </div>

                            <label class="form-label mt-3">Cover Image</label>
                            <input type="file" name="cover_image" class="form-control">

                            <label class="form-label mt-3">PDF File</label>
                            <input type="file" name="pdf_file" class="form-control">
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="edit_description" class="form-control" rows="7" required></textarea>

                            <label class="form-label mt-3">Genre</label>
                            <select name="genre" id="edit_genre" class="form-select" required>
                                <option value="" disabled>Select Genre</option>
                                <option value="Business">Business</option>
                                <option value="Technology">Technology</option>
                                <option value="Romantic">Romantic</option>
                                <option value="Adventure">Adventure</option>
                                <option value="Fictional">Fictional</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-danger btn-lg" id="deleteBookBtn">Delete Book</button>
                        <button type="submit" name="update_book" class="btn btn-success btn-lg">Update Book</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ==========================
     BEST-SELLING / ADD BOOK SECTION
     ========================== -->


<section id="best-selling" class="leaf-pattern-overlay">
    <div class="corner-pattern-overlay"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="row">
                    <!-- LEFT PART – IMAGE -->
                    <div class="col-md-6">
                        <figure class="products-thumb">
                            <img src="images/library.png" alt="book" class="single-image">
                        </figure>
                    </div>

                    <!-- RIGHT PART – BUTTON + H1 -->
                    <div class="col-md-6 d-flex flex-column justify-content-start">
                        <h1 class="mb-5">Records Your Own Books</h1>
                        <div class="btn-wrap mt-5">
                            <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#bookModal">
                                Add Your Books in E-Library <i class="icon icon-ns-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ==========================
                     MODAL: ADD NEW BOOK
                     ========================== -->
                <div class="modal fade" id="bookModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h2 class="modal-title fw-bold text-primary text-center w-100">
                                    Add Your Book Now, Aspiring Author!
                                </h2>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <form action="custom/bookCode.php" method="POST" enctype="multipart/form-data">

                                    <div class="row gx-3">
                                        <!-- LEFT COLUMN -->
                                        <div class="col-md-6">
                                            <label class="form-label">Book Title</label>
                                            <input type="text" name="title" class="form-control" required>

                                            <label class="form-label mt-3">Author</label>
                                            <select name="author" class="form-select" required>
                                                <option value="" disabled selected>Select Author</option>
                                                <?php
                                                $authors = getAuthors();
                                                if ($authors && mysqli_num_rows($authors) > 0) {
                                                    while ($row = mysqli_fetch_assoc($authors)) {
                                                        echo '<option value="' . htmlspecialchars($row['name']) . '">' . htmlspecialchars($row['name']) . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>

                                            <label class="form-label mt-3">Date Published</label>
                                            <input type="date" name="date_published" class="form-control" required>

                                            <label class="form-label mt-3">Cover Image</label>
                                            <input type="file" name="cover_image" accept="image/*" class="form-control" required>

                                            <div class="form-check form-switch mt-4">
                                                <input class="form-check-input" type="checkbox" name="featured" value="1" id="featureBookSwitch">
                                                <label class="form-check-label fw-semibold" for="featureBookSwitch">
                                                    Feature this book
                                                </label>
                                            </div>
                                        </div>

                                        <!-- RIGHT COLUMN -->
                                        <div class="col-md-6">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" class="form-control" rows="5" required></textarea>

                                            <label class="form-label mt-3">Genre</label>
                                            <select name="genre" class="form-select" required>
                                                <option value="" disabled selected>Select Genre</option>
                                                <option value="Business">Business</option>
                                                <option value="Technology">Technology</option>
                                                <option value="Romantic">Romantic</option>
                                                <option value="Adventure">Adventure</option>
                                                <option value="Fictional">Fictional</option>
                                            </select>

                                            <label class="form-label mt-3">Book File (PDF)</label>
                                            <input type="file" name="book_file" accept=".pdf" class="form-control" required>
                                        </div>

                                        <div class="mt-4 text-end">
                                            <button type="submit" name="add_book" class="btn btn-success btn-lg">Save Book</button>
                                        </div>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- END MODAL -->

            </div>
        </div>
    </div>
</section>



<!-- =======================
     POPULAR BOOKS SECTION (DYNAMIC)
======================= -->
<section id="popular-books" class="bookshelf py-5 my-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <!-- Section Header -->
                <div class="section-header align-center">
                    <div class="title">
                        <span>Some quality items</span>
                    </div>
                    <h2 class="section-title">Popular Books</h2>
                </div>

                <!-- Genre Tabs -->
                <?php
                $genres = ['All Genre', 'Business', 'Technology', 'Romantic', 'Adventure', 'Fictional'];
                ?>
                <ul class="tabs">
                    <?php foreach ($genres as $index => $genre): ?>
                        <li data-tab-target="#<?php echo strtolower(str_replace(' ', '-', $genre)); ?>"
                            class="tab <?php echo $index === 0 ? 'active' : ''; ?>">
                            <?php echo $genre; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Tab Contents -->
                <div class="tab-content">

                    <?php foreach ($genres as $index => $genre): ?>
                        <div id="<?php echo strtolower(str_replace(' ', '-', $genre)); ?>" data-tab-content
                             class="<?php echo $index === 0 ? 'active' : ''; ?>">
                            <div class="row">

                                <?php
                                if ($genre === 'All Genre') {
                                    $booksQuery = mysqli_query($con, "SELECT b.*, a.name AS author_name 
                                                                     FROM books b
                                                                     LEFT JOIN authors a ON b.author_id = a.id
                                                                     ORDER BY b.id DESC
                                                                     LIMIT 8");
                                } else {
                                    $booksQuery = mysqli_query($con, "SELECT b.*, a.name AS author_name 
                                                                     FROM books b
                                                                     LEFT JOIN authors a ON b.author_id = a.id
                                                                     WHERE b.genre = '".mysqli_real_escape_string($con, $genre)."'
                                                                     ORDER BY b.id DESC
                                                                     LIMIT 8");
                                }

                                if ($booksQuery && mysqli_num_rows($booksQuery) > 0):
                                    while ($book = mysqli_fetch_assoc($booksQuery)):
                                        $cover = !empty($book['cover_image']) ? str_replace('../', '', $book['cover_image']) : 'images/default-cover.png';
                                ?>

                                <div class="col-md-3">
                                    <div class="product-item">
                                        <figure class="product-style">
                                            <img src="<?php echo htmlspecialchars($cover); ?>"
                                                 alt="<?php echo htmlspecialchars($book['title']); ?>"
                                                 class="product-item">
                                  <?php if (!empty($book['book_file'])): ?>
    <a href="<?php echo htmlspecialchars(str_replace('../', '', $book['book_file'])); ?>" 
       target="_blank" class="btn btn-primary w-100">
        View Book
    </a>
<?php else: ?>
    <span class="text-muted">PDF not available</span>
<?php endif; ?>


                                        </figure>
                                        <figcaption>
                                            <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                                            <span><?php echo htmlspecialchars($book['author_name']); ?></span>
                                            <?php if (!empty($book['price'])): ?>
                                                <div class="item-price">$ <?php echo htmlspecialchars($book['price']); ?></div>
                                            <?php endif; ?>
                                        </figcaption>
                                    </div>
                                </div>

                                <?php
                                    endwhile;
                                else:
                                    echo "<p class='text-center text-primary'>No books available in this genre.</p>";
                                endif;
                                ?>

                            </div>
                        </div>
                    <?php endforeach; ?>

                </div> <!-- End of Tab Contents -->

            </div> <!-- End of col-md-12 -->
        </div>
    </div>
</section>


<!-- =======================
     QUOTE OF THE DAY SECTION
======================= -->
<section id="quotation" class="align-center pb-5 mb-5">
    <div class="inner-content">
        <h2 class="section-title divider">Quote of the day</h2>
        <blockquote data-aos="fade-up">
            <q>“The more that you read, the more things you will know. The more that you learn, the more places you’ll go.”</q>
            <div class="author-name">Dr. Seuss</div>
        </blockquote>
    </div>
</section>

	

	





	<footer id="footer">
		<div class="container">
			<div class="row">

				<div class="col-md-4">

					<div class="footer-item">
						<div class="company-brand">
							<img src="images/main-logo.png" alt="logo" class="footer-logo">
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sagittis sed ptibus liberolectus
								nonet psryroin. Amet sed lorem posuere sit iaculis amet, ac urna. Adipiscing fames
								semper erat ac in suspendisse iaculis.</p>
						</div>
					</div>

				</div>

				<div class="col-md-2">

					<div class="footer-menu">
						<h5>About Us</h5>
						<ul class="menu-list">
							<li class="menu-item">
								<a href="#">vision</a>
							</li>
							<li class="menu-item">
								<a href="#">articles </a>
							</li>
							<li class="menu-item">
								<a href="#">careers</a>
							</li>
							<li class="menu-item">
								<a href="#">service terms</a>
							</li>
							<li class="menu-item">
								<a href="#">donate</a>
							</li>
						</ul>
					</div>

				</div>
				<div class="col-md-2">

					<div class="footer-menu">
						<h5>Discover</h5>
						<ul class="menu-list">
							<li class="menu-item">
								<a href="#">Home</a>
							</li>
							<li class="menu-item">
								<a href="#">Books</a>
							</li>
							<li class="menu-item">
								<a href="#">Authors</a>
							</li>
							<li class="menu-item">
								<a href="#">Subjects</a>
							</li>
							<li class="menu-item">
								<a href="#">Advanced Search</a>
							</li>
						</ul>
					</div>

				</div>
				<div class="col-md-2">

					<div class="footer-menu">
						<h5>My account</h5>
						<ul class="menu-list">
							<li class="menu-item">
								<a href="#">Sign In</a>
							</li>
							<li class="menu-item">
								<a href="#">View Cart</a>
							</li>
							<li class="menu-item">
								<a href="#">My Wishtlist</a>
							</li>
							<li class="menu-item">
								<a href="#">Track My Order</a>
							</li>
						</ul>
					</div>

				</div>
				<div class="col-md-2">

					<div class="footer-menu">
						<h5>Help</h5>
						<ul class="menu-list">
							<li class="menu-item">
								<a href="#">Help center</a>
							</li>
							<li class="menu-item">
								<a href="#">Report a problem</a>
							</li>
							<li class="menu-item">
								<a href="#">Suggesting edits</a>
							</li>
							<li class="menu-item">
								<a href="#">Contact us</a>
							</li>
						</ul>
					</div>

				</div>

			</div>
			<!-- / row -->

		</div>
	</footer>

	<div id="footer-bottom">
		<div class="container">
			<div class="row">
				<div class="col-md-12">

					<div class="copyright">
						<div class="row">

							<div class="col-md-6">
								<p>© 2022 All rights reserved. Free HTML Template by <a
										href="https://www.templatesjungle.com/" target="_blank">TemplatesJungle</a></p>
							</div>

							<div class="col-md-6">
								<div class="social-links align-right">
									<ul>
										<li>
											<a href="#"><i class="icon icon-facebook"></i></a>
										</li>
										<li>
											<a href="#"><i class="icon icon-twitter"></i></a>
										</li>
										<li>
											<a href="#"><i class="icon icon-youtube-play"></i></a>
										</li>
										<li>
											<a href="#"><i class="icon icon-behance-square"></i></a>
										</li>
									</ul>
								</div>
							</div>

						</div>
					</div><!--grid-->

				</div><!--footer-bottom-content-->