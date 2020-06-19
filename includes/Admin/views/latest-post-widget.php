<form name="post" action="" method="post" class="flex-container">
    <div>
        <input type="text" autocomplete="FALSE" placeholder="Number of Posts" name="num-of-posts">
    </div>
    <div>
        <select id="sort-posts-by" name="sort-posts-by">
            <option selected disabled value="">Sory By</option>
            <option value="ASC">Ascending</option>
            <option value="DESC">Descending</option>
        </select>
    </div>
    <?php wp_nonce_field('xvr_pw_nonce'); ?>
    <?php submit_button(__('Filter Posts', 'xvr-latest-posts'), 'primary', 'submit_post_widget'); ?>
</form>