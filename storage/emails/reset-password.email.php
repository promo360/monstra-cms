Здравствуйте, <?php echo $user_login; ?>!
<br><br>
Вы отправили запрос, чтобы сбросить пароль на сайте <?php echo $site_url; ?>, потому что вы забыли свой пароль.
Если вы не запрашивали новый пароль, пожалуйста, игнорируйте это письмо.
<br><br>
Чтобы сбросить ваш пароль, пожалуйста, посетите следующую страницу:<br>
<a href="<?php echo $site_url; ?>/users/password-reset?hash=<?php echo $new_hash; ?>" style="color:#333; text-decoration:underline;"><?php echo $site_url; ?>/users/password-reset?hash=<?php echo $new_hash; ?></a>
<br><br>
Когда вы посетите эту страницу, старый пароль будет сброшен, а новый пароль будет выслан вам на электронную почту.
<br><br>
Ваш логин: <?php echo $user_login; ?>
<br><br>
Чтобы изменить свой профиль, перейдите на эту страницу:<br>
<a href="<?php echo $site_url ?>/users/<?php echo $user_id; ?>" style="color:#333; text-decoration:underline;"><?php echo $site_url ?>/users/<?php echo $user_id; ?></a>
<br><br>
Всего наилучшего,<br>
<?php echo $site_name; ?>
