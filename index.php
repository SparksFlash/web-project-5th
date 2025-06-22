<?php include('partials-front/menu.php'); ?>



<?php 
    if (isset($_SESSION['review'])) {
        echo $_SESSION['review'];
        unset($_SESSION['review']);
    }
    if (isset($_SESSION['order'])) {
        echo $_SESSION['order'];
        unset($_SESSION['order']);
    }
?>



<section class="food-search text-center">
    <div class="container">
        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>

<?php 

    if(isset($_SESSION['order']))
    {
        echo $_SESSION['order'];
        unset($_SESSION['order']);
    }
?>

<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>
        <?php 
            $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            if($count>0)
            {
                while($row=mysqli_fetch_assoc($res))
                {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    ?>
                    <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                        <div class="box-3 float-container">
                            <?php 
                                if($image_name=="")
                                {
                                    echo "<div class='error'>Image not Available</div>";
                                }
                                else
                                {
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                    <?php
                                }
                            ?>
                            <h3 class="float-text text-white"><?php echo $title; ?></h3>
                        </div>
                    </a>
                    <?php
                }
            }
            else
            {
                echo "<div class='error'>Category not Added.</div>";
            }
        ?>
        <div class="clearfix"></div>
    </div>
</section>


<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>




        <div class="swiper-container mySwiper">
            <div class="swiper-wrapper">
                <?php 
                $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";
                $res2 = mysqli_query($conn, $sql2);
                $count2 = mysqli_num_rows($res2);
                if($count2>0)
                {
                    while($row=mysqli_fetch_assoc($res2))
                    {
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        ?>
                        <div class="swiper-slide">
                            <div class="food-menu-box">
                                <div class="food-menu-img">
                                    <?php 
                                        if($image_name=="")
                                        {
                                            echo "<div class='error'>Image not available.</div>";
                                        }
                                        else
                                        {
                                            ?>
                                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                                            <?php
                                        }
                                    ?>
                                </div>
                                <div class="food-menu-desc">
                                    <h4><?php echo $title; ?></h4>
                                    <p class="food-price">&#2547;<?php echo $price; ?></p>
                                    <p class="food-detail"><?php echo $description; ?></p>
                                    <br>
                                    <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                                    
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                else
                {
                    echo "<div class='error'>Food not available.</div>";
                }
                ?>
            </div>

            <div class="swiper-pagination"></div>

            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>

        <div class="clearfix"></div>

        <p class="text-center">
            <a href="#">See All Foods</a>
        </p>
    </div>
</section>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    var swiper = new Swiper('.mySwiper', {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',
        loop: true,
        coverflowEffect: {
            rotate: 50,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: true,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                coverflowEffect: {
                    rotate: 30,
                    depth: 80,
                },
            },
            768: {
                slidesPerView: 2,
                coverflowEffect: {
                    rotate: 40,
                    depth: 90,
                },
            },
            1024: {
                slidesPerView: 3,
            },
        },
    });
</script>

<?php include('partials-front/footer.php'); ?>