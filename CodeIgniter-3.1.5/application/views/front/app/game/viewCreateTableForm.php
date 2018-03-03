<form class="form-horizontal" role="form" method="POST" onsubmit="cCheck();return false;">
    <div class="form-group">
        <label for="cBullet" class="col-sm-2 control-label">Bullet</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="cBullet" placeholder="Bullet length" value="10" />
            <div id="cBulletError" class="cErrors alert alert-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="cVist" class="col-sm-2 control-label">Vist</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="cVist" placeholder="Vist value" value="0" />
            <div id="cVistError" class="cErrors alert alert-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <label for="cLifetime" class="col-sm-2 control-label">Life Time(sec)</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="cLifetime" placeholder="Life time in seconds" value="100" />
            <div id="cLifetimeError" class="cErrors alert alert-danger"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-success btn-lg">Enter</button>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(".cErrors").hide();
    function cCheck() {
        var data = {
            bullet: $("#cBullet").val(),
            vist: $("#cVist").val(),
            lifetime: $("#cLifetime").val()
        };
        $.php("app/game/create_table", data);
    }
</script>