Здравствуйте, <?php echo $user_login ?>!
<br><br>
Как вы и просили, ваш пароль будет сброшен.<br>
Ваши новые данные для входа:
<br><br>
Логин: <?php echo $user_login; ?><br>
Пароль: <?php echo $new_password; ?>
<br><br>
Чтобы изменить пароль, пожалуйста, перейдите на эту страницу: <a href="<?php echo $site_url; ?>/users/<?php echo $user_id; ?>" style="color:#333; text-decoration:underline;"><?php echo $site_url; ?>/users/<?php echo $user_id; ?></a>
<br><br>
Всего наилучшего,<br>
<?php echo $site_name; ?>
