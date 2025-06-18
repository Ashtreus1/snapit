<main class="profile-content">
  <div class="profile-header-wrapper">
    <div class="profile-picture-wrapper">
      <?php if (!empty($user['avatar'])): ?>
        <img 
          src="<?= htmlspecialchars($user['avatar']) ?>" 
          alt="Avatar" 
          class="profile-picture"
        />
      <?php else: ?>
        <img 
          src="https://ui-avatars.com/api/?name=<?= urlencode($user['username'] ?? 'U') ?>&background=random" 
          alt="Default Avatar" 
          class="profile-picture"
        />
      <?php endif; ?>
    </div>

    <div class="profile-details">
      <div class="profile-info">
        <div class="profile-text">
          <h1><?= htmlspecialchars($user['username'] ?? 'Guest') ?></h1>
        </div>
      </div>

      <div class="profile-actions">
        <button class="edit-profile-button btn" onclick="my_modal_2.showModal()">
          <div class="edit-icon">
            <span class="material-symbols-outlined">edit</span>
          </div>
          <span>Edit Profile</span>
        </button>
      </div>
    </div>
  </div>

  <nav class="profile-nav">
    <div>Post</div>
    <div>Pins</div>
  </nav>

  <hr class="divider">

  <section class="posts">
    <?php if (!empty($images)): ?>
      <?php foreach ($images as $image): ?>
        <div class="post">
          <img src="<?= htmlspecialchars($image['image_path']) ?>" alt="Post Image">
          <div class="caption-details">
            <div class="caption-text">
              <div class="caption"><?= htmlspecialchars($image['title']) ?></div>
              <div class="tags"><?= htmlspecialchars($image['description']) ?></div>
            </div>
            <div class="likes">
              <div class="like-icon">
                <span class="material-symbols-outlined">favorite</span>
              </div>
              <span>0</span> 
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center text-gray-400">No posts yet.</p>
    <?php endif; ?>
  </section>
</main>

<dialog id="my_modal_2" class="modal">
  <div class="modal-box w-full max-w-md">
    <h3 class="text-lg font-bold mb-4">Edit Profile</h3>

    <form action="<?= basePath('/update-profile.php') ?>" method="POST" enctype="multipart/form-data" class="space-y-4">

      <div>
        <label for="username" class="block mb-1 font-medium">Username</label>
        <input
          type="text"
          id="username"
          name="username"
          value="<?= htmlspecialchars($user['username'] ?? '') ?>"
          class="w-full border px-3 py-2 rounded"
          required
        />
      </div>

      <div>
        <label for="email" class="block mb-1 font-medium">Email</label>
        <input
          type="email"
          id="email"
          name="email"
          value="<?= htmlspecialchars($user['email'] ?? '') ?>"
          class="w-full border px-3 py-2 rounded bg-gray-100"
          readonly
        />
      </div>

      <div>
        <label for="avatar" class="block mb-1 font-medium">Profile Picture</label>
        <input
          type="file"
          id="avatar"
          name="avatar"
          accept="image/*"
          class="w-full"
        />
      </div>

      <div class="flex justify-end gap-2 pt-4">
        <button type="button" class="btn bg-gray-200" onclick="my_modal_2.close()">Cancel</button>
        <button type="submit" class="btn bg-blue-600 text-white">Save Changes</button>
      </div>
    </form>
  </div>

  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>
