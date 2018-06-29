<?php
$connect = mysqli_connect("localhost", "root", "", "test");
$output = '';
$order = $_POST["order"];
if($order == 'desc')
{
    $order = 'asc';
}
else
{
    $order = 'desc';
}
$query = "SELECT * FROM products ORDER BY ".$_POST["column_name"]." ".$_POST["order"]."";
$result = mysqli_query($connect, $query);
$output .= '  
 <table class="table table-bordered">  
    <thead class="text-primary">
      <tr>  
           <th class="column_sort" id="id" data-order="'.$order.'" href="#">ID</th>  
           <th class="column_sort" id="name" data-order="'.$order.'" href="#">Name</th>  
           <th class="column_sort" id="price" data-order="'.$order.'" href="#">Price</th>  
           <th class="column_sort" id="rating" data-order="'.$order.'" href="#">Rating</th>  
           <th scope="col">Действия</th>
       </tr>    
       </thead>
 ';
while($row = mysqli_fetch_array($result))
{
    $output .= '  
      <tr id="' . $row["id"] . '">  
           <td>' . $row["id"] . '</td>  
           <td>' . $row["name"] . '</td>  
           <td>' . $row["price"] . '</td>  
           <td>' . $row["rating"] . '</td>  
           <td data-id=' . $row["id"] . '><a href=\'\' title=\'Изменить\' class="edit-item" data-toggle=\'modal\' data-target="#edit-item"><i class="material-icons">&#xe3c9;</i></a>
                        <a href=\'\' class="remove-item" title=\'Удалить\' data-toggle=\'modal\'><i class="material-icons">&#xe872;</i></a>
                    </td>
      </tr>  
      ';
}
$output .= '</table>';
echo $output;
?>
<button type="button" id="addproduct" class="btn btn-primary" data-target="#create-item" data-toggle="modal">
    Добавить товар
</button>

