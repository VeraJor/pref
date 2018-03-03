<!-- #### LEFT-INFO #### -->
<?php if (!empty($leftInfo)): ?>
    <div id="leftInfo">
        <div class="nickname">
            <?= $leftInfo->nickname ?>
            <?php if (!empty($leftInfo->status)): ?>
                <span class="label label-danger">
                    <?= $leftInfo->status ?>
                </span>
            <?php endif; ?>
        </div>
        <?php if (!empty($leftInfo->torg)): ?>
            <div class="torg label label-info">
                <?= $leftInfo->torg ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>


<!-- #### PRIKUP #### -->
<?php if (!empty($prikup)): ?>
    <?php foreach ($prikup as $card): ?>
        <img src="/images/cards2/<?= $card ?>.jpg" class="prikup" />
    <?php endforeach; ?>
<?php endif; ?>


<!-- #### RIGHT-INFO #### -->
<?php if (!empty($rightInfo)): ?>
    <div id="rightInfo">
        <div class="nickname">
            <?php if (!empty($rightInfo->status)): ?>
                <span class="label label-danger">
                    <?= $rightInfo->status ?>
                </span>
            <?php endif; ?>
            <?= $rightInfo->nickname ?>
        </div>
        <?php if (!empty($rightInfo->torg)): ?>
            <div>
                <div class="torg label label-info">
                    <?= $rightInfo->torg ?>
                </div>
            </div>            
        <?php endif; ?>
    </div>            
<?php endif; ?>


<!-- #### LEFT-CARDS #### -->
<?php if (!empty($leftCardsCount)): ?>
    <?php for ($x = 0; $x < $leftCardsCount; $x++): ?>
        <img src="/images/cards2/bg.jpg" class="leftCard" />
    <?php endfor; ?>
<?php endif; ?>


<!-- #### RIGHT-CARDS #### -->
<?php if (!empty($rightCardsCount)): ?>
    <?php for ($x = 0; $x < $rightCardsCount; $x++): ?>
        <img src="/images/cards2/bg.jpg" class="rightCard" />
    <?php endfor; ?>
<?php endif; ?>


<!-- #### I-INFO #### -->
<?php if (!empty($iInfo)): ?>
    <div id="iInfo">
        <div class="nickname">
            <?= $iInfo->nickname ?>
        </div>
        <div class="torg label label-info">
            <?= $iInfo->torg ?>
        </div>
    </div>
<?php endif; ?>


<!-- #### I-COMMANDS #### -->
<?php if (!empty($iCommands)): ?>
    <div id="iCommands">

        <div class="list-group">
            <a href="#" class="list-group-item disabled">
                <h4 class="list-group-item-heading">Your Choice Please!</h4>
            </a>
            <?php foreach ($iCommands as $choice): ?>
                <button type="button" class="list-group-item step" data-choice="<?= $choice ?>">
                    <?= $choice ?>
                </button>
            <?php endforeach; ?>
        </div>

        <?php foreach ($iCommands as $choice): ?>
            <button class="btn btn-danger btn-block step" data-choice="<?= $choice ?>">
                <?= $choice ?>
            </button>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- #### I-CARDS #### -->
<?php if (!empty($iCards)): ?>
    <?php foreach ($iCards as $card): ?>
        <img src="/images/cards2/<?= $card ?>.jpg" class="iCard" />
    <?php endforeach; ?>
<?php endif; ?>


<script type="text/javascript">
    $(window).ready(function () {
        le = <?= $le ?>;
        tick();

        $(".step").on("click", function () {
            var choice = $(this).data("choice");
            $.php("app/bullet/choice/", {choice: choice});
            $(".step").attr("disabled", "disabled");
        });

        // поднять bottom left и right на высоту i
        var h = $("#i").outerHeight();
        $("#left,#right").css("bottom", h + "px")

        // Цвет игры
        $("body").css("background-color", "#88ff88");

        cardsArrange();
        $(window).resize(function () {
            cardsArrange();
        });
    });
</script>