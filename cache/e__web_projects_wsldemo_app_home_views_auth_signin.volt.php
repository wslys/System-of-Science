<div class="container">

    <form class="form-signin" method="post" action="/auth/signin">
        <h2 class="form-signin-heading">登录</h2>
        <?php if (isset($errors)) { ?>
        <div class="errors"><?php echo $errors; ?></div>
        <?php } else { ?>
        <div class="errors">&nbsp;</div>
        <?php } ?>
        <label for="username" class="sr-only">帐号</label>
        <input type="text" id="username" name="username" <?php if (!$usernameError) { ?>value="<?php echo $this->escaper->escapeHtml($username); ?>"<?php } ?> class="form-control" placeholder="帐号" required <?php if (!$passwordError) { ?>autofocus<?php } ?>>
        <label for="password" class="sr-only">密码</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="密码" required <?php if ($passwordError) { ?>autofocus<?php } ?>>
        <input type="hidden" name="redirect_uri" value="<?php echo $this->escaper->escapeHtml($redirect_uri); ?>">
        <input type="hidden" name="<?php echo $this->security->getTokenKey(); ?>" value="<?php echo $this->security->getToken(); ?>">
        <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
        <div class="text-center" style="margin-top: 20px"><a href="/auth/getPassword">忘记密码</a></div>
    </form>

</div> <!-- /container -->