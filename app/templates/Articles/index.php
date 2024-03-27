<h1>Articles</h1>
<?php if ($user && $user['type'] == 'article_writer'): ?>
        <a href="/articles/add" class="edit-btn">
            <button class="like-btn">Add Article</button>
        </a>
<?php endif; ?>
<?php if ($articles): ?>
    <div class="article-grid">
        <?php foreach ($articles as $article): ?>
            <div class="article-item">
                <div class="article-title">
                    <?= h($article->title) ?>
                    <?php if ($user && $user['type'] == 'article_writer'): ?>
                        <a href="/edit/<?= $article->id ?>">Edit</a>
                    <?php endif; ?>
                </div>
                <div class="article-subtitle">
                    <?= h($article->created_at->format('Y-m-d H:i:s')) ?>
                </div>
                <div class="article-body"><?= h($article->body) ?></div>

                <div class="article-foot">
                    <div class="article-likes">Current Likes: <?= h($article->like_count) ?></div>
                </div>
                <?php if ($user): ?>
                    <div class="article-foot">
                        <button class="like-btn" data-article-id="<?= $article->id?>">Like</button>
                        <?php if ($user && $user['type'] == 'article_writer'): ?>
                            <button class="delete-btn" data-article-id="<?= $article->id ?>">Delete</button>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
    

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.like-btn').click(function() {
            var articleId = $(this).data('article-id');
            $.ajax({
                url: '/likes/add',
                type: 'post',
                data: {article_id: articleId},
                dataType: 'json',
                success: function(response) 
                {
                    if(response.success)
                    {
                        location.reload()
                    }
                    else
                    {
                        alert(response.message)
                    }
                }
            });
        });
    });

    $(document).ready(function() 
    {
        $('.delete-btn').click(function() {
            var articleId = $(this).data('article-id');
            var confirmDelete = confirm("Are you sure you want to delete this article?");
            if (confirmDelete) {
                $.ajax({
                url: '/articles/' + articleId + '.json',
                type: 'DELETE',
                success: function(response) {
                    if(response.success)
                    {
                        location.reload()
                    }
                    else
                    {
                        alert(response.message)
                    }
                }
            });
            }
        });
    });
</script>

<style>
.article-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Adjust width as needed */
    gap: 20px; /* Adjust gap between cards */
}

.article-item {
    background-color: #ffffff;
    border: 1px solid #dddddd;
    border-radius: 8px;
    padding: 20px;
}

.article-title {
    font-size: 1.2em;
    font-weight: bold;
    margin-bottom: 10px;
    display:flex;
    justify-content: space-between;
    align-items: center;
}

.article-subtitle {
    font-size: 0.9em;
    color: #888888;
    margin-bottom: 10px;
}

.article-body {
    margin-bottom: 10px;
}

.article-foot
{
    display:flex;
    justify-content: space-between;
    align-items: center;
}

.article-likes {
    font-weight: 600;
    font-size: 0.9em;
    color: #888888;
}


.like-btn {
    background-color: #007bff;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.like-btn:hover {
    background-color: #0056b3;
}

.article-title a
{
    font-weight: normal;
}
</style>