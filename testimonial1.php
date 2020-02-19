<?php
/*
Plugin Name: Testimonial 1
Description: create testimonial 1
Author: Ammar
*/
require_once('form-testimonial1.php');
require_once('widget-testimonial1.php');

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

    function delete_testimonial($id, $get_blogid)
    {
        global $wpdb;
        global $blog_id;

        if ($blog_id == $get_blogid) {
            return  $wpdb->query("DELETE from komentar where id= $id AND blog_id=$blog_id");
        }
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


        if (isset($_GET['id']) && $_GET['blog_id']) {
            $id = $_GET['id'];
            $blog_id = $_GET['blog_id'];
            $this->delete_testimonial($id, $blog_id);
        }
?>
        <br><br>
        <p>
        </p>
        <table border="1" cellpadding="0" cellspacing="0">
            <tr>

                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Testimonial</th>
                <th>Action</th>
            </tr>

            <?php
            $display_testimonial = $this->read_testimonial();
            foreach ($display_testimonial as $data) {
            ?>
                <tr>

                    <td><?php echo $data->name; ?></td>
                    <td><?php echo $data->email; ?></td>
                    <td><?php echo $data->phone; ?></td>
                    <td><?php echo $data->testimonial; ?></td>
                    <td>
                        <a>Update</a> |
                        <a href="<?php echo admin_url('options-general.php?page=my-unique-identifier') . '&id=' . $data->id . '&blog_id=' . $data->blog_id ?>">delete</a>
                        <!-- <a href="<?php echo admin_url('options-general.php?page=my-unique-identifier') . '&id=' . $data->id ?>">delete</a> -->
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