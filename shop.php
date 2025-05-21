<?php # DISPLAY COMPLETE PRODUCTS PAGE.

# Access session.
session_start() ;

# Redirect if not logged in.
if ( !isset( $_SESSION[ 'user_id' ] ) ) { require ( 'login_tools.php' ) ; load() ; }

# Set page title and display header section.
$page_title = 'Shop' ;
include ( 'includes/header.html' ) ;

# Open database connection.
require ( 'connect_db.php' ) ;

# Retrieve items from 'shop' database table.
$q = "SELECT * FROM shop" ;

if (isset($_GET['show']))
{
    extract($_GET);
    if ($show=="vegetarian") $q="SELECT * FROM shop WHERE vegetarian=1";
    if ($show=="fish") $q="SELECT * FROM shop WHERE hasfish=1";
    if ($show=="meat") $q="SELECT * FROM shop WHERE hasmeat=1";
}

$r = mysqli_query( $dbc, $q ) ;
if ( mysqli_num_rows( $r ) > 0 )
{
  # Display body section.

  while ( $row = mysqli_fetch_array( $r, MYSQLI_ASSOC ))
  {
   extract($row)  ;
    //echo  "$item_name <br> $item_desc <br> <img src='$restaurant/$item_img'>
    //        <a href='added.php?id=$item_id'>Add To Cart</a><hr/>";
      echo "<div class='col-md-4'><div class='thumbnail'>";
      echo "<a href='added.php?id=$item_id'>";  //change to add to cart
      echo "<img src='$restaurant/$item_img' alt='Lights' style='width:100%'>";
      echo "<div class='caption'><p>$item_name <br></p></div>";
      echo "</a></div></div>";
  }

  
  # Close database connection.
  mysqli_close( $dbc ) ; 
}
# Or display message.
else { echo '<p>There are currently no items in this shop.</p>' ; }

# Create navigation links.
echo '<p><a href="cart.php">View Cart</a> | <a href="forum.php">Forum</a> | <a href="home.php">Home</a> | <a href="goodbye.php">Logout</a></p>' ;

# Display footer section.
include ( 'includes/footer.html' ) ;

?>