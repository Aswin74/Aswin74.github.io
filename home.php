<?php
$conn = new mysqli("localhost", "root", "", "hostex");
$sql = "SELECT * FROM hostel_list";
$result = mysqli_query($conn, $sql);

?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--Linking bootstra v5.3-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!--icon pack: font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--common.css should only contain common styles for all pages-->
    <link rel="stylesheet" href="css/common.css" />
    <link rel="stylesheet" href="css/home.css" />
    <!--Add/edit the home page css in home.css-->

    <!--title bar-->
    <link rel="icon" href="./img/logo/logo.png" />
    <title>HostEx | Home</title>
</head>

<body>

    <!--Navbar-->
    <?php include("./php/navbar.php") ?>

    <!--Body-->
    <!-- Search Bar -->
    <form method="GET" class="container-fluid home-search">
        <div class="search">
            <input name="search" type="text" value="<?php if (isset($_GET['search'])) {
                                                        echo ($_GET['search']);
                                                    } ?>" placeholder="Search Hostels.." autocomplete="off" />

            <button class="search-btn">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
    </form>

    <!--Cards-->
    <div class="container">
        <div class="cards-group">

            <!--Card: Searching-->
            <?php
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
                $query = "SELECT * FROM hostel_list WHERE CONCAT(hname, price,location,description) LIKE '%$search%'";
                $query_run = mysqli_query($conn, $query);

                if (mysqli_num_rows($query_run) > 0) { //Successfull Search

                    while ($row = mysqli_fetch_assoc($query_run)) {
            ?>

                        <!-- Successful Card Search --->

                        <div class="card">
                            <div class="glassback"></div>
                            <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/25/24/cb/33/8-bed-mixed-gender-dorm.jpg?w=300&h=-1&s=1" />
                            <div class="card-content">
                                <div class="card-price">₹.<?php echo $row["price"] ?>/<span style="font-size:60%">month</span> </div>
                                <div class="card-name"><?php echo $row["hname"] ?></div>
                                <div class="card-rating">
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-solid fa-star"></i>
                                    <i class="fa-regular fa-star"></i>
                                    <i class="fa-regular fa-star"></i>
                                </div>
                                <div class="card-location tag"><?php echo $row["location"] ?></div>
                            </div>
                        </div>
                    <?php
                    }
                } else {
                    echo "<h1 class='text-pink'>No results</h1>"; //Unsuccessful search
                }
            } elseif (!isset($_GET['search']) || empty($_GET['search'])) {
                while ($row = mysqli_fetch_assoc($result)) { //if not search | empty search array
                    ?>

                    <!-- Home Default Cards -->

                    <div class="card">
                        <div class="glassback"></div>
                        <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/25/24/cb/33/8-bed-mixed-gender-dorm.jpg?w=300&h=-1&s=1" />
                        <div class="card-content">
                            <div class="card-price">₹.<?php echo $row["price"] ?>/<span style="font-size:60%">month</span> </div>
                            <div class="card-name"><?php echo $row["hname"] ?></div>
                            <div class="card-rating">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                                <i class="fa-regular fa-star"></i>
                            </div>
                            <div class="card-location tag"><?php echo $row["location"] ?></div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>

    <!-- Adding Hostel Privillege -->

    <?php  //checks if user is logged in && the username is eren
    if (isset($_SESSION['username']) && $_SESSION['username'] == 'eren') {
    ?>

        <!-- Button trigger modal -->
        <div  data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fa-solid fa-circle-plus add-btn"></i>
        </div>

        <!-- Modal -->
        <form class="modal fade" id="exampleModal" action="./php/addHostel.php" method="post" autocomplete="off"
            tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title" id="exampleModalLabel">Add New Hostel</h1>
                        <i class="btn fa fa-x text-pinker" data-bs-dismiss="modal" aria-label="Close"></i>
                    </div>
                    <div class="modal-body">
                        <input type="text" class="" name="hname" placeholder="Hostel Name" required/>
                        <input type="text" class="" name="location" placeholder="Place Name" required/>
                        <input type="number" class="" name="price" placeholder="Rent per month" required/>
                        <input type="text" class="" name="hphone" placeholder="Phone number" required/>
                        <input type="text" class="" name="haddress" placeholder="Full Address" required/>
                        <input type="text" class="" name="description" placeholder="Description" required/>
                        <input type="file" class="" name="photo" accept="image/*"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn">Add</button>
                    </div>
                </div>
            </div>
        </form>

    <?php } ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="./js/events.js"></script>
</body>

</html>