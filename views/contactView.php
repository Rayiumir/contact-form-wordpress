<?php

function contact_render_form() {

    ob_start();

    ?>
    <form>
        <div class="form-container flex">
            <div class="form-container">
                <label for="email">Email *</label>
                <input type="text" id="email" />
            </div>
            <div class="form-container">
                <label for="tel">Tel *</label>
                <input type="text" id="tel" />
            </div>
        </div>
        <div class="form-container">
            <label for="message">Message *</label>
            <textarea id="message" rows="10"></textarea>
        </div>
    </form>
    <?php
}
add_shortcode( 'contact_form', 'contact_render_form' );