<div class="tracks form">
<?php echo $this->Form->create('Track'); ?>
	<fieldset>
		<legend><?php echo __('Add Track'); ?></legend>
	<?php
		echo $this->Form->input('source_id');
		echo $this->Form->input('genre_id');
		echo $this->Form->input('url');
		echo $this->Form->input('mp3');
		echo $this->Form->input('artist');
		echo $this->Form->input('song');
		echo $this->Form->input('failed_attempts');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Tracks'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Sources'), array('controller' => 'sources', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Source'), array('controller' => 'sources', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Genres'), array('controller' => 'genres', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Genre'), array('controller' => 'genres', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Track Downloads'), array('controller' => 'track_downloads', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Track Download'), array('controller' => 'track_downloads', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Track Listens'), array('controller' => 'track_listens', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Track Listen'), array('controller' => 'track_listens', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Favorites'), array('controller' => 'user_favorites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Favorite'), array('controller' => 'user_favorites', 'action' => 'add')); ?> </li>
	</ul>
</div>
