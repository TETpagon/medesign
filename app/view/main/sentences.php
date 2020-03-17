<h1>Сгенерированные предложения</h1>
<ul>
    <?php foreach ($sentences as $sentence) {?>
            <ol class="ol-sentence">
                <b>
                    <?php echo $sentence['created'];?>
                </b>
                <span class="sentence">
                    <?php echo $sentence['sentence'];?>
                </span>
            </ol>
    <?php }?>
</ul>
