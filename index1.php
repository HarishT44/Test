<?php

	function fetch_data()
	{
		$output = '';
		$conn = mysqli_connect("localhost","root","","testing");
		$query = "SELECT * FROM t1 ORDER BY sno ASC";
		$result = mysqli_query($conn, $query);

		while($row = mysqli_fetch_array($result))
		{
			$output .=	'
				<tr>
					<td>'.$row["sno"].'</td>
					<td>'.$row["sname"].'</td>					
					<td>'.$row["course"].'</td>										
				</tr>
			';
		}

		return $output;

	}

	function generate_mail()
	{
		require_once("tcpdf/tcpdf.php");
		$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$obj_pdf -> SetCreator(PDF_CREATOR);
		$obj_pdf -> SetTitle("Student List - IUC Computers");
		$obj_pdf -> SetTitle("Student List - IUC Computers");
		$obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
		$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
		$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
		$obj_pdf->SetDefaultMonospacedFont('helvetica');  
		$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
		$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
		$obj_pdf->setPrintHeader(false);  
		$obj_pdf->setPrintFooter(false);  
		$obj_pdf->SetAutoPageBreak(TRUE, 10);  
		$obj_pdf->SetFont('helvetica', '', 12);  
		$obj_pdf->AddPage();		

		$content = '';

		$content .= '
			<h3>IUC Computers Student List</h3>
			<table border = "1" cellspacing = "0" cellpadding = "5">
				<tr>
					<th>S.No</th>
					<th>Student Name</th>
					<th>Course</th>
				</tr>
		';

		$content .= fetch_data();
		$content .= '</table>' ;		

		return $content;		
	}


	if((isset($_POST["create_pdf"])))
	{
		$content = generate_mail();
		$obj_pdf -> writeHTML($content);
		$obj_pdf -> Output("sample.pdf", "I");	

	}

	if(isset($_POST['create_email']))
		{
			$to = $_POST['tom'];
			$content = generate_mail();
			$retmail = mail($to, "PDF Generation sample", $content);

			if($retmail == true)
			{
				echo "Mail sent successfully";
			}
			else
			{
				echo "Error in sending mail";
			}
		}

?>


<!DOCTYPE html>
<html>
<head>
	<title>PDF Conversion</title>
	<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<h3>IUC Computers Student List</h3>
		<div class="table-responsive">
			<table class="table table-bordered">
				<tr>
					<th>S.No</th>
					<th>Student Name</th>
					<th>Course</th>
				</tr>
				<?php
					echo fetch_data();
				?>

			</table>
		</div>			
		<form method="POST">
			<input type="submit" name="create_pdf" value="Create PDF" class="btn btn-danger">	
			<br>
				<label>Enter to mail :</label>			
			<input type="email" name="tom" value="">
			<input type="submit" name="create_email" value="Generate Mail" class="btn btn-danger">				
		</form>

	</div>
</body>
</html>
