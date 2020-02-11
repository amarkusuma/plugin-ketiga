<?php
/*
Plugin Name: Admin
Description: Membuat Halaman Admin
Author: Ammar
*/
?>

<?php
add_action('admin_menu', 'my_plugin_menu');

/** Step 1. */
function my_plugin_menu()
{
    add_options_page('My Plugin Options', 'My Plugin', 'manage_options', 'my-unique-identifier', 'my_plugin_options');
}

/** Step 3. */
function my_plugin_options()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    global $wpdb;
    $myrows = $wpdb->get_results("SELECT * from komentar ");
?>
    <br><br>
    <table border="1" cellpadding="0" cellspacing="0">
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Testimonial</th>
            <th>Action</th>
        </tr>

        <?php
        foreach ($myrows as $data) {
        ?>
            <tr>
                <td><?php echo $data->name; ?></td>
                <td><?php echo $data->email; ?></td>
                <td><?php echo $data->phone; ?></td>
                <td><?php echo $data->testimonial; ?></td>
                <td>
                    <a href="#">Delete</a> |
                    <a href="#">Update</a>
                </td>
            </tr>
        <?php
        } ?>

    </table>

<?php
}
?>