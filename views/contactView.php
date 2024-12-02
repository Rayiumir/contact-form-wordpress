<?php

// View Contact Form

function contact_render_form() {

    ob_start();

    ?>
        <form action="<?php echo esc_url( admin_url('admin-post.php') )?>" method="POST">
            <div class="form-container flex">
                <div class="form-container">
                    <label for="name">Name *</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-container">
                    <label for="email">Email *</label>
                    <input type="text" id="email" name="email" required>
                </div>
            </div>
            <div class="form-container">
                <label for="message">Message *</label>
                <textarea id="message" rows="10" name="message" required></textarea>
            </div>
            <input type="hidden" name="action" value="contact_handle_form">
            <button type="submit" class="button">submit</button>
        </form>
    <?php

    return ob_get_clean();
}
add_shortcode( 'contact_form', 'contact_render_form' );

