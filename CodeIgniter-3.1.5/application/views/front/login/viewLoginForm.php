<form class="form-horizontal" role="form" method="POST" onsubmit="lCheck();return false;">
    <div class="form-group">
        <label for="lEmail" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="lEmail" placeholder="Email">
            <div id="lEmailError" class="lErrors alert alert-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="lPassword" class="col-sm-2 control-label">Password</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="lPassword" placeholder="Password">
            <div id="lPasswordError" class="lErrors alert alert-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-success btn-lg">Enter</button>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(".lErrors").hide();
    function lCheck() {
        var data = {
            email: $("#lEmail").val(),
            password: $("#lPassword").val()
        };
        $.php("login", data);
    }
</script>