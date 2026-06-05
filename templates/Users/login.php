<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="users form content">
    <h3><?= __('Login') ?></h3>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Enter your email and password') ?></legend>
        <?= $this->Form->control('email', ['required' => true]) ?>
        <?= $this->Form->control('password', ['required' => true]) ?>
    </fieldset>
    <?= $this->Form->button(__('Login')) ?>
    <?= $this->Form->end() ?>
    <p><?= $this->Html->link(__('Create an account'), ['action' => 'add']) ?></p>
</div>
