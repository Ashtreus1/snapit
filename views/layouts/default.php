<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
	<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="icon" type="image/x-icon" href="assets/images/header-logo.png">
	<title>
		<?= $title ?? 'Photoim' ?>		
	</title>
</head>
<body class="min-h-screen bg-[#1e1e1e] text-gray-200">
  <div class="navbar flex justify-between items-center bg-transparent shadow-sm px-6 py-4">
    <!-- Logo and brand -->
    <div class="flex items-center gap-3">
      <img src="assets/images/header-logo.png" class="h-10 w-10" alt="Logo" />
      <p class="font-semibold text-xl cursor-pointer">Snappit</p>
    </div>

    <div class="flex gap-2">
      <a
        href="<?= basePath('/login') ?>"
        class="btn bg-transparent text-blue-400 border-2 border-blue-400 shadow-none hover:bg-blue-400 hover:text-white transition">
        Sign In
      </a>
      <a
        href="<?= basePath('/register') ?>"
        class="btn btn-primary shadow-none border-none hover:brightness-110 transition">
        Sign Up
      </a>
    </div>
  </div>

  <?= $content ?> 
</body>

</html>