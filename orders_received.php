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
$q = "SELECT 
            shop.item_name, shop.item_img, shop.restaurant, orders.order_id, users.first_name, users.last_name, orders.order_date, order_contents.quantity, shop.item_price, orders.total
FROM
            orders,order_contents,users,shop
WHERE 
            users.user_id=orders.user_id
AND
            orders.order_id=order_contents.order_id
AND
            order_contents.item_id=shop.item_id
ORDER BY 
			orders.order_id" ;

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

  echo "<table>";
  $prevOrderId = -1;
  while ( $row = mysqli_fetch_array( $r, MYSQLI_ASSOC ))
  {
   extract($row)  ;
   if ($order_id != $prevOrderId) echo "<div class='col-md-12'> <hr/> </div>";
    //echo  "$item_name <br> $item_desc <br> <img src='$restaurant/$item_img'>
    //        <a href='added.php?id=$item_id'>Add To Cart</a><hr/>";
      echo "<div class='col-md-3'> $item_name</div> <div class='col-md-3'> $restaurant </div>
            <div class='col-md-3'> $item_price </div> <div class='col-md-3'> $order_id </div>";
      //echo "<tr><td>$item_name</td> <td>$restaurant</td> <td>£$item_price</td> <td>$order_id</td></tr>";
      $prevOrderId = $order_id;
  }
    //echo "</table>";
  echo "</div>";

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