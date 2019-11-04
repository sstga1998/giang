<?php include_once("header.php") ?>
<?php include_once("nav.php") ?>
<?php
include_once("../ktra/danhba.php");
//$rsMockData = LearningHistory::getList("102T1011010");
//$rsFromFile = LearningHistory::getListFromFile("101");
if (isset($_REQUEST["add"])) {
	$id = $_REQUEST["id"];
	$name = $_REQUEST["Name"];
	$phone = $_REQUEST["Phone"];
	$email = $_REQUEST["Email"];
	$danhbaCreate =  new Danhba($id, $name, $phone, $email);
	Danhba::addToDB($danhbaCreate);
}
/**
 * Edit
 */
else if (isset($_REQUEST["edit"])) {	
	$id = $_REQUEST["id"];
	$name = $_REQUEST["Name"];
	$phone = $_REQUEST["Phone"];
	$email = $_REQUEST["Email"];
	$danhbaEditer =  new Danhba($id, $name, $phone, $email);
	Danhba::editDB($danhbaEditer);
}
/**
 * Xóa
 */
else if (isset($_REQUEST["del"])) {
	$id = $_REQUEST["del"];
	Danhba::deleteDB($id);
}
/**
 * Hàm thêm DL vào ds/search
 */
$keyWord = null;
if (strpos($_SERVER['REQUEST_URI'], "search")) {
	$keyWord = $_REQUEST['search'];
}
if($keyWord == "") $keyWord = null;
$lsFromFile = Danhba::getListFromDB($keyWord);

?>
<div class="container pt-5">
	<button class="btn btn-outline-info float-right" data-toggle="modal" data-target="#addItem"><i class="fas fa-plus-circle"></i> Thêm</button>
	<form action="" method="GET">
		<div class="form-group">
			<input class="form-control" name="search" style="max-width: 200px; display:inline-block;" placeholder="Search">
			<button type="submit" class="btn btn-default" style="margin-left:-50px"><i class="fas fa-search"></i></button>
		</div>
	</form>
	<table class="table">
		<thead class="thead-dark">
			<tr>
				<th scope="col"></th>
				<th scope="col">Name</th>
				<th scope="col">Phone</th>
				<th scope="col">Email</th>
			</tr>
		</thead>
		<tbody>
			 <?php
			for ($i = 0; $i < count($lsFromFile); $i++) { ?>
				<tr>
					<th scope="row"><?php echo $lsFromFile[$i]->id ?></th>
					<td><?php echo $lsFromFile[$i]->Names ?></td>
					<td><?php echo $lsFromFile[$i]->phone ?></td>
					<td><?php echo $lsFromFile[$i]->email ?></td>
					<td class="d-flex">
						<button class="btn btn-outline-info mr-3" data-toggle="modal" data-target="#editItem<?php echo $i ?>"><i class="far fa-edit"></i> Sửa</button>
						<button class="btn btn-outline-danger" name="delete" data-toggle="modal" data-target="#deleteItem<?php echo $i ?>"><i class="fas fa-trash-alt"></i> Xóa</button>
						<!--Edit-->
						<form action="" method="GET">
							<div class="modal fade" id="editItem<?php echo $i ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLongTitle">Edit</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<form>
												<div class="form-group ">
													<label for="from">ID</label>
													<input type="text" name="id" class="form-control" value="<?php echo $lsFromFile[$i]->id ?>" placeholder="id">
												</div>
												<div class="form-group ">
													<label for="from">Name</label>
													<input type="text" name="Name" class="form-control" value="<?php echo $lsFromFile[$i]->Names ?>" placeholder="Name">
												</div>
												<div class="form-group">
													<label for="to">Phone</label>
													<input type="number" name="Phone" class="form-control" value="<?php echo $lsFromFile[$i]->phone ?>" placeholder="Phone">
												</div>
												<div class="form-group">
													<label for="class">Email</label>
													<input type="text" name="Email" class="form-control" value="<?php echo $lsFromFile[$i]->email ?>" placeholder="Email">
												</div>
												<div class="modal-footer">
												<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
													<button class="btn btn-primary" name="edit" type="submit" value="<?php echo $lsFromFile[$i]->id ?>">Save changes</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</form>
						<!--end Edit-->

						<!--Delete-->
						<form action="" method="DELETE">
							<div class="modal fade" id="deleteItem<?php echo $i ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Notice</h5>
											<button class="close" type="button" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">×</span>
											</button>
										</div>
										<div class="modal-body">Do you want to delete this?</div>
										<div class="modal-footer">
											<button class="btn btn-danger" name="del" type="submit" value="<?php echo $lsFromFile[$i]->email ?>">Delete</button>
											<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
										</div>
									</div>
								</div>
							</div>
						</form>
						<!--end Delete-->
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<!--Add-->
<div class="modal fade" id="addItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add book</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post">
					<div class="form-group ">
						<label for="from">ID</label>
						<input type="text" class="form-control" name="id" placeholder="ID">
					</div>
					<div class="form-group">
						<label for="to">Name</label>
						<input type="text" class="form-control" name="Name" placeholder="Name">
					</div>
					<div class="form-group">
						<label for="class">Phone</label>
						<input type="number" class="form-control" name="Phone" placeholder="Phone">
					</div>
					<div class="form-group">
						<label for="class">Email</label>
						<input type="text" class="form-control" name="Email" placeholder="Email">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" name="add">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!--End Add-->

<?php include_once("footer.php") ?>
