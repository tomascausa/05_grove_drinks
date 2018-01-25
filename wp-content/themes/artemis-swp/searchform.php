<form role="search" method="get" class="search-form" id="search-form" action="<?php echo esc_url(home_url('/')); ?>"
      data-ajax-action="<?php echo esc_attr( admin_url( 'admin-ajax.php' )) ?>">
    <input name="s" required type="search" value="<?php echo get_search_query() ?>"
           id="search-word"
           placeholder="<?php echo esc_html__('Search anything', 'artemis-swp') ?>"
           class="input-search">

    <button type="submit" id="search-submit" class="search-submit" title="<?php echo esc_html__('Search', 'artemis-swp') ?>">
        <span class="lnr lnr-magnifier"></span>
    </button>
</form>

