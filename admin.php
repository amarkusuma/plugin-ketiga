<?php
/*
Plugin Name: Admin
Description: Membuat Halaman Admin
Author: Ammar
*/
require_once('form.php');
require_once('widget.php');

$admin = new Admin();
add_action('admin_menu', [$admin, 'my_plugin_menu']);

class Admin
{

    function read_testimonial()
    {
        global $wpdb;
        global $blog_id;
        return $wpdb->get_results("SELECT * from komentar where blog_id=" . $blog_id);
    }

    function delete_testimonial()
    {
        global $wpdb;
        // global $blog_id;
        // return  $wpdb->delete('komentar', array('ID' =>  $_GET['id']));
        return  $wpdb->query('DELETE from komentar where id=' . $_GET['id']);
    }

    function my_plugin_menu()
    {
        add_options_page('My Plugin Options', 'My Plugin', 'manage_options', 'my-unique-identifier', array($this, 'my_plugin_options'));
    }

    function my_plugin_options()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }

        global $blog_id;
        if (isset($_GET['blog_id']) && $_GET['blog_id'] == $blog_id) {
            $this->delete_testimonial();
        }
?>
        <br><br>
        <p>
        </p>
        <table border="1" cellpadding="0" cellspacing="0">
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Testimonial</th>
                <th>Action</th>
            </tr>

            <?php
            foreach ($this->read_testimonial() as $data) {
            ?>
                <tr>
                    <td><?php echo $data->name; ?></td>
                    <td><?php echo $data->email; ?></td>
                    <td><?php echo $data->phone; ?></td>
                    <td><?php echo $data->testimonial; ?></td>
                    <td>
                        <a>Update</a> |
                        <a href="<?php echo admin_url('options-general.php?page=my-unique-identifier') . '&id=' . $data->id . '&blog_id=' . $blog_id ?>">delete</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
<?php
    }
}
?>