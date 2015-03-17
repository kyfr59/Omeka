<nav id="admin-bar">

<?php if($user = current_user()) {

    $links = array(
        array(
            'label' => __('WWelcome, %s', $user->name),
            'uri' => omeka_admin_url('/users/edit/'.$user->id)
        ),
        array(
            'label' => __('Omeka Admin'),
            'uri' => omeka_admin_url('/')
        ),
        array(
            'label' => __('Log Out'),
            'uri' => url('/users/logout')
        )
    );

} else {
    $links = array(
        array(
            'label' => __('WWelcome, %s', $user->name),
            'uri' => omeka_admin_url('/users/edit/'.$user->id)
        ),
        array(
            'label' => __('Omeka Admin'),
            'uri' => omeka_admin_url('/')
        ),
        array(
            'label' => __('Log Out'),
            'uri' => url('/users/logout')
        )
    );
}

echo nav($links, 'public_navigation_admin_bar');
?>

</nav>
