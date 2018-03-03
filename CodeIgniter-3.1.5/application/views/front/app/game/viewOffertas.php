<div class="we ll wel l-sm">

    <button class="btn btn-success" onclick="$.php('app/game/create_table')">
        Create Your Table
    </button>

    <br />

    Or Join to Existing.

    Sort by: table
    <div class="btn-group">
        <button class="btn btn-primary btn-xs">
            <span class="glyphicon glyphicon-sort-by-attributes"></span>
        </button>
        <button class="btn btn-default btn-xs">
            <span class="glyphicon glyphicon-sort-by-attributes-alt"></span>
        </button>
    </div>
</div>


<?php if (!empty($offertas)): ?>
    <?php foreach ($offertas as $o): ?>

        <div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <button class="btn btn-success" onclick="$.php('app/game/join_table/<?= $o->id ?>')">
                                Join Table <?= $o->id ?>
                            </button>
                            <b>Bullet:</b>
                            <?= $o->bullet ?>
                            <b>Vist:</b>
                            <?= $o->vist ?>
                        </div>
                        <div class="panel-body">

                            <ul class="nav nav-tabs nav-justified">
                                <li>
                                    <div class="well well-sm" style="margin-bottom:0">
                                        <b>Owner:</b>
                                        <?php if (isset($users[$o->user_id1])): ?>
                                            <?= $users[$o->user_id1]->nickname ?>
                                        <?php else: ?>
                                            <span class="label label-warning">Free</span>
                                        <?php endif; ?>
                                    </div>
                                </li>
                                <li>
                                    <div class="well well-sm" style="margin-bottom:0">
                                        <b>User 2:</b>
                                        <?php if (isset($users[$o->user_id2])): ?>
                                            <?= $users[$o->user_id2]->nickname ?>
                                        <?php else: ?>
                                            <span class="label label-warning">Free</span>
                                        <?php endif; ?>
                                    </div>
                                </li>
                                <li>
                                    <div class="well well-sm">
                                        <b>User 3:</b>
                                        <?php if (isset($users[$o->user_id3])): ?>
                                            <?= $users[$o->user_id3]->nickname ?>
                                        <?php else: ?>
                                            <span class="label label-warning">Free</span>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            </ul>                

                            <div class="progress">
                                <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%" data-min="<?= $o->time_create ?>" data-max="<?= $o->time_die ?>"></div>
                            </div>

                        </div>
                    </div>        
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>


<script type="text/javascript">
    $(window).ready(function () {
        le = <?= $le ?>;
        now = <?= $now ?>;
        $("body").css("background-color", "white");
        PBcorrector();
        tick();
    });
</script>


