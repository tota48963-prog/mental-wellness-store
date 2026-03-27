<?php
require_once 'config/database.php';
include 'includes/header.php';
include 'includes/navbar.php';

$msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);
    
    if($conn->query("INSERT INTO contacts (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')")) {
        $msg = '<div class="alert alert-success">✅ Message sent successfully! We will contact you soon.</div>';
    } else {
        $msg = '<div class="alert alert-danger">❌ Error sending message. Please try again.</div>';
    }
}
?>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body p-4">
                    <h3 class="mb-4" style="color: #89CFF0;"><i class="fas fa-envelope"></i> Send us a Message</h3>
                    <?php echo $msg; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject *</label>
                            <input type="text" name="subject" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message *</label>
                            <textarea name="message" rows="5" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-paper-plane"></i> Send Message</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body p-4">
                    <h3 class="mb-4" style="color: #89CFF0;"><i class="fas fa-address-card"></i> Contact Information</h3>
                    
                    <div class="mb-4">
                        <h5><i class="fas fa-phone" style="color: #89CFF0;"></i> Phone</h5>
                        <p>+20 123 456 7890</p>
                        <p>+20 123 456 7891</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5><i class="fas fa-envelope" style="color: #89CFF0;"></i> Email</h5>
                        <p>info@mindfulhaven.com</p>
                        <p>support@mindfulhaven.com</p>
                    </div>
                    
                    <div class="mt-4">
                        <h5><i class="fas fa-clock" style="color: #89CFF0;"></i> Working Hours</h5>
                        <p>Sunday - Thursday: 9:00 AM - 6:00 PM</p>
                        <p>Friday - Saturday: Closed</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>