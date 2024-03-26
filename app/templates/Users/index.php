<?php
$this->layout = 'users';
?>
<h1>Users</h1>

<?php if ($this->request->getAttribute('identity')): ?>
    <p>Welcome, <?= $this->request->getAttribute('identity')->username ?></p>
<?php endif; ?>

<?php if ($users): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user->id ?></td>
                <td><?= $user->username ?></td>
                <td><?= $user->email ?></td>
                <td><?= $user->created_at->format('Y-m-d H:i:s') ?></td>
                <td>
                    <!-- Link to view user details -->
                    <?= $this->Html->link('View', ['action' => 'view', $user->id]) ?>

                    <!-- Link to edit user -->
                    <?= $this->Html->link('Edit', ['action' => 'edit', $user->id]) ?>

                    <!-- Form for deleting user -->
                    <?= $this->Form->postLink(
                        'Delete',
                        ['action' => 'delete', $user->id],
                        ['confirm' => 'Are you sure you want to delete this user?']
                    ) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No users found.</p>
<?php endif; ?>

<!-- Link to create new user -->
<?php if ($this->request->getAttribute('identity')): ?>
    <?= $this->Html->link('Add User', ['action' => 'add']) ?>
<?php endif; ?>