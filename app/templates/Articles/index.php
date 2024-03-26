<?php
$this->layout = 'default'; // Assuming you have a layout for articles
?>
<h1>Articles</h1>

<?php if ($this->request->getAttribute('identity')): ?>
    <p>Welcome, <?= $this->request->getAttribute('identity')->username ?></p>
<?php endif; ?>

<?php if ($articles): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Body</th>
            <th>Likes</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($articles as $article): ?>
            <tr>
                <td><?= $article->id ?></td>
                <td><?= h($article->title) ?></td>
                <td><?= h($article->body) ?></td>
                <td><?= h($article->like_count) ?></td>
                <td><?= h($article->created_at->format('Y-m-d H:i:s')) ?></td>
                <td>
                    
                    <button id="like-btn" data-article-id="<?= $article->id?>">Like</button>

                    <?= $this->Html->link('Edit', ['action' => 'edit', $article->id]) ?>

                    <?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $article->id],
                        ['confirm' => 'Are you sure you want to delete this article?']
                    ) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No articles found.</p>
<?php endif; ?>

<?php if ($this->request->getAttribute('identity')): ?>
    <?= $this->Html->link('Add Article', ['action' => 'add']) ?>
<?php endif; ?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#like-btn').click(function() {
            var articleId = $(this).data('article-id');
            $.ajax({
                url: '/likes/add',
                type: 'post',
                data: {article_id: articleId},
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        alert(response.message);
                    } else {
                        alert(response.message);
                    }
                }
            });
        });
    });
</script>