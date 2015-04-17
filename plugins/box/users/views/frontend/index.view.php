<?php if (in_array(Session::get('user_role'), array('admin', 'editor'))) { ?>
<table>
    <tr>
        <td></td>
    </tr>
    <?php foreach ($users as $user) { ?>
    <tr>
        <td>
            <a href="<?php echo Site::url(); ?>/users/<?php echo $user['id']; ?>"><?php echo $user['login']; ?></a>
        </td>
    </tr>
    <?php } ?>
</table>
<?php 
} else {
    if (Users::isLoged()) {
        Request::redirect(Site::url().'/users/'.Session::get('user_id'));
    } else {
        Request::redirect(Site::url().'/users/registration');
    }
}
?>