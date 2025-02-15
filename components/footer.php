<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <!-- css link -->
    <link rel="stylesheet" href='../css/style.css'>
</head>
<body>
<footer class="bg-dark text-white text-center py-3">
        <p class="mb-0">All rights reserved by Ayesha Mehmood &copy; <span id="year"></span></p>
    </footer>

    <script>
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>
</body>
</html>