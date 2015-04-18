Блог
================

#### Получить пост
	<?php echo Blog::getPost(); ?>

#### Получить посты
	<?php echo Blog::getPosts(); ?>

#### Получить 5 постов (может быть любое количество, 5, 1 или 25):
	<?php echo Blog::getPosts(5); ?>

#### Получить связанные посты
	<?php echo Blog::getRelatedPosts(); ?>

#### Получить последние 4 поста
	<?php echo Blog::getPostsBlock(4); ?>

#### Получить теги
	<?php Blog::getTags(); ?>

#### Получить теги для текущей страницы
	<?php Blog::getTags(Page::slug()); ?>

#### Получить заголовок поста
	<?php echo Blog::getPostTitle(); ?>

### Шорткод для вставки в контент

#### Разбиение поста на 2 части (короткую и полную)
	{cut}