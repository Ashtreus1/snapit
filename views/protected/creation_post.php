<link rel="stylesheet" href="<?= basePath('/assets/css/create_post.css') ?>">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:FILL@1" />
<?php if (!empty($_SESSION['error'])): ?>
  <div class="text-red-400 font-medium mb-4"><?= $_SESSION['error'] ?></div>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<main class="main">
	<div class="create-post-header border-b border-gray-300 h-16 flex items-center px-6">
		<a href="<?= basePath('/feed') ?>" class="back-button">
			<span class="material-symbols-outlined">arrow_back_ios</span>
		</a>
		<h2 class="text-2xl font-bold">Create Post</h2>
	</div>
	<form method="POST" action="<?= basePath('/creation-post') ?>" class="content" enctype="multipart/form-data">
		<div class="upload-area relative overflow-hidden" ondrop="dropHandler(event)"
			ondragover="dragOverHandler(event)">
			<label class="drop-zone relative overflow-hidden" for="fileInput">
				<div id="preview" class="absolute w-full h-full overflow-hidden"></div>
				<input type="file" name="image" id="fileInput" accept=".jpg,.jpeg,.png" hidden
					onchange="handleFileInput(this)" required/>
				<span class="material-symbols-outlined upload-icon">cloud_upload</span>
				<p class="upload-text">Choose a file or drag and drop<br>it here</p>
				<p class="upload-note">We recommend using high quality .jpeg or .png files less than 20MB</p>
			</label>
			<button class="change-photo" type="button" onclick="document.getElementById('fileInput').click()">
				Change photo
			</button>

		</div>

		<div class="form-area">
			<label for="title">Title</label>
			<input id="title" type="text" name="title" placeholder="Add title.." required>
			<label for="desc">Description</label>
			<textarea id="desc" name="description" placeholder="Add a short detailed description" required></textarea>
			<label for="tags">Tags / categories</label>
			<select id="tags" name="tag_id" required>
				<option value="">Select a tag</option>
				<?php foreach ($tags as $tag): ?>
					<option value="<?= $tag['id'] ?>"><?= htmlspecialchars($tag['name']) ?></option>
				<?php endforeach; ?>
			</select>
			<button class="publish" type="submit">Publish</button>
		</div>
	</form>
</main>
<script src="assets/js/creation-post.js"></script>

