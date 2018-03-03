<h3>Ждем игроков</h3>

<div class="tables" id="table_<?= $offerta->id ?>">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <b>Table:</b>
                    <?= $offerta->id ?>
                    <b>Bullet:</b>
                    <?= $offerta->bullet ?>
                    <b>Vist:</b>
                    <?= $offerta->vist ?>
                </div>

                <div class="panel-body">

                    <ul class="nav nav-tabs nav-justified">
                        <li>
                            <div class="well well-sm" style="margin-bottom:0">
                                <b>User 1:</b>
                                <?php if (isset($users[$offerta->user_id1])): ?>
                                    <?= $users[$offerta->user_id1]->nickname ?>
                                <?php else: ?>
                                    <span class="label label-warning">Free</span>
                                <?php endif; ?>
                            </div>
                        </li>
                        <li>
                            <div class="well well-sm" style="margin-bottom:0">
                                <b>User 2:</b>
                                <?php if (isset($users[$offerta->user_id2])): ?>
                                    <?= $users[$offerta->user_id2]->nickname ?>
                                <?php else: ?>
                                    <span class="label label-warning">Free</span>
                                <?php endif; ?>
                            </div>
                        </li>
                        <li>
                            <div class="well well-sm">
                                <b>User 3:</b>
                                <?php if (isset($users[$offerta->user_id3])): ?>
                                    <?= $users[$offerta->user_id3]->nickname ?>
                                <?php else: ?>
                                    <span class="label label-warning">Free</span>
                                <?php endif; ?>
                            </div>
                        </li>
                    </ul>                

                    <div class="progress">
                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%" data-min="<?= $offerta->time_create ?>" data-max="<?= $offerta->time_die ?>"></div>
                    </div>

                    <button class="btn btn-danger">
                        Exit Table 45
                    </button>

                </div>
            </div>        
        </div>
    </div>
</div>


<script type="text/javascript">
    $(window).ready(function () {
        le = <?= $le ?>;
        now = <?= $now ?>;
        $("body").css("background-color", "#88ffff");
        PBcorrector();
        tick();
    });
</script>
