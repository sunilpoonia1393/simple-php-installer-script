<?php
if(file_exists('db.inc.php')){
	header('location:index.php');
	die();
}
$msg="";
$host="";
$dbuname="";
$dbpwd="";
$dbname="";
if(isset($_POST['submit'])){
	$host=$_POST['host'];
	$dbuname=$_POST['dbuname'];
	$dbpwd=$_POST['dbpwd'];
	$dbname=$_POST['dbname'];
	
	$con=@mysqli_connect($host,$dbuname,$dbpwd,$dbname);
	if(mysqli_connect_error()){
		$msg=mysqli_connect_error();
	}else{
		copy("db.inc.config.php","db.inc.php");
		$file="db.inc.php";
		file_put_contents($file,str_replace("db_host",$host,file_get_contents($file)));
		file_put_contents($file,str_replace("db_username",$dbuname,file_get_contents($file)));
		file_put_contents($file,str_replace("db_password",$dbpwd,file_get_contents($file)));
		file_put_contents($file,str_replace("db_name",$dbname,file_get_contents($file)));
		
		$sql="CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `page` varchar(100) NOT NULL,
  `page_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
		mysqli_query($con,$sql);
		
		$sql="ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);";
		mysqli_query($con,$sql);
		
		$sql="ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;";
		mysqli_query($con,$sql);
		
		
		$sql="INSERT INTO `page` (`id`, `page`, `page_content`) VALUES
(1, 'Home', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ligula urna, dapibus eu nibh sit amet, pharetra varius est. Nam at felis ac dui pretium faucibus sit amet varius odio. In non semper tortor. Aliquam non velit dui. Sed a tincidunt purus. Morbi imperdiet mauris purus, et pellentesque urna consequat et. Proin tincidunt, lacus at blandit elementum, libero urna elementum massa, ac venenatis metus magna ut ligula. Sed ullamcorper orci diam, sit amet suscipit nibh vestibulum eget. Sed pharetra turpis elit, ut mattis arcu laoreet semper. Etiam hendrerit orci ac leo ullamcorper lacinia. Aenean varius suscipit mauris, at placerat elit placerat nec. Nulla scelerisque eget lorem quis fermentum. Morbi in mauris quis purus facilisis ultrices ut sit amet velit. Duis porta consequat lorem, eget scelerisque purus maximus vitae.\r\n\r\n'),
(2, 'About Us', 'Mauris vel erat et lorem suscipit vulputate. Sed eu hendrerit lorem. Phasellus congue erat varius sapien bibendum, at convallis purus semper. Cras vitae nisi id felis tristique luctus at quis ex. Morbi sed odio at velit molestie pharetra. Fusce sollicitudin, sem sed dapibus elementum, justo ipsum luctus tellus, eu auctor est odio eu dolor. Ut consequat metus in gravida lacinia. Integer euismod convallis sem. Sed venenatis lorem at pharetra tempus. Nulla vitae ante vitae orci maximus fringilla. Vestibulum at scelerisque sem, in porttitor felis. Nunc lacinia pulvinar diam in pulvinar. Nam porttitor ipsum vel arcu dictum placerat. Duis eu dui id sem mattis molestie. Nunc feugiat laoreet sodales. Cras sed molestie sem, non volutpat urna.\r\n\r\n'),
(3, 'Services', 'Etiam fringilla eros id cursus lobortis. Duis sodales imperdiet urna eu accumsan. Nulla egestas erat at elit consequat, vel ullamcorper velit aliquet. Donec convallis finibus odio, et aliquet urna congue ut. Vestibulum in justo consequat tortor sollicitudin ullamcorper. Curabitur at ullamcorper libero. Nunc risus mauris, condimentum id pellentesque vitae, porta vel tortor. Mauris erat magna, mattis eget ipsum id, imperdiet pellentesque ex. In tincidunt justo vitae velit aliquet ultricies. Nulla porta neque et orci finibus, eget interdum metus sagittis. Donec varius consequat venenatis. Vestibulum lobortis pellentesque sapien nec suscipit. Quisque eu tincidunt libero.\r\n\r\n');";
		mysqli_query($con,$sql);
		
		header('location:index.php');
	}
}
?>

<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>PHP Installer</title>
      <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <style>
		table{width:30% !important; text-align:center; margin:auto; margin-top:100px;}
		.success{color:green;}
		.error{color:red;}
		.frm{width:70% !important; margin:auto; margin-top:100px;}
	  </style>
   </head>
   <body>
      
      <main role="main" class="container">
		
		<?php
		if((isset($_GET['step'])) && $_GET['step']==2){
			?>
			
			<form class="frm" method="post">
			  <div class="form-group">
				<input type="text" class="form-control" placeholder="Host" required name="host" value="<?php echo $host?>">
			  </div>
			  <div class="form-group">
				<input type="text" class="form-control" placeholder="Database User Name" required name="dbuname" value="<?php echo $dbuname?>">
			  </div>
			  <div class="form-group">
				<input type="text" class="form-control" placeholder="Database Password" name="dbpwd" value="<?php echo $dbpwd?>">
			  </div>
			  <div class="form-group">
				<input type="text" class="form-control" placeholder="Database Name" required name="dbname" value="<?php echo $dbname?>">
			  </div>
			  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
			  <span class="error"><?php echo $msg?></span>
			</form>
			
			<?php
		}else{
		?>
	  
         <table class="table">
		  <thead>
			<tr>
			  <th scope="col">Configuration</th>
			  <th scope="col">Status</th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
			  <th scope="row">PHP Version</th>
			  <td>
				<?php
					$is_error="";
					$php_version=phpversion();
					if($php_version>5){
						echo "<span class='success'>".$php_version."</span>";
					}else{
						echo "<span class='error'>".$php_version."</span>";
						$is_error='yes';
					}
				?>
			  </td>
			</tr>
			<tr>
			  <th scope="row">Curl Install</th>
			  <td>
				<?php
				$curl_version=function_exists('curl_version');
				if($curl_version){
					echo "<span class='success'>Yes</span>";
				}else{
					echo "<span class='error'>No</span>";
					$is_error='yes';
				}
				?>
			  </td>
			</tr>
			<tr>
			  <th scope="row">Mail Function</th>
			  <td>
				<?php
				$mail=function_exists('mail');
				if($mail){
					echo "<span class='success'>Yes</span>";
				}else{
					echo "<span class='error'>No</span>";
					$is_error='yes';
				}
				?>
			  </td>
			</tr>
			<tr>
			  <th scope="row">Session Working</th>
			  <td>
				<?php
				$_SESSION['IS_WORKING']=1;
				if(!empty($_SESSION['IS_WORKING'])){
					echo "<span class='success'>Yes</span>";
				}else{
					echo "<span class='error'>No</span>";
					$is_error='yes';
				}
				?>
			  </td>
			</tr>
			
			<tr>
			  <td colspan="2">
				<?php 
				if($is_error==''){
					?>
					<a href="?step=2"><button type="button" class="btn btn-success">Next</button></a>
					<?php
				}else{
					?><button type="button" class="btn btn-danger">Error</button><?php
				}
				?>
			  </td>
			</tr>
		  </tbody>
		  
		</table>
		<?php } ?>
		
      </main>
      
      <script src="https://getbootstrap.com/docs/4.0/assets/js/vendor/popper.min.js"></script>
      <script src="https://getbootstrap.com/docs/4.0/dist/js/bootstrap.min.js"></script>
   </body>
</html>