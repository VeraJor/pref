<form class="form-horizontal" role="form" method="POST" onsubmit="rCheck();return false;">
    <div class="form-group">
        <label for="rNickname" class="col-sm-2 control-label">Nickname</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="rNickname" placeholder="Your Nickname">
            <div id="rNicknameError" class="rErrors alert alert-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="rEmail" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="rEmail" placeholder="Your Email">
            <div id="rEmailError" class="rErrors alert alert-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="rPassword" class="col-sm-2 control-label">Password</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="rPassword" placeholder="Your Password">
            <div id="rPasswordError" class="rErrors alert alert-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="rConfirm" class="col-sm-2 control-label">Conf pass</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="rConfirm" placeholder="Password confirmation">
            <div id="rConfirmError" class="rErrors alert alert-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-success btn-lg">Enter</button>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(".rErrors").hide();
    function rCheck() {
        var data = {
            nickname: $("#rNickname").val(),
            email: $("#rEmail").val(),
            password: $("#rPassword").val(),
            confirm: $("#rConfirm").val()
        };
        $.php("registration", data);
    }
</script>