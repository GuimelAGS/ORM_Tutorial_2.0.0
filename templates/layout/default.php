<?php
/**
 * @var \App\View\AppView $this
 */
$cakeDescription = 'Tutorial CMS';
$identity = $this->request->getAttribute('identity');
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake']) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <style>
        .top-nav-links a { margin-left: 1rem; }
        .nav-user { color: #ccc; font-size: 0.85rem; margin-left: 1rem; }
    </style>
</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-title">
            <a href="<?= $this->Url->build('/') ?>"><span>Tutorial</span> CMS</a>
        </div>
        <div class="top-nav-links">
            <?= $this->Html->link('Articles', ['controller' => 'Articles', 'action' => 'index']) ?>
            <?= $this->Html->link('Tags', ['controller' => 'Tags', 'action' => 'index']) ?>
            <?= $this->Html->link('Users', ['controller' => 'Users', 'action' => 'index']) ?>
            <?php if ($identity): ?>
                <span class="nav-user">👤 <?= h($identity->email) ?></span>
                <?= $this->Html->link('Logout', ['controller' => 'Users', 'action' => 'logout']) ?>
            <?php else: ?>
                <?= $this->Html->link('Login', ['controller' => 'Users', 'action' => 'login']) ?>
            <?php endif; ?>
        </div>
    </nav>
    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>
