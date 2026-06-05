<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Article> $articles
 * @var array $tags
 */
?>
<div class="articles tags content">
    <h3>
        <?= __('Articles tagged with') ?>
        <?= $this->Text->toList(array_map('h', $tags), 'or') ?>
    </h3>
    <?= $this->Html->link('← All Articles', ['action' => 'index']) ?>

    <section>
        <?php foreach ($articles as $article): ?>
        <article>
            <h4><?= $this->Html->link(h($article->title), ['action' => 'view', $article->slug]) ?></h4>
            <span><?= h($article->created) ?></span>
        </article>
        <?php endforeach; ?>
        <?php if (empty($articles->toArray())): ?>
            <p><?= __('No articles found with these tags.') ?></p>
        <?php endif; ?>
    </section>
</div>
