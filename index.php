<?php
//index.php
$connect = mysqli_connect("localhost", "root", "", "test");

?>
<?php



if ($_GET['order'] == 'asc') {
    $table_sort = 'desc';
}
else {
    $table_sort = 'asc';
}

$table_sort = isset($_GET['order'])?$_GET['order']:null;
if( $table_sort == '')
{
    $table_sort = 'ASC';
}

$sort = isset($_GET['sort'])?$_GET['sort']:null;
if($sort == '')
{
    $sort = 'id';
}

$query = "SELECT * FROM `products` ORDER BY $sort $table_sort";
$result = mysqli_query($connect, $query);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Тестовое задание</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
</head>
<body>
<style>.column_sort{cursor:pointer}</style>
<div id='loadingmessage' style='display:none'>
    <img src='img/ajax-loader.gif'/>
</div>
<div class="container">
    <!-- Добавление нового товара -->
    <div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Создание нового товра</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
               </div>
                <div class="modal-body">
                    <form  data-toggle="validator" method="POST">
                        <div class="form-group">
                            <label class="control-label" for="title">Name:</label>
                            <input type="text" name="name" class="form-control" data-error="Введите name." required />
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Price:</label>
                            <textarea name="price" class="form-control" data-error="Введите price." required></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="title">Rating:</label>
                            <textarea name="rating" class="form-control" data-error="Введите rating." required></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary crud-submit">Отправить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



<!-- Модальное окно редактирования -->
<div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Редактировать товар</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <form data-toggle="validator" method="put">
                    <input type="hidden" name="id" class="edit-id">
                    <div class="form-group">
                        <label class="control-label" for="title">Name:</label>
                        <input type="text" name="name" class="form-control" data-error="Введите name." required />
                       <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="title">Price:</label>
                        <textarea name="price" class="form-control" data-error="Введите price." required></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="title">Rating:</label>
                        <textarea name="rating" class="form-control" data-error="Введите rating." required></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary crud-submit-edit">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Вывод товаров -->

    <h3 class="text-center">Список товаров</h3><br />
    <div id="employee_table">
        <table class="table table-bordered">
            <thead class="text-primary">
            <tr>
                <th scope="col" class="column_sort" id="id" data-order="desc" href="#">ID</th>
                <th scope="col" class="column_sort" id="name" data-order="desc" href="#">Name</th>
                <th scope="col" class="column_sort" id="price" data-order="desc" href="#">Price</th>
                <th scope="col" class="column_sort" id="rating" data-order="desc" href="#">Rating</th>
                <th scope="col">Действия</th>
            </tr>
            </thead>
            <?php
            while($row = mysqli_fetch_array($result))
            {
                ?>
                <tr>

                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["name"]; ?></td>
                    <td><?php echo $row["price"]; ?></td>
                    <td><?php echo $row["rating"]; ?></td>
                    <td data-id="<?php echo $row["id"]; ?>"><a href='' class="edit-item" title='Изменить' data-toggle='modal' data-target="#edit-item"><i class="material-icons">&#xe3c9;</i></a>

                        <a href='' class="remove-item" title='Удалить'  data-toggle='modal'><i class="material-icons">&#xe872;</i></a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <button type="button" id="addproduct" class="btn btn-primary" data-target="#create-item" data-toggle="modal">
            Добавить товар
        </button>
    </div>
</div>
<script src="js/js.js"></script>
</body>
</html>

