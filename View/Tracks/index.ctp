<div class="tracks index">
	<h2><?php echo __('Tracks'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('source_id'); ?></th>
			<th><?php echo $this->Paginator->sort('genre_id'); ?></th>
			<th><?php echo $this->Paginator->sort('url'); ?></th>
			<th><?php echo $this->Paginator->sort('mp3'); ?></th>
			<th><?php echo $this->Paginator->sort('artist'); ?></th>
			<th><?php echo $this->Paginator->sort('song'); ?></th>
			<th><?php echo $this->Paginator->sort('failed_attempts'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($tracks as $track): ?>
	<tr>
		<td><?php echo h($track['Track']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($track['Source']['name'], array('controller' => 'sources', 'action' => 'view', $track['Source']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($track['Genre']['name'], array('controller' => 'genres', 'action' => 'view', $track['Genre']['id'])); ?>
		</td>
		<td><?php echo h($track['Track']['url']); ?>&nbsp;</td>
		<td><?php echo h($track['Track']['mp3']); ?>&nbsp;</td>
		<td><?php echo h($track['Track']['artist']); ?>&nbsp;</td>
		<td><?php echo h($track['Track']['song']); ?>&nbsp;</td>
		<td><?php echo h($track['Track']['failed_attempts']); ?>&nbsp;</td>
		<td><?php echo h($track['Track']['created']); ?>&nbsp;</td>
		<td><?php echo h($track['Track']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $track['Track']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $track['Track']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $track['Track']['id']), null, __('Are you sure you want to delete # %s?', $track['Track']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Track'), array('action' => 'add')); ?></li>
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
