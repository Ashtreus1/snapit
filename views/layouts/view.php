<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
	<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet"/>
    
	<link rel="stylesheet" href="assets/css/view-post.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap" rel="stylesheet">
	<link rel="icon" type="image/x-icon" href="assets/images/header-logo.png">
	<title>
		<?= $title ?? 'Photoim' ?>		
	</title>
</head>
<body class="min-h-screen bg-[#1e1e1e] text-gray-200">
  <div class="navbar flex justify-between items-center bg-transparent shadow-sm px-6 py-4">
    <div class="flex items-center gap-3">
      <img src="assets/images/header-logo.png" class="h-10 w-10" alt="Logo" />
      <p class="font-semibold text-xl cursor-pointer">Snappit</p>
    </div>

    <div class="flex gap-3 items-center">
	 <a href="<?= basePath("/profile") ?>" class="flex gap-2 justify-center items-center">
		<p class="text-sm font-medium"><?= htmlspecialchars($userData['username'] ?? 'Guest') ?></p>
		<img src="<?= basePath('/' . htmlspecialchars($userData['avatar_path'] ?? 'assets/images/user/avatar1.png')) ?>" alt="Avatar"
			class="h-10 w-10 rounded-full object-cover" />
	 </a> 
	  <a 
	    href="<?= basePath('/logout') ?>"
	    class="btn border-none bg-red-500 shadow-none text-white"
	  >
	    Logout
	  </a>
	</div>
  </div>
  <?= $content ?> 
</body>

</html>