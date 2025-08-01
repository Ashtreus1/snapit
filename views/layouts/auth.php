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
<body class="h-screen bg-[url(assets/images/login/bg1.png)] bg-no-repeat p-20 relative">
	<div class="absolute inset-0 backdrop-blur-sm bg-white/50"></div>
	<?php if(isset($_GET['registered_success'])): ?>
		<div role="alert" id="registered" class="alert alert-success">
		  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
		    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
		  </svg>
		  <span>Registered Successfully!</span>
		</div>	
	<?php endif; ?>
	<?php if(isset($_GET['error_email'])): ?>
		<div role="alert" id="error_email" class="alert alert-error">
		  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
		    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
		  </svg>
		  <span>Email already exists!</span>
		</div>	
	<?php endif; ?>
	<?php if(isset($_GET['error_username'])): ?>
		<div role="alert" id="error_username" class="alert alert-error">
		  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
		    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
		  </svg>
		  <span>Username already exists!</span>
		</div>	
	<?php endif; ?>
	<?= $content ?> 
	<script>
		document.addEventListener('DOMContentLoaded', () => {
			const alerts = [
				{ id: 'registered', redirect: "<?= basePath('/login'); ?>" },
				{ id: 'error_email', redirect: "<?= basePath('/register'); ?>" },
				{ id: 'error_username', redirect: "<?= basePath('/register'); ?>" }
			];

			alerts.forEach(({ id, redirect }) => {
				const alert = document.getElementById(id);
				if (alert) {
					setTimeout(() => {
						alert.style.visibility = 'hidden';
						window.location.href = redirect;
					}, 5000);
				}
			});
		});
	</script>
</body>
</html>