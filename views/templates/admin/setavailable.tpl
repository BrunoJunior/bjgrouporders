<a
        href="#"
        role="button"
        data-url="{$url|escape:'html':'UTF-8'}"
        title="{$label|escape:'html':'UTF-8'}"
        class="bj-setavailable"
        onclick="setAvailable(this, '{$action}')"
>
    <i class="icon-check"></i> {$label|escape:'html':'UTF-8'}
</a>

<script>
    function setAvailable(button, action) {
        const btnJQuery = $(button);
        callBJAjaxAction(btnJQuery, action).then(resultat => {
            btnJQuery.closest('tr').remove();
            $('#ajax_confirmation')
                .addClass('alert-success')
                .removeClass('alert-danger')
                .removeClass('hide')
                .text(resultat.message)
                .show();
        }).catch(error => {
            $('#ajax_confirmation')
                .addClass('alert-danger')
                .removeClass('alert-success')
                .removeClass('hide')
                .text(error)
                .show();
        });
    }
</script>