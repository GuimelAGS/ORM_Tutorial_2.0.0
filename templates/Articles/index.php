<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Article> $articles
 */
$identity = $this->request->getAttribute('identity');
?>
<div class="articles index content">
    <?php if ($identity): ?>
        <?= $this->Html->link(__('Add Article'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <?php endif; ?>
    <h3><?= __('Articles') ?></h3>
    <table>
        <thead>
            <tr>
                <th><?= __('Title') ?></th>
                <th><?= __('Tags') ?></th>
                <th><?= __('Created') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article): ?>
            <tr>
                <td><?= $this->Html->link(h($article->title), ['action' => 'view', $article->slug]) ?></td>
                <td>
                    <?php foreach ($article->tags as $tag): ?>
                        <?= $this->Html->link(h($tag->title), ['action' => 'tags', $tag->title]) ?>
                    <?php endforeach; ?>
                </td>
                <td><?= h($article->created->format('Y-m-d')) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $article->slug]) ?>
                    <?php if ($identity): ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $article->slug]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $article->slug],
                            ['confirm' => __('Are you sure you want to delete "{0}"?', $article->title)]
                        ) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
