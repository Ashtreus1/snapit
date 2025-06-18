<div class="flex flex-wrap justify-center items-center gap-4 p-10">
  	<a 
	    href="<?= basePath('/creation-post') ?>"
      <button class="btn bg-blue-600 shadow-none border-none text-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <path fill="currentColor" d="M11 13H5v-2h6V5h2v6h6v2h-6v6h-2z" />
        </svg>
        New Post
      </button>
    </a>
  <form action="<?= basePath('/search') ?>" method="GET">
    <label class="input rounded-full bg-transparent border border-gray-200">
      <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
          <circle cx="11" cy="11" r="8"></circle>
          <path d="m21 21-4.3-4.3"></path>
        </g>
      </svg>
      <input
        type="search"
        class="bg-transparent focus:outline-none"
        placeholder="Search"
        name="q"
        value="<?= htmlspecialchars($query ?? '') ?>"
      />
    </label>
  </form>


  <div class="flex flex-wrap items-center gap-2">
    <a href="<?= basePath('/feed') ?>"><button class="px-4 py-1 rounded-full transition-colors duration-300 <?= empty($selectedTag) || $selectedTag === 'All' ? 'bg-blue-600 text-white' : 'bg-transparent hover:bg-gray-200 text-black' ?>">
      
        All
      </button>
    </a>
    <?php
    $limit = 6;
    foreach (array_slice($tags, 0, $limit) as $tag):
      $isActive = isset($selectedTag) && $selectedTag === $tag;
      ?>
      <a href="<?= basePath('/feed?tag=') . urlencode($tag) ?>">
        <button class="px-4 py-1 rounded-full transition-colors duration-300 <?= $isActive ? 'bg-blue-600 text-white' : 'bg-transparent hover:bg-gray-200 text-black' ?>">
          <?= htmlspecialchars($tag) ?>
        </button>
      </a>
    <?php endforeach; ?>
    <?php if (count($tags) > $limit): ?>
      <div class="relative group">
        <button class="px-4 py-1 bg-transparent rounded-full hover:bg-blue-600 transition-colors duration-300">
          More
        </button>
        <div class="absolute z-10 invisible opacity-0 translate-y-2 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 bg-white border rounded shadow-md p-2">
          <?php foreach (array_slice($tags, $limit) as $tag):
            $isActive = isset($selectedTag) && $selectedTag === $tag;
            ?>
            <a href="<?= basePath('/feed?tag=') . urlencode($tag) ?>">
              <div class="px-2 py-1 rounded-full transition-colors duration-300 <?= $isActive ? 'bg-blue-600 text-white' : 'hover:bg-gray-200 text-black' ?>">
                <?= htmlspecialchars($tag) ?>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<div class="m-10 p-6 grid grid-cols-2 md:grid-cols-4 gap-6">
  <?php if (!empty($images)): ?>
    <?php foreach ($images as $image): ?>
      <?php
        $isPinned = in_array($image['id'], array_column($user['pinned_images'], 'image_id'));
      ?>

      <div class="relative group overflow-hidden rounded-lg mb-6">
        <a href="<?= basePath('/comments?image_id=' . $image['id']) ?>">
          <img 
            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
            src="<?= htmlspecialchars($image['image_path']) ?>"
            alt="<?= htmlspecialchars($image['title']) ?>"
          >
          <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </a>

        <form 
          action="<?= basePath('/toggle-pin') ?>" 
          method="POST" 
          class="absolute top-2 right-2 z-10 transition-opacity duration-300
                <?= $isPinned ? '' : 'opacity-0 group-hover:opacity-100' ?>">
          
          <input type="hidden" name="image_id" value="<?= $image['id'] ?>">

          <button
            type="submit"
            class="p-2 rounded-full shadow-md 
                  bg-white text-red-500 hover:bg-red-500 hover:text-white 
                  transition-all duration-300 <?= $isPinned ? 'bg-red-500 text-red' : '' ?>"
            title="<?= $isPinned ? 'Unpin' : 'Pin this post' ?>">
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

  <?php else: ?>
    <p class="text-center col-span-full text-gray-600">No images found.</p>
  <?php endif; ?>
</div>
