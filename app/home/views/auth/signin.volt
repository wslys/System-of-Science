<div class="container">

    <form class="form-signin" method="post" action="/auth/signin">
        <h2 class="form-signin-heading">登录</h2>
        {% if errors is defined %}
        <div class="errors">{{ errors }}</div>
        {% else %}
        <div class="errors">&nbsp;</div>
        {% endif %}
        <label for="username" class="sr-only">帐号</label>
        <input type="text" id="username" name="username" {% if not usernameError %}value="{{ username|e }}"{% endif%} class="form-control" placeholder="帐号" required {% if not passwordError %}autofocus{% endif %}>
        <label for="password" class="sr-only">密码</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="密码" required {% if passwordError %}autofocus{%endif%}>
        <input type="hidden" name="redirect_uri" value="{{ redirect_uri|e }}">
        <input type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">
        <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
        <div class="text-center" style="margin-top: 20px"><a href="/auth/getPassword">忘记密码</a></div>
    </form>

</div> <!-- /container -->