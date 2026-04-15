<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article $article
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $tags
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
                echo $this->Form->control('body');
                echo $this->Form->control('published');
                echo $this->Form->control('tag_string', [
                    'type' => 'text',
                    'label' => 'Tags (comma separated)',
                    'id' => 'tags-input',
                    'value' => $article->tag_string ?? ''
                ]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?php
// $tags is available in your view per your docblock.
// Ensure $tags is an array of tag titles (strings). If it's a Collection, convert:
$tagWhitelist = is_array($tags) ? $tags : $tags->toArray();

// If your $tags is actually an id=>title list, use array_values:
$tagWhitelist = array_values($tagWhitelist);
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.querySelector('#tags-input');
        if (!input) return;

        const tagify = new Tagify(input, {
            whitelist: <?= json_encode($tagWhitelist) ?>,
            dropdown: {
                enabled: 1,
                maxItems: 20,
                closeOnSelect: false
            },

            // ✅ KEY LINE: make submitted input value "steve,test" instead of JSON objects
            originalInputValueFormat: valuesArr =>
                valuesArr.map(item => item.value).join(',')
        });
    });
</script>