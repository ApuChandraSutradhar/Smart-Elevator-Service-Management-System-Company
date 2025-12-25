<?php 
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Elevator System</title>
<link rel="stylesheet" href="/elevator_system/assets/css/style.css">
<style>
body { font-family: Arial, sans-serif; margin:0; padding:0; background: #f0f4f8; }

nav { 
    background: #0072ff; 
    padding: 10px 20px; 
    display: flex; 
    flex-wrap: wrap; 
    align-items: center; 
    justify-content: space-between; 
    position: relative;
}

nav .logo { height: 50px; }

nav ul { 
    list-style: none; 
    padding: 0; 
    margin: 0; 
    display: flex; 
    flex-wrap: wrap; 
    position: relative; 
}

nav ul li { 
    margin: 0 10px; 
    position: relative; 
}

nav ul li a { 
    color: #fff; 
    text-decoration: none; 
    font-weight: bold; 
    padding: 8px 12px; 
    border-radius: 5px; 
    display: inline-block; 
    cursor: pointer;
    transition: 0.3s;
}

nav ul li a:hover { 
    background: rgba(255,255,255,0.2); 
}

nav ul li a.active { 
    background: #005bb5; 
}

nav ul li ul.dropdown {
    display: none;
    opacity: 0;
    position: absolute;
    top: 120%;
    left: 50%;
    transform: translateX(-50%);
    background: transparent;
    padding: 10px 0;
    min-width: 220px;
    flex-direction: column;
    gap: 12px;
    z-index: 2000;
    transition: opacity 0.3s ease, transform 0.3s ease;
}

nav ul li ul.dropdown.show {
    display: flex;
    opacity: 1;
    transform: translateX(-50%) translateY(0px);
}

nav ul li ul.dropdown li a {
    background: #fff;
    color: #0072ff;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
}

nav ul li ul.dropdown li a:hover {
    background: #0072ff;
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.25);
}

@media(max-width:768px){
    nav { flex-direction: column; align-items: flex-start; }
    nav ul { flex-direction: column; width: 100%; margin-top: 10px; }
    nav ul li { margin: 5px 0; }
    nav ul li ul.dropdown { 
        position: relative; 
        top: 0; 
        left: 0; 
        transform: none; 
        min-width: 100%; 
        background: transparent;
        gap: 10px;
    }
    nav ul li ul.dropdown li a { width: 100%; }
}
</style>
</head>
<body>

<header>
    <nav>
        <a href="/elevator_system/index.php">
            <img src="/elevator_system/assets/images/logo.png" alt="Elevator System Logo" class="logo">
        </a>
        <ul>
            <li><a href="/elevator_system/index.php" class="<?= ($current_page=='index.php')?'active':'' ?>">Home</a></li>
            <li><a href="/elevator_system/about.php" class="<?= ($current_page=='about.php')?'active':'' ?>">About</a></li>
            <li><a href="/elevator_system/contact.php" class="<?= ($current_page=='contact.php')?'active':'' ?>">Contact</a></li>
            <li><a href="/elevator_system/message.php" class="<?= ($current_page=='message.php')?'active':'' ?>">Message</a></li>
            
            <li class="dropdown-parent">
                <a id="dashboardToggle">Dashboard ▼</a>
                <ul class="dropdown" id="dashboardDropdown">
                    <li><a href="/elevator_system/customer/dashboard.php">👤 Customer Panel</a></li>
                    <li><a href="/elevator_system/admin/dashboard.php">🛠 Admin Panel</a></li>
                    <li><a href="/elevator_system/technician/dashboard.php">🔧 Technician Panel</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</header>

<script>
const toggle = document.getElementById('dashboardToggle');
const dropdown = document.getElementById('dashboardDropdown');

toggle.addEventListener('click', (e) => {
    e.preventDefault();
    dropdown.classList.toggle('show');
});

document.addEventListener('click', (e) => {
    if(!toggle.contains(e.target) && !dropdown.contains(e.target)){
        dropdown.classList.remove('show');
    }
});
</script>
</body>
</html>
