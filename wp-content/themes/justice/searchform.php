<form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form">
    <div class="input-group">
        <input type="text" value="" name="s" id="s" class="form-control" placeholder="<?php esc_html_e('Search', 'Templatepath'); ?>" />
        <span class="input-group-btn">
            <button class="btn btn-search" type="submit"><i class="fa fa-search"></i></button>
        </span>
    </div>
</form>