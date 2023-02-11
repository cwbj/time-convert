<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700,900&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="fonts/icomoon/style.css">


	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">

	<!-- Style -->
	<link rel="stylesheet" href="css/style.css">

	<title>Time Difference App - CWB</title>
</head>

<body>
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-md-5 mr-auto">
					<h3 class="mb-3">Time Difference App</h3>
					<p>This App used to convert the inserted time to the other countries' local time. You only need to input
						it on the form and choose the local time that you want to convert.</p>
					<p>This app is still in BETA and everyone could make some suggest on the app.</p>
				</div>

				<?php
				// php variable
				// $timezones = array(
				// 	'Asia/Kolkata'      => "(GMT+05:30) Kolkata/India",
				// 	'Asia/Colombo'      => "(GMT+05:30) Colombo/Sri Lanka",
				// 	'Asia/Kathmandu'    => "(GMT+05:45) Kathmandu/Nepal",
				// 	'Asia/Yangon'       => "(GMT+06:30) Yangon/Myanmar",
				// 	'Asia/Makassar'     => "(GMT+08:00) Makassar/Bali",
				// 	'Asia/Manila'       => "(GMT+08:00) Manila/Philippines",
				// 	'Asia/Tokyo'        => "(GMT+09:00) Tokyo/Japan"
				// 	);

				$timezones = array(
					'Asia/Kolkata'      => "India",
					'Asia/Colombo'      => "Sri Lanka",
					'Asia/Kathmandu'    => "Nepal",
					'Asia/Yangon'       => "Myanmar",
					'Asia/Phnom_Penh'	=> "Cambodia",
					'Asia/Makassar'     => "Bali",
					'Asia/Manila'       => "Philippines",
					'Asia/Tokyo'        => "Japan"
					);
				?>

				<div class="col-md-6">
					<div class="box">
						<form class="mb-5" method="post" name="timeApp">
							<div class="row">
								<div class="col-md-12 form-group">
									<label for="time" class="col-form-label">Time *</label>
									<input required type="time" class="form-control" name="date" id="time" value="<?php echo !empty($_POST['date']) ? $_POST['date'] : '' ?>">
								</div>
							</div>

							<div class="row mb-3">
								<div class="col-md-12 form-group">
									<label for="budget" class="col-form-label">Location Zone *</label>
									<select required class="custom-select" id="zone" name="zone">
										<option selected>Choose...</option>
										<?php
										foreach($timezones as $key => $value){
											if(isset($_POST['zone']) && $_POST['zone']==$key) {
												echo "<option selected name=\"zone\" value=\"$key\">$value</option>";
											} else {
												echo "<option name=\"zone\" value=\"$key\">$value</option>";
											}
												
										}
										?>
									</select>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<input type="submit" value="Submit" class="btn btn-block btn-primary rounded-0 py-2 px-4">
									<span class="submitting"></span>
								</div>
							</div>
						</form>

						<div class="row">
							<div class="col-md-12">
								<div class="version">CWB &copy;<?php if(Date('Y') == "2023") echo "2023"; else echo "2023 - ".Date('Y'); ?><br><b>v0.2 (beta)</b></div>
							</div>
						</div>

						<div id="form-message-warning mt-4"></div>
						<div id="form-message-success">
							Your message was sent, thank you!
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/popper.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.validate.min.js"></script>
		<script src="js/main.js"></script>

		<?php
		if(isset($_POST['date']) && isset($_POST['zone'])) {
			try {
				$data = [];
				foreach($timezones as $key => $value){
						$data[$key]['test'] = new DateTime($_POST['date'], new DateTimeZone($_POST['zone']));
						$data[$key]['test']->setTimezone(new DateTimeZone($key));

						$data[$key]['result'] = $data[$key]['test']->format('h:i A');
						$data[$key]['key'] = $key;
						$data[$key]['title'] = $value;
				}
				
				// $result = $hongkong->format('h:i A');
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}

		if(isset($_POST['date']) || isset($_POST['zone'])) {

			echo "<script>
			$(window).on('load', function(){
					$('#thankyouModal').modal('show');
				});
			</script>";

			$waktu = date('h:i A', strtotime($_POST['date']));
		?>

		<div class="modal fade" id="thankyouModal" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">
							<?php 
							foreach($data as $value){
								if($_POST['zone']==$value['key']) {
									echo $value['title']. " (".$waktu.")";
								} 
							}
							?>
						</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body mb-4 mt-4">
					<?php
					foreach($data as $value){
						if($_POST['zone']!=$value['key']) {
							echo "<div class='row'><div class='col-md-8'><small><input id='" .$value['title']. "' style='width:100%' type='text' value='" .$value['title']. " " .$value['result'] ."'></small></div><div><button class='btn-sm kecil' onclick='myFunction(\"".$value['title']."\")'>Copy text</button></div>";
							echo "</div>";
						}
					}
					?>
					</div>
				</div>
			</div>
		</div>

		<?php
		}
		?>
		
	<script>
		function myFunction(val) {
			// Get the text field
			var copyText = document.getElementById(val);

			// Select the text field
			copyText.select();
			copyText.setSelectionRange(0, 99999); // For mobile devices

			// Copy the text inside the text field
			navigator.clipboard.writeText(copyText.value);

			// Alert the copied text
			alert("Copied the text: " + copyText.value);
		}
	</script>
</body>

</html>