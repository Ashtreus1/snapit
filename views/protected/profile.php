<main class="profile-content">
  <div class="profile-header-wrapper">
    <div class="profile-picture-wrapper">
      <?php if (!empty($user['avatar_path'])): ?>
        <img src="<?= htmlspecialchars($user['avatar_path']) ?>" alt="Avatar" class="profile-picture" />
      <?php else: ?>
        <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['username'] ?? 'U') ?>&background=random" alt="Default Avatar" class="profile-picture" />
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

  <nav class="profile-nav flex space-x-4 border-b pb-2 mb-4">
    <div class="tab-link font-medium cursor-pointer active-tab" data-tab="posts">Post</div>
    <div class="tab-link font-medium cursor-pointer" data-tab="pins">Pins</div>
  </nav>

  <!-- POSTS SECTION -->
  <section id="posts" class="tab-section">
    <?php if (!empty($images)): ?>
      <div class="posts grid gap-6 p-4"> <!-- Added grid, gap, and padding -->
        <?php foreach ($images as $image): ?>
          <div class="post bg-white rounded-lg shadow p-4 mb-4"> <!-- Added padding, margin, bg, rounded, shadow -->
            <img src="<?= htmlspecialchars($image['image_path']) ?>" alt="Post Image" class="mb-3 rounded" style="max-height:300px; object-fit:cover; width:100%;"> <!-- Added margin and rounded -->
            <div class="caption-details">
              <div class="caption-text">
                <div class="caption"><?= htmlspecialchars($image['title']) ?></div>
                <div class="tags"><?= htmlspecialchars($image['description']) ?></div>
              </div>
              <div class="likes" style="display: flex; align-items: center; gap: 8px;">
                <div class="like-icon">
                  <span class="material-symbols-outlined">favorite</span>
                </div>
                <span>
                  <?php
                    // Count how many users pinned this image (favorites)
                    $stmt = $GLOBALS['db']->connection->prepare('SELECT COUNT(*) FROM pinned_images WHERE image_id = ?');
                    $stmt->execute([$image['id']]);
                    echo $stmt->fetchColumn();
                  ?>
                </span>
                <form method="POST" action="<?= basePath('/delete-post') ?>" onsubmit="return confirm('Are you sure you want to delete this post? This action cannot be undone.');" style="display:inline; margin-left:8px;">
                  <input type="hidden" name="image_id" value="<?= $image['id'] ?>">
                  <button type="submit" class="delete-btn" style="background:none; border:none; color:#e53e3e; cursor:pointer; font-size:1.2em;">
                    <span class="material-symbols-outlined">delete</span>
                  </button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="text-center text-gray-400">No posts yet.</p>
    <?php endif; ?>
  </section>

  <!-- PINS SECTION -->
  <section id="pins" class="tab-section hidden mt-12">
    <?php if (!empty($pinnedImages)): ?>
      <div class="posts grid gap-6 p-4"> <!-- Added grid, gap, and padding -->
        <?php foreach ($pinnedImages as $image): ?>
          <div class="relative group overflow-hidden rounded-lg mb-6 p-4"> <!-- Added bg, shadow, padding -->
            <a href="<?= basePath('/comments?image_id=' . $image['id']) ?>"> 
              <img 
                class="w-full h-90 object-cover transition-transform duration-300 group-hover:scale-105 rounded mb-3"
                src="<?= htmlspecialchars($image['image_path']) ?>"
                alt="<?= htmlspecialchars($image['title']) ?>">
              <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </a>
            <form 
              action="<?= basePath('/toggle-pin') ?>" 
              method="POST" 
              class="absolute top-2 right-2 z-10">
              <input type="hidden" name="image_id" value="<?= $image['id'] ?>">
              <button
                type="submit"
                class="p-2 rounded-full shadow-md 
                      bg-red-500 text-white hover:bg-white hover:text-red-500 
                      transition-all duration-300"
                title="Unpin">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                  fill="currentColor" class="w-5 h-5 transition-colors duration-300">
                  <path fill-rule="evenodd" d="M12.1 21.55l-1.1-1.02C5.14 15.24 2 12.39 2 8.5 
                    2 6 4 4 6.5 4c1.74 0 3.41 1 4.13 2.44h1.74C14.09 5 
                    15.76 4 17.5 4 20 4 22 6 22 8.5c0 3.89-3.14 6.74-8.9 
                    12.03l-1.1 1.02z"
                    clip-rule="evenodd" />
                </svg>
              </button>
            </form>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="text-center text-gray-400">No pinned posts yet.</p>
    <?php endif; ?>
  </section>
</main>

<dialog id="my_modal_2" class="modal">
  <div class="modal-box w-full max-w-md">
    <h3 class="text-lg font-bold mb-4">Edit Profile</h3>
    <form action="<?= basePath('/profile/update') ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
      <div>
        <label for="username" class="block mb-1 font-medium">Username</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" class="w-full border px-3 py-2 rounded" required />
      </div>

      <div>
        <label for="email" class="block mb-1 font-medium">Email</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" class="w-full border px-3 py-2 rounded bg-gray-100" readonly />
      </div>

      <div>
        <label for="avatar" class="block mb-1 font-medium">Profile Picture</label>
        <input type="file" id="avatar" name="avatar" accept="image/*" class="w-full" />
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
<script src="assets/js/profile.js"></script>
