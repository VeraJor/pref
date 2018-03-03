<nav class="navbar navbar-default ">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <div class="navbar-brand pull-left">Balance: 0.00054</div>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            
            <ul class="nav navbar-nav">
                <?php $class = ($sm == 'game') ? 'class="active"' : ''; ?>
                <li <?= $class ?> >
                    <a href='javascript:{}' class="sm" data-mod="game">
                        Game
                    </a>
                </li>
                <?php $class = ($sm == 'finance') ? 'class="active"' : ''; ?>
                <li <?= $class ?> >
                    <a href='javascript:{}' class="sm" data-mod="finance">
                        Finanсe
                    </a>
                </li>
                <?php $class = ($sm == 'profile') ? 'class="active"' : ''; ?>
                <li <?= $class ?> >
                    <a href='javascript:{}' class="sm" data-mod="profile">
                        Profile
                    </a>
                </li>
                <?php $class = ($sm == 'rules') ? 'class="active"' : ''; ?>
                <li <?= $class ?> >
                    <a href='javascript:{}' class="sm" data-mod="rules">
                        Rules
                    </a> 
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<script type="text/javascript">
    $(document).ready(function(){
        $(".sm").each(function(){
            $(this).click(function(){
                var mod = $(this).data("mod");
                    $.php("app/supermode/" + mod);
            });
        });
    });
</script>