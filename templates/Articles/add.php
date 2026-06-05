<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article $article
 * @var array $tags
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Articles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="articles form content">
            <?= $this->Form->create($article) ?>
            <fieldset>
                <legend><?= __('Add Article') ?></legend>
                <?php
                    echo $this->Form->control('title');
                    echo $this->Form->control('body', ['rows' => 5]);
                    echo $this->Form->control('tag_string', ['label' => 'Tags (comma separated)', 'type' => 'text']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Save Article')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
