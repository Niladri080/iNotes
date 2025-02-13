<?php
  $conn=mysqli_connect("localhost","root","","iNotes");
  $alert=false;
  $deletebutton=false;
  $update=false;
  if (!$conn){
      die("Database not connected.");
  }
  if (isset($_GET['delete'])){
    $sno=$_GET['delete'];
    $sql="DELETE FROM `notes` WHERE `sno`=$sno";
    $result=mysqli_query($conn,$sql);
    if ($result){
      $deletebutton=true;
    }
  }
  if ($_SERVER["REQUEST_METHOD"]=="POST"){
    if (isset($_POST['snoEdit'])){
      $sno=$_POST['snoEdit'];
      $title=$_POST['titleedit'];
      $description=$_POST['descriptionedit'];
      $sql="UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sno` = '$sno'
      ";
      $result=mysqli_query($conn,$sql);
      if ($result){
        $update=true;
      }
    }
    else{
      $title=$_POST['title'];
    $description=$_POST['description'];
    $sql="INSERT INTO `notes` (`title`, `description`, `tstamp`) VALUES ('$title','$description', current_timestamp())";
    $result=mysqli_query($conn,$sql);
    if ($result){
      $alert=true;
    }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">    
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>iNotes-CRUD</title>
  <link rel="shortcut icon" href="logo.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
  <script>
  $(document).ready(function () {
    $('#myTable').DataTable(); 
  });
</script>


</head>
<body>
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit Modal
</button> -->
<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit Record</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="index.php" method="post">
      <div class="modal-body">
          <input type="hidden" name="snoEdit" id="snoEdit">
          <div class="mb-3">
            <label for="titleedit" class="form-label">Note title</label>
            <input type="text" class="form-control" id="titledit"  name="titleedit" aria-describedby="emailHelp">
          </div>
          <div class="mb-3">
          <label for="descriptionedit" class="form-label">Note description</label>
          <textarea class="form-control" id="descriptionedit" name="descriptionedit" rows="3"></textarea>
        </div>
        </div>
        <div class="modal-footer d-block mr-auto">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      PHP CRUD
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact Us</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
<?php
if ($alert){
  echo "<div class='alert alert-success 'role='alert'>
  Data has been inserted succesfully
</div>";
}
if ($update){
  echo "<div class='alert alert-success 'role='alert'>
  Data has been updated succesfully
</div>";
}
if ($deletebutton){
  echo "<div class='alert alert-success 'role='alert'>
  Data has been deleted succesfully
</div>";
}
?>
<div class="container mt-4">
  <h2>Add a note</h2>
<form action="index.php?" method="post">
  <div class="mb-3">
    <label for="title" class="form-label">Note title</label>
    <input type="text" class="form-control" id="title"  name="title" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
  <label for="desc" class="form-label">Note description</label>
  <textarea class="form-control" id="desc" name="description" rows="3"></textarea>
</div>
  <button type="submit" class="btn btn-primary">Add Note</button>
</form>
</div>
<div class="container mb-4">
  <table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">Sno</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
  <?php
  $sql="SELECt * FROM `notes`";
  $result=mysqli_query($conn,$sql);
  $s=0;
  while ($row=mysqli_fetch_assoc($result)){
    $s++;
    echo "<tr>
      <th scope='row'>".$s."</th>
      <td>".$row['title']."</td>
      <td>".$row['description']."</td>
      <td><button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=".$row['sno'].">Delete</button></td>
    </tr>";
  }
  ?>
  </tbody>
  
</table>
<hr>
</div>
<script>
  let edits = document.getElementsByClassName('edit');
Array.from(edits).forEach((element) => {
    element.addEventListener("click", (e) => {
        tr = e.target.parentNode.parentNode;
        let title = tr.getElementsByTagName("td")[0].innerText;
        let desc = tr.getElementsByTagName("td")[1].innerText;
        document.getElementById("titledit").value = title;
        document.getElementById("descriptionedit").value = desc;
        document.getElementById("snoEdit").value = e.target.id;
        $('#editModal').modal('toggle');
    });
});
let deletes = document.getElementsByClassName('delete');
Array.from(deletes).forEach((element) => {
    element.addEventListener("click", (e) => {
        sno=e.target.id;
        if (confirm("Are you sure you want to delete this note!")){
          window.location = `http://localhost/php_projects/iNotes/index.php?delete=${sno}`;
        }
        else{
          console.log("No");
        }
    });
});
</script>
</body>
</html> 