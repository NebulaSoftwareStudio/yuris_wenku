<?php if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") { ?>
    <div class="card subscribe mdc-bg-green-600 text-left">
        <h2 class="text-left">您目前正使用HTTPS加密方式访问Yuris文库</h2>
        <small class="text-left">如非必要，请尽量使用HTTPS加密方式访问Yuris文库。使用未加密的方式进行访问将增加页面被篡改的可能。</small>
    </div>

<?php } else { ?>
    <div class="card subscribe mdc-bg-red-600">
        <h2 class="text-left">您未使用HTTPS方式访问Yuris文库</h2>
        <small class="text-left">如非必要，请尽量使用HTTPS加密方式访问Yuris文库。使用未加密的方式进行访问将增加页面被篡改的可能。</small>
    </div>
<?php } ?>