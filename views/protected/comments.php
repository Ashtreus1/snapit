<section class="content">
  <main class="main">
    <section class="post-section">

      <img src="<?= htmlspecialchars($imagePath) ?>" alt="Post Image" class="main-image" />

      <div class="post-content">
        <h2 class="main-caption">
          <?= htmlspecialchars($imageDetails['title'] ?? pathinfo(basename($imagePath), PATHINFO_FILENAME)) ?>
        </h2>
        <p class="author">
          <?= htmlspecialchars($imageDetails['username'] ?? 'Unknown User') ?>
        </p>
        <div class="tags">
          <?= htmlspecialchars($imageDetails['description'] ?? '#Photography') ?>
        </div>

        <div class="likes" style="margin-bottom: 1rem; display: flex; align-items: center; gap: 6px;">
          <div class="like-icon">
            <span class="material-symbols-outlined">favorite</span>
          </div>
          <span style="font-size: 1.1em; font-weight: 500; padding-bottom: 5px;">
            <?php
              // Count how many users pinned this image (favorites)
              $stmt = $GLOBALS['db']->connection->prepare('SELECT COUNT(*) FROM pinned_images WHERE image_id = ?');
              $stmt->execute([$imageDetails['id']]);
              echo $stmt->fetchColumn();
            ?>
          </span>
        </div>

        <div class="comment-scroll">
          <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
              <div class="comment-box">
                <h3 class="comment-author"><?= htmlspecialchars($comment['username']) ?></h3>
                <p class="comment-text"><?= htmlspecialchars($comment['message']) ?></p>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="no-comments">No comments yet. Be the first!</p>
          <?php endif; ?>
        </div>

        <div class="comment-input-box">
          <form action="<?= basePath('/comments?image_id=' . urlencode($imageDetails['id'])) ?>" method="POST" class="relative">
            <input
              type="text"
              name="comment"
              placeholder="Comment here as <?= htmlspecialchars($userData['username']) ?>"
              required
              class="pr-12"
            />
            <button type="submit" class="send-btn">
              <span class="material-symbols-outlined">send</span>
            </button>
          </form>
        </div>
      </div>
    </section>
  </main>
</section>
