<?php
require('libs/fpdf.php'); // Include FPDF library

// Database connection (set up your database connection)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gate_pass_system";

$conn = new mysqli("localhost", "root", "", "gate_pass_system" ); 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $rollno = $_POST['rollno'];
    $department = $_POST['department'];
    $semester = $_POST['semester'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $reason = $_POST['reason'];
    $mobile_number = $_POST['mobile_number'];

    // Handle the photo upload
    $photo = $_FILES['photo']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate image file
    if ($_FILES["photo"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk && move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        // Insert into database
        $sql = "INSERT INTO gatepass_data (name, rollno, department, semester, date, time, reason, mobile_number, photo) 
                VALUES ('$name', '$rollno', '$department', '$semester', '$date', '$time', '$reason', '$mobile_number', '$photo')";
        if ($conn->query($sql) === TRUE) {
            // Generate PDF
            $pdf = new FPDF();
            $pdf->AddPage();

            // Header section with green background
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->SetFillColor(46, 125, 50); // Green color
            $pdf->SetTextColor(255, 255, 255); // White text
            $pdf->Cell(0, 20, 'ST. VINCENT PALLOTTI COLLEGE', 0, 1, 'C', true);
            $pdf->Cell(0, 10, 'STUDENT GATE PASS', 0, 1, 'C', true);
            $pdf->Ln(5);

            // Details section
            $pdf->SetTextColor(0, 0, 0); // Black text
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(50, 10, "Name: $name", 0, 1);
            $pdf->Cell(50, 10, "Roll Number: $rollno", 0, 1);
            $pdf->Cell(50, 10, "mobile_number:  $mobile_number", 0, 1);
            $pdf->Cell(50, 10, "Department: $department", 0, 1);
            $pdf->Cell(50, 10, "Semester: $semester", 0, 1);
            $pdf->Cell(50, 10, "Date: $date", 0, 1);
            $pdf->Cell(50, 10, "Time: $time", 0, 1);
            $pdf->MultiCell(0, 10, "Reason: $reason", 0, 1);

            // Add photo
            if (file_exists($target_file)) {
                $pdf->Image($target_file, 150, 50, 40, 40); // Adjust size and position
            }

            // Output PDF
            $pdf->Output('D', 'Gate_Pass.pdf');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$conn->close();
?>
