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
        echo 'Name  <br/>';
        echo '<input type="text" name="input-name" pattern="[a-zA-Z0-9 ]+" value="' . (isset($_POST["input-name"]) ? esc_attr($_POST["input-name"]) : '') . '" size="40" />';
        echo '</p>';
        echo '<p>';
        echo 'Email <br/>';
        echo '<input type="email" name="input-email" value="' . (isset($_POST["input-email"]) ? esc_attr($_POST["input-email"]) : '') . '" size="40" />';
        echo '</p>';
        echo 'Phone number <br/>';
        echo '<input type="number" name="input-phone" value="' . (isset($_POST["input-phone"]) ? esc_attr($_POST["input-phone"]) : '') . '" size="40" />';
        echo '</p>';

        echo 'Testimonial <br/>';
        echo '<textarea rows="20" cols="35" name="input-testimonial">' . (isset($_POST["input-testimonial"]) ? esc_attr($_POST["input-testimonial"]) : '') . '</textarea>';
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
            $name = $_POST['input-name'];
            $email = $_POST['input-email'];
            $phone = $_POST['input-phone'];
            $testimonial = $_POST['input-testimonial'];
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
