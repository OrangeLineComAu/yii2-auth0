<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
?>

<div id="root" style="width: 280px; margin: 40px auto; padding: 10px; border-width: 1px;">
</div>
<?php

echo "
<script src='https://cdn.auth0.com/js/lock-7.5.min.js'></script>
<script>

  var lock = new Auth0Lock('{$module->clientId}', '{$module->domain}');


  lock.show({
      focusInput: true,
      rememberLastLogin: false,
      container: 'root'
    , callbackURL: '{$module->redirectUri}'
    , responseType: 'code'
    , authParams: {
        scope: 'openid profile'
        }
  });
</script>";
?>
