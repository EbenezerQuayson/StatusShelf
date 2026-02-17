  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">


      <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/assets/images/favicon.png">

    <!-- SEO -->
    <meta name="description" content="StatusShelf is a platform for selling and promoting products.">
    <meta name="robots" content="index, follow">
    
    <!-- Custom Styles -->
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        :root { --brand-color: <?php echo $theme_color; ?>; }
        .text-brand { color: var(--brand-color); }
        .bg-brand { background-color: var(--brand-color); }
        .border-brand { border-color: var(--brand-color); }
        .ring-brand:focus { --tw-ring-color: var(--brand-color); }
        .hover-bg-brand:hover { background-color: var(--brand-color); }
    </style>
    </head>
