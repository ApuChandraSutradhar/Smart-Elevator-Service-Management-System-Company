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

.about-section {
    padding: 80px 20px;
    background: linear-gradient(135deg, #f0f8ff, #ffffff);
    display: flex;
    align-items: center;
    justify-content: center;
}
.about-card {
    background: #fff;
    border-radius: 15px;
    padding: 40px;
    max-width: 800px;
    text-align: center;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}
.about-card h1 {
    font-size: 2.5rem;
    font-weight: bold;
    color: #0072ff;
    margin-bottom: 20px;
}
.about-card p {
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
    <div class="about-section">
        <div class="about-card">
            <h1>About Us</h1>
            <p>
                Our <span class="highlight">"Smart Elevator Service & Management System"</span> helps customers request 
                maintenance, track technicians, and manage service history efficiently. 
                We aim to provide a <span class="highlight">modern, reliable, and user-friendly</span> solution.
            </p>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
