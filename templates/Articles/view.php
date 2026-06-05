<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article $article
 */
$identity = $this->request->getAttribute('identity');
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Articles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?php if ($identity): ?>
                <?= $this->Html->link(__('Edit Article'), ['action' => 'edit', $article->slug], ['class' => 'side-nav-item']) ?>
                <?= $this->Form->postLink(
                    __('Delete Article'),
                    ['action' => 'delete', $article->slug],
                    ['confirm' => __('Are you sure?'), 'class' => 'side-nav-item']
                ) ?>
                <?= $this->Html->link(__('Add Article'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
            <?php endif; ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="articles view content">
            <h3><?= h($article->title) ?></h3>
            <p><?= h($article->body) ?></p>
            <table>
                <tr>
                    <th><?= __('Tags') ?></th>
                    <td>
                        <?php foreach ($article->tags as $tag): ?>
                            <?= $this->Html->link(h($tag->title), ['action' => 'tags', $tag->title]) ?>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($article->created->format(DATE_RFC850)) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
