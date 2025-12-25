<?php include('includes/header.php'); ?>
<style>
body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    margin: 0;
}
.main-content {
    flex: 1;
}

.contact-section {
    padding: 80px 20px;
    background: linear-gradient(135deg, #f0f8ff, #ffffff);
    display: flex;
    align-items: center;
    justify-content: center;
}
.contact-card {
    background: #fff;
    border-radius: 15px;
    padding: 40px;
    max-width: 800px;
    text-align: center;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}
.contact-card h1 {
    font-size: 2.5rem;
    font-weight: bold;
    color: #0072ff;
    margin-bottom: 20px;
}
.contact-card p {
    font-size: 1.2rem;
    line-height: 1.8;
    color: #444;
}
.highlight {
    color: #0072ff;
    font-weight: 600;
}
</style>

<div class="main-content">
    <div class="contact-section">
        <div class="contact-card">
            <h1>Contact Us</h1>
            <p style="font-size:1.2rem;">Have questions? Reach us below:</p>
            <p><span class="highlight">Email:</span> support@elevator.com</p>
            <p><span class="highlight">Phone:</span> +8801789174401</p>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
