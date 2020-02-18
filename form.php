<?php

$form = new Form();
add_shortcode('form', [$form, 'fomPage']);


class Form
{

    function html_form_code()
    {
        global $blog_id;
        echo '<form action="' . esc_url($_SERVER['REQUEST_URI']) . '" method="post">';
        echo '<input type="hidden" name="blog_id" value="' . $blog_id . '" size="40" />';

        echo '<p>';
        echo 'Nama  <br/>';
        echo '<input type="text" name="nama" pattern="[a-zA-Z0-9 ]+" value="' . (isset($_POST["nama"]) ? esc_attr($_POST["nama"]) : '') . '" size="40" />';
        echo '</p>';
        echo '<p>';
        echo 'Email <br/>';
        echo '<input type="email" name="email" value="' . (isset($_POST["email"]) ? esc_attr($_POST["email"]) : '') . '" size="40" />';
        echo '</p>';
        echo 'Phone number <br/>';
        echo '<input type="number" name="phone" value="' . (isset($_POST["phone"]) ? esc_attr($_POST["phone"]) : '') . '" size="40" />';
        echo '</p>';

        echo 'Testimonial <br/>';
        echo '<textarea rows="20" cols="35" name="testimonial">' . (isset($_POST["testimonial"]) ? esc_attr($_POST["testimonial"]) : '') . '</textarea>';
        echo '</p>';
        echo '<p><input type="submit" name="submit" value="Send"></p>';
        echo '</form>';

        // wp_redirect( site_url('/') ); // <-- here goes address of site that user should be redirected after submitting that form
        // die;
    }


    function kirim()
    {
        if (isset($_POST['submit'])) {
            global $wpdb;
            $blog_id = $_POST['blog_id'];
            $name = $_POST['nama'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $testimonial = $_POST['testimonial'];
            $wpdb->insert(
                'komentar',
                array(
                    'blog_id' => $blog_id,
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'testimonial' => $testimonial
                ),
                array(
                    '%d',
                    '%s',
                    '%s',
                    '%d',
                    '%s',
                )
            );
        }
    }

    function fomPage()
    {
        ob_start();
        $this->html_form_code();
        $this->kirim();
        return ob_get_clean();
    }
}
