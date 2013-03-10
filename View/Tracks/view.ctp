<div class="tracks view">
<h2><?php  echo __('Track'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($track['Track']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Source'); ?></dt>
		<dd>
			<?php echo $this->Html->link($track['Source']['name'], array('controller' => 'sources', 'action' => 'view', $track['Source']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Genre'); ?></dt>
		<dd>
			<?php echo $this->Html->link($track['Genre']['name'], array('controller' => 'genres', 'action' => 'view', $track['Genre']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url'); ?></dt>
		<dd>
			<?php echo h($track['Track']['url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mp3'); ?></dt>
		<dd>
			<?php echo h($track['Track']['mp3']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Artist'); ?></dt>
		<dd>
			<?php echo h($track['Track']['artist']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Song'); ?></dt>
		<dd>
			<?php echo h($track['Track']['song']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Failed Attempts'); ?></dt>
		<dd>
			<?php echo h($track['Track']['failed_attempts']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($track['Track']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($track['Track']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Track'), array('action' => 'edit', $track['Track']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Track'), array('action' => 'delete', $track['Track']['id']), null, __('Are you sure you want to delete # %s?', $track['Track']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Tracks'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Track'), array('action' => 'add')); ?> </li>
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
<div class="related">
	<h3><?php echo __('Related Track Downloads'); ?></h3>
	<?php if (!empty($track['TrackDownload'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Track Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($track['TrackDownload'] as $trackDownload): ?>
		<tr>
			<td><?php echo $trackDownload['id']; ?></td>
			<td><?php echo $trackDownload['track_id']; ?></td>
			<td><?php echo $trackDownload['user_id']; ?></td>
			<td><?php echo $trackDownload['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'track_downloads', 'action' => 'view', $trackDownload['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'track_downloads', 'action' => 'edit', $trackDownload['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'track_downloads', 'action' => 'delete', $trackDownload['id']), null, __('Are you sure you want to delete # %s?', $trackDownload['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Track Download'), array('controller' => 'track_downloads', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Track Listens'); ?></h3>
	<?php if (!empty($track['TrackListen'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Track Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($track['TrackListen'] as $trackListen): ?>
		<tr>
			<td><?php echo $trackListen['id']; ?></td>
			<td><?php echo $trackListen['user_id']; ?></td>
			<td><?php echo $trackListen['track_id']; ?></td>
			<td><?php echo $trackListen['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'track_listens', 'action' => 'view', $trackListen['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'track_listens', 'action' => 'edit', $trackListen['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'track_listens', 'action' => 'delete', $trackListen['id']), null, __('Are you sure you want to delete # %s?', $trackListen['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Track Listen'), array('controller' => 'track_listens', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related User Favorites'); ?></h3>
	<?php if (!empty($track['UserFavorite'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Track Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($track['UserFavorite'] as $userFavorite): ?>
		<tr>
			<td><?php echo $userFavorite['id']; ?></td>
			<td><?php echo $userFavorite['user_id']; ?></td>
			<td><?php echo $userFavorite['track_id']; ?></td>
			<td><?php echo $userFavorite['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'user_favorites', 'action' => 'view', $userFavorite['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'user_favorites', 'action' => 'edit', $userFavorite['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'user_favorites', 'action' => 'delete', $userFavorite['id']), null, __('Are you sure you want to delete # %s?', $userFavorite['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New User Favorite'), array('controller' => 'user_favorites', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
