<?php include('partials-front/menu.php'); ?>

<section class="food-search text-center">
    <div class="container">

        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>

    </div>
</section>



<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php

        $sql = "SELECT * FROM tbl_food WHERE active='Yes'";
        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);

        if ($count > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $id = $row['id'];
                $title = $row['title'];
                $description = $row['description'];
                $price = $row['price'];
                $image_name = $row['image_name'];
        ?>

                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php
                        if ($image_name == "") {
                            echo "<div class='error'>Image not Available.</div>";
                        } else {
                        ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                        <?php
                        }
                        ?>

                    </div>

                    <div class="food-menu-desc">
                        <h4><?php echo $title; ?></h4>
                        <p class="food-price">&#2547;<?php echo $price; ?></p>
                        <p class="food-detail">
                            <?php echo $description; ?>
                        </p>
                        <br>

                        <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                    </div>

                    <div class="food-menu-reviews">

                        <?php
                        $sql_avg = "SELECT AVG(rating) as avg_rating, COUNT(*) as review_count 
                    FROM tbl_review WHERE food_id = $id";
                        $res_avg = mysqli_query($conn, $sql_avg);
                        $row_avg = mysqli_fetch_assoc($res_avg);
                        $avg_rating = round($row_avg['avg_rating'], 1);
                        $review_count = $row_avg['review_count'];
                        echo "<p><strong>Average Rating:</strong> " . ($avg_rating > 0 ? "$avg_rating/5 ($review_count reviews)" : "No reviews yet") . "</p>";
                        ?>


                        <form action="<?php echo SITEURL; ?>submit-review.php" method="POST" class="review-form">
                            <input type="hidden" name="food_id" value="<?php echo $id; ?>">
                            <input type="text" name="customer_name" placeholder="Your Name" class="input-responsive" required>
                            <select name="rating" class="input-responsive" required>
                                <option value="1">1 Star</option>
                                <option value="2">2 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="5">5 Stars</option>
                            </select>
                            <textarea name="comment" rows="3" placeholder="Your review (optional)" class="input-responsive"></textarea>
                            <input type="submit" name="submit" value="Submit Review" class="btn btn-primary">
                        </form>


                        <?php
                        $sql_reviews = "SELECT customer_name, rating, comment, review_date 
                        FROM tbl_review WHERE food_id = $id ORDER BY review_date DESC LIMIT 2";
                        $res_reviews = mysqli_query($conn, $sql_reviews);
                        while ($row_review = mysqli_fetch_assoc($res_reviews)) {
                            $review_name = htmlspecialchars($row_review['customer_name']);
                            $review_rating = $row_review['rating'];
                            $review_comment = htmlspecialchars($row_review['comment']);
                            $review_date = date("M d, Y", strtotime($row_review['review_date']));
                            echo "<div class='review'>";
                            echo "<p><strong>$review_name</strong> ($review_rating/5) - $review_date</p>";
                            if ($review_comment) echo "<p>$review_comment</p>";
                            echo "</div>";
                        }
                        ?>
                    </div>

                </div>

        <?php
            }
        } else {
            echo "<div class='error'>Food not found.</div>";
        }
        ?>





        <div class="clearfix"></div>



    </div>

</section>

<?php include('partials-front/footer.php'); ?>