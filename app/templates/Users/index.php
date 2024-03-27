<h1>Users</h1>

<?php if ($this->request->getAttribute('identity')): ?>
    <p>Welcome, <?= $this->request->getAttribute('identity')->username ?></p>
<?php endif; ?>

<?php if ($users): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Type</th>
            <th>Created</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user->id ?></td>
                <td><?= $user->email ?></td>
                <td><?= $user->type ?></td>
                <td><?= $user->created_at->format('Y-m-d H:i:s') ?></td>
                
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