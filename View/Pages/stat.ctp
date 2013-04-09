<?
echo $this->set('title_for_layout','Статистика проекта');
?>

<p>Всего треков: <?=$stat['tracks'];?></p>
<p>Пользователей: <?=$stat['users'];?></p>
<p>Треков в избранном: <?=$stat['favorites'];?></p>
<p>Всего прослушано: <?=$stat['listened'];?> / за сегодня: <?=$stat['listened_today'];?></p>
<p>Скачано: <?=$stat['download'];?> / за сегодня: <?=$stat['download_today'];?></p>