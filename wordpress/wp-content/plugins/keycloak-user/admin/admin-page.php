<?php

function kum_admin_page() {

    $kc = new Keycloak_API();

    if (isset($_POST['create_user'])) {

        $kc->create_user([
            'username' => sanitize_text_field($_POST['username']),
            'email' => sanitize_email($_POST['email']),
            'enabled' => true
        ]);

        echo "<div class='updated'><p>User created</p></div>";
    }

    if (isset($_GET['delete'])) {

        $kc->delete_user($_GET['delete']);
    }

    $users = $kc->get_users();

?>

<div class="wrap">

<h1>Keycloak Users</h1>

<h2>Create User</h2>

<form method="post">

<input name="username" placeholder="username" required>
<input name="email" placeholder="email" required>

<button name="create_user" class="button button-primary">
Create
</button>

</form>

<hr>

<h2>User List</h2>

<table class="widefat">

<tr>
<th>Username</th>
<th>Email</th>
<th>Action</th>
</tr>

<?php foreach ($users as $user): ?>

<tr>

<td><?php echo esc_html($user['username']); ?></td>
<td><?php echo esc_html($user['email']); ?></td>

<td>

<a href="?page=keycloak-users&delete=<?php echo $user['id']; ?>">
Delete
</a>

</td>

</tr>

<?php endforeach; ?>

</table>

</div>

<?php
}